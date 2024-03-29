<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Settings;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class GeneralSettings extends Component
{
    use AuthorizesRequests;

    public $siteName;
    public $contactNumber;
    public $callbackEmail;

    protected $rules = [
        'siteName' => 'required|min:6',
        'contactNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        'callbackEmail' => 'required|email',
    ];

    public function mount()
    {
        $this->siteName = Settings::whereIdentifier('site-name')->exists()
            ? Settings::whereIdentifier('site-name')->first()->value
            : null;
        $this->contactNumber = Settings::whereIdentifier('contact-number')->exists()
            ? Settings::whereIdentifier('contact-number')->first()->value
            : null;
        $this->callbackEmail = Settings::whereIdentifier('callback-email')->exists()
            ? Settings::whereIdentifier('callback-email')->first()->value
            : null;
    }

    public function save()
    {
        $this->authorize('settings');
        $this->validate();

        Settings::whereIdentifier('site-name')->update(['value' => $this->siteName]);
        Settings::whereIdentifier('contact-number')->update(['value' => $this->contactNumber]);
        Settings::whereIdentifier('callback-email')->update(['value' => $this->callbackEmail]);

        $this->notify('Settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings.general')
            ->layout('layouts.settings');
    }
}
