<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Settings\BusinessSettings;
use App\Models\Business;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BusinessSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function general_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        $this->get(route('admin.settings.businesses'))
            ->assertSeeLivewire('admin.settings.business-settings');
    }

    /** @test*/
    public function superadmin_can_add_business()
    {
        $location = Location::factory()->create();

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(BusinessSettings::class)
            ->set('location_id', $location->id)
            ->set('name', 'Test business')
            ->set('phone', '9999999999')
            ->set('address', 'Test address')
            ->set('status', '1')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Business::whereName('Test business')->whereLocationId($location->id)->exists());
    }

    /** @test*/
    public function admin_cannot_add_business()
    {
        $location = Location::factory()->create();

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(BusinessSettings::class)
            ->set('location_id', $location->id)
            ->set('name', 'Test business')
            ->set('phone', '9999999999')
            ->set('address', 'Test address')
            ->set('status', '1')
            ->call('save')
            ->assertForbidden();

        $this->assertFalse(Business::whereName('Test business')->whereLocationId($location->id)->exists());
    }

    /** @test*/
    public function superadmin_can_update_business()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(BusinessSettings::class)
            ->set('editBusiness', $business)
            ->set('location_id', $location->id)
            ->set('name', 'Test business')
            ->set('phone', '9999999999')
            ->set('address', 'Test address')
            ->set('status', '1')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Business::whereName('Test business')->whereLocationId($location->id)->exists());
        $this->assertTrue(Business::whereLocationId($location->id)->count() === 1,true);
    }

    /** @test*/
    public function admin_cannot_update_business()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(BusinessSettings::class)
            ->set('editBusiness', $business)
            ->set('location_id', $location->id)
            ->set('name', 'Test business')
            ->set('phone', '9999999999')
            ->set('address', 'Test address')
            ->set('status', '1')
            ->call('save')
            ->assertForbidden();

        $this->assertTrue(Business::whereId($business->id)->first()->name === $business->name);
    }

    /** @test*/
    public function superadmin_can_change_business_status()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(BusinessSettings::class)
            ->call('changeStatus', $business, '0')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Business::whereId($business->id)->whereStatus('0')->exists());
    }

    /** @test*/
    public function admin_cannot_change_business_status()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(BusinessSettings::class)
            ->call('changeStatus', $business, '0')
            ->assertForbidden();

        $this->assertTrue(Business::find($business->id)->status === '1');
    }

    /** @test*/
    public function superadmin_can_delete_business()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(BusinessSettings::class)
            ->set('deleteId', $business->id)
            ->call('delete')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(Business::whereId($business->id)->exists());
    }

    /** @test*/
    public function admin_cannot_delete_business()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(BusinessSettings::class)
            ->set('deleteId', $business->id)
            ->call('delete')
            ->assertForbidden();

        $this->assertTrue(Business::whereId($business->id)->exists());
    }

    /** @test*/
    public function superadmin_can_delete_selected_businesses()
    {
        $location = Location::factory()->create();
        $business1 = Business::factory()->create(['location_id' => $location->id]);
        $business2 = Business::factory()->create(['location_id' => $location->id]);
        $business3 = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(BusinessSettings::class)
            ->set('selected', ["$business1->id", "$business2->id"])
            ->call('deleteSelected')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(Business::whereId($business1->id)->exists());
        $this->assertFalse(Business::whereId($business2->id)->exists());
        $this->assertTrue(Business::whereId($business3->id)->exists());
    }

    /** @test*/
    public function admin_cannot_delete_selected_businesses()
    {
        $location = Location::factory()->create();
        $business1 = Business::factory()->create(['location_id' => $location->id]);
        $business2 = Business::factory()->create(['location_id' => $location->id]);
        $business3 = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(BusinessSettings::class)
            ->set('selected', ["$business1->id", "$business2->id"])
            ->call('deleteSelected')
            ->assertForbidden();

        $this->assertTrue(Business::whereId($business1->id)->exists());
        $this->assertTrue(Business::whereId($business2->id)->exists());
        $this->assertTrue(Business::whereId($business3->id)->exists());
    }
}
