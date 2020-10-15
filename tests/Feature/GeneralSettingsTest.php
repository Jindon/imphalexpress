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
    /** @test  */
    function can_create_post()
    {
        $this->actingAs(User::factory()->create());

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

        $livewire->assertEmitted('alert');
        $this->assertTrue(Settings::whereIdentifier('site-name')->whereValue($siteName)->exists());
        $this->assertTrue(Settings::whereIdentifier('contact-number')->whereValue($contactNumber)->exists());
        $this->assertTrue(Settings::whereIdentifier('callback-email')->whereValue($callbackEmail)->exists());
    }
}
