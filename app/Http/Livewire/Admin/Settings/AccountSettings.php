<?php

namespace App\Http\Livewire\Admin\Settings;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AccountSettings extends Component
{
    use AuthorizesRequests;

    public $name;
    public $phone;
    public $email;
    public $newPassword;
    public $currentPassword;
    public $showConfirmPasswordChange = false;

    protected function rules() { return [
        'name' => 'required|max:125',
        'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        'email' => 'required|email|unique:users,email,' . auth()->user()->id,
    ]; }

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->phone = auth()->user()->phone;
        $this->email = auth()->user()->email;
    }

    public function saveInfo()
    {
        $this->authorize('account');
        $this->validate();
        auth()->user()->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->notify('Account details updated successfully!');
    }

    public function updatePasswordConfirm()
    {
        $this->validate([
            'newPassword' => 'required|min:6'
        ]);
        $this->showConfirmPasswordChange = true;
    }

    public function updatePassword()
    {
        $this->authorize('account');
        if(Hash::check($this->currentPassword, auth()->user()->getAuthPassword())) {
            auth()->user()->update([
                'password' => Hash::make($this->newPassword)
            ]);
            $this->showConfirmPasswordChange = false;
            $this->reset(['newPassword', 'currentPassword']);
            $this->notify('Password updated successfully!');
        } else {
            $this->addError('currentPassword', 'Wrong password entered!');
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.account')
            ->layout('layouts.settings');
    }
}
