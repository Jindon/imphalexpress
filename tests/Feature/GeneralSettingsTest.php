<?php

namespace Tests\Feature;

use App\Http\Livewire\GeneralSettings;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class GeneralSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function general_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        $this->get(route('admin.settings.general'))->assertSeeLivewire('general-settings');
    }

    /** @test  */
    function superadmin_can_save_general_settings()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        Settings::create(['identifier' => 'site-name', 'value' => 'Imphal Express']);
        Settings::create(['identifier' => 'contact-number', 'value' => '7896541230']);
        Settings::create(['identifier' => 'callback-email', 'value' => 'email@mail.com']);

        $siteName = 'Test site';
        $contactNumber = '1234567890';
        $callbackEmail = 'test@email.com';

        $livewire = Livewire::test(GeneralSettings::class)
            ->set('siteName', $siteName)
            ->set('contactNumber', $contactNumber)
            ->set('callbackEmail', $callbackEmail)
            ->call('save');

        $livewire->assertDispatchedBrowserEvent('notify');
        $this->assertTrue(Settings::whereIdentifier('site-name')->whereValue($siteName)->exists());
        $this->assertTrue(Settings::whereIdentifier('contact-number')->whereValue($contactNumber)->exists());
        $this->assertTrue(Settings::whereIdentifier('callback-email')->whereValue($callbackEmail)->exists());
    }

    /** @test  */
    function admin_cannot_save_general_settings()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Settings::create(['identifier' => 'site-name', 'value' => 'Imphal Express']);
        Settings::create(['identifier' => 'contact-number', 'value' => '7896541230']);
        Settings::create(['identifier' => 'callback-email', 'value' => 'email@mail.com']);

        $siteName = 'Test site';
        $contactNumber = '1234567890';
        $callbackEmail = 'test@email.com';

        $livewire = Livewire::test(GeneralSettings::class)
            ->set('siteName', $siteName)
            ->set('contactNumber', $contactNumber)
            ->set('callbackEmail', $callbackEmail)
            ->call('save');

        $livewire->assertForbidden();
        $this->assertFalse(Settings::whereIdentifier('site-name')->whereValue($siteName)->exists());
        $this->assertFalse(Settings::whereIdentifier('contact-number')->whereValue($contactNumber)->exists());
        $this->assertFalse(Settings::whereIdentifier('callback-email')->whereValue($callbackEmail)->exists());
    }
}
