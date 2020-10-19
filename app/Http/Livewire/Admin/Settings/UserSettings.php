<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;

class UserSettings extends Component
{
    public function render()
    {
        return view('livewire.admin.settings.user')
            ->layout('layouts.settings');
    }
}
