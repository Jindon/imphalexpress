<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;

class LocationSettings extends Component
{
    use AuthorizesRequests;

    public $name;
    public $identifier;
    public $showForm = false;
    public $editLocation = null;
    public $deleteLocation = null;
    public $deleteConfirmation = false;

    protected $rules = [
        'name' => 'required',
        'identifier' => 'required',
    ];

    public function updatedName()
    {
        $this->identifier = Str::kebab($this->name);
    }

    public function openEdit(Location $location)
    {
        $this->editLocation = $location;
        $this->name = $location->name;
        $this->identifier = $location->identifier;
        $this->showForm = true;
    }

    public function save()
    {
        $this->authorize('settings');
        $data = $this->validate();
        isset($this->editLocation)
            ? $this->editLocation->update($data)
            : Location::create($data);

        $this->showForm = false;

        $message = isset($this->editLocation)
            ? 'Location updated successfully!'
            : 'New location added successfully';
        $this->dispatchBrowserEvent('notify', $message);
    }

    public function confirmDelete(Location $location)
    {
        $this->deleteLocation = $location;
        $this->deleteConfirmation = true;
    }

    public function cancelDelete()
    {
        $this->deleteLocation = null;
        $this->deleteConfirmation = false;
    }

    public function delete()
    {
        $this->authorize('settings');
        $this->deleteLocation->delete();
        $this->deleteLocation = null;
        $this->deleteConfirmation = false;
        $this->dispatchBrowserEvent('notify', 'Location deleted successfully!');
    }

    public function render()
    {
        return view('livewire.location-settings', [
            'locations' => Location::all(),
        ]);
    }
}
