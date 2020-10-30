<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\DeliveryPricing;
use App\Models\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Pricing extends Component
{
    use AuthorizesRequests;

    public $from_id;
    public $to_id;
    public $price;
    public $deletePricing = null;
    public $deleteConfirmation = false;

    protected $rules = [
        'from_id' => 'required',
        'to_id' => 'required',
        'price' => 'required|numeric',
    ];

    protected $validationAttributes = [
        'from_id' => 'From location',
        'to_id' => 'To location',
    ];

    public function confirmDelete(DeliveryPricing $pricing)
    {
        $this->deletePricing = $pricing;
        $this->deleteConfirmation = true;
    }

    public function cancelDelete()
    {
        $this->deletePricing = null;
        $this->deleteConfirmation = false;
    }

    public function delete()
    {
        $this->authorize('settings');
        $this->deletePricing->delete();
        $this->deletePricing = null;
        $this->deleteConfirmation = false;
        $this->notify('Pricing deleted successfully!');
    }

    public function save(){
        $this->authorize('settings');
        $data = $this->validate();

        $query = DeliveryPricing::whereIn('from_id', [$this->from_id, $this->to_id])
        ->whereIn('to_id', [$this->from_id, $this->to_id]);

        if($query->exists()) {
            $pricing = $query->first();
            $pricing->price = $data['price'];
            $pricing->save();
        } else {
            DeliveryPricing::create($data);
        }

        $this->reset();

        $this->notify('Pricing saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings.pricing', [
            'locations' => Location::all(),
            'deliveryPricing' => DeliveryPricing::query()
                                ->when($this->from_id || $this->to_id, function($query) {
                                    $query->whereIn('from_id', [$this->from_id, $this->to_id])
                                        ->orWhereIn('to_id', [$this->from_id, $this->to_id]);
                                })->get(),
        ]);
    }
}
