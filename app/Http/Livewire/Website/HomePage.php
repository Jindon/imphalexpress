<?php

namespace App\Http\Livewire\Website;

use App\Models\ContactMessage;
use Livewire\Component;

class HomePage extends Component
{
    public $name;
    public $phone;
    public $message;

    protected $rules = [
        'name' => 'required|max:125',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        'message' => 'sometimes',
    ];

    public function updatedPhone($value)
    {
        if($value) {
            $this->validateOnly('phone');
        } else {
            $this->resetErrorBag('phone');
        }
    }

    public function saveMessage()
    {
        $data = $this->validate();
        try {
            ContactMessage::create($data);
            $this->reset();

            $this->notify('Request for callback made successfully');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function render()
    {
        return view('livewire.website.home-page');
    }
}
