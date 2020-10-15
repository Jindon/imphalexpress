<?php

namespace App\Http\Livewire;

use App\Models\Settings;
use Livewire\Component;

class GeneralSettings extends Component
{
    public $siteName;
    public $contactNumber;
    public $callbackEmail;

    public function mount()
    {
        $this->siteName = Settings::whereIdentifier('site-name')->first()->value;
        $this->contactNumber = Settings::whereIdentifier('contact-number')->first()->value;
        $this->callbackEmail = Settings::whereIdentifier('callback-email')->first()->value;
    }

    public function save()
    {
        Settings::whereIdentifier('site-name')->update(['value' => $this->siteName]);
        Settings::whereIdentifier('contact-number')->update(['value' => $this->contactNumber]);
        Settings::whereIdentifier('callback-email')->update(['value' => $this->callbackEmail]);

        $this->emit('alert');
    }

    public function render()
    {
        return view('livewire.general-settings');
    }
}
