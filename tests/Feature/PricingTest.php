<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Settings\Pricing;
use App\Models\DeliveryPricing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PricingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pricing_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        $this->get(route('admin.settings.pricing'))
            ->assertSeeLivewire('admin.settings.pricing');
    }

    /** @test*/
    public function superadmin_can_add_pricing()
    {
        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(Pricing::class)
            ->set('from_id', $location1->id)
            ->set('to_id', $location2->id)
            ->set('price', '50')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(DeliveryPricing::whereFromId($location1->id)
                        ->whereToId($location2->id)
                        ->wherePrice('5000')
                        ->exists());
    }


    /** @test*/
    public function superadmin_can_update_pricing_if_entry_already_exists()
    {
        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();

        $pricing = DeliveryPricing::create([
            'from_id' => $location1->id,
            'to_id' => $location2->id,
            'price' => '40'
        ]);

        $this->assertTrue(DeliveryPricing::whereFromId($location1->id)
                        ->whereToId($location2->id)
                        ->wherePrice('4000')
                        ->exists());

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(Pricing::class)
            ->set('from_id', $location1->id)
            ->set('to_id', $location2->id)
            ->set('price', '50')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(DeliveryPricing::whereFromId($location1->id)
                        ->whereToId($location2->id)
                        ->wherePrice('5000')
                        ->exists());
        $this->assertTrue(DeliveryPricing::count() === 1);
    }

    /** @test*/
    public function superadmin_can_delete_pricing()
    {
        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();

        $pricing = DeliveryPricing::create([
            'from_id' => $location1->id,
            'to_id' => $location2->id,
            'price' => '40'
        ]);

        $this->assertTrue(DeliveryPricing::whereFromId($location1->id)
                        ->whereToId($location2->id)
                        ->wherePrice('4000')
                        ->exists());

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(Pricing::class)
            ->set('deletePricing', DeliveryPricing::find($pricing->id))
            ->call('delete')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(DeliveryPricing::whereFromId($location1->id)
                        ->whereToId($location2->id)
                        ->wherePrice('4000')
                        ->exists());
    }
}
