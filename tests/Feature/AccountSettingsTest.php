<?php

namespace Tests\Feature;

use App\Http\Livewire\AccountSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AccountSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function account_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        $this->get(route('admin.settings.account'))->assertSeeLivewire('account-settings');
    }

    /** @test*/
    public function admin_can_update_account_details()
    {
        $updateData = [
            'name' => 'Updated name',
            'email' => 'updated@email.com',
            'phone' => '0987654321',
        ];
        Livewire::actingAs(User::factory()->create([
            'name' => 'Initial name',
            'email' => 'initial@email.com',
            'phone' => '1234567890',
        ]))->test(AccountSettings::class)
            ->set('name', $updateData['name'])
            ->set('email', $updateData['email'])
            ->set('phone', $updateData['phone'])
            ->call('saveInfo')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertEquals($updateData['name'], auth()->user()->name);
        $this->assertEquals($updateData['email'], auth()->user()->email);
        $this->assertEquals($updateData['phone'], auth()->user()->phone);
    }

    /** @test*/
    public function admin_can_update_account_password()
    {
        $newPassword = '123456';
        $currentPassword = 'abcdefg';
        Livewire::actingAs(User::factory()->create(['password' => Hash::make($currentPassword)]))
            ->test(AccountSettings::class)
            ->set('newPassword', $newPassword)
            ->set('currentPassword', $currentPassword)
            ->call('updatePassword')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Hash::check($newPassword, auth()->user()->getAuthPassword()));
    }
}
