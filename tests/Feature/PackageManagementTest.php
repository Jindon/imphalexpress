<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\ManagePackages;
use App\Models\Business;
use App\Models\Location;
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PackageManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function general_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->get(route('admin.packages'))
            ->assertSeeLivewire('admin.manage-packages');
    }

    /** @test*/
    public function admin_can_add_package()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(ManagePackages::class)
            ->set('location_id', $location->id)
            ->set('business_id', $business->id)
            ->set('tracking_id', 'IMEX001')
            ->set('delivery_address', 'Test address')
            ->set('delivery_contact', '9999999999')
            ->set('collected_on', now()->format('d/m/Y'))
            ->set('deliver_by', now()->addDays(5)->format('d/m/Y'))
            ->set('status', 'processing')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Package::whereTrackingId('IMEX001')
            ->whereLocationId($location->id)
            ->whereBusinessId($business->id)
            ->exists());
    }

    /** @test*/
    public function admin_can_update_package()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);
        $editPackage = Package::factory()->create([
            'location_id' => $location->id,
            'business_id' => $business->id,
            'tracking_id' => 'IMEX001'
        ]);
        $user = User::factory()->create(['location_id' => $location->id, 'role' => 'admin']);

        Livewire::actingAs($user)
            ->test(ManagePackages::class)
            ->set('editPackage', $editPackage)
            ->set('location_id', $location->id)
            ->set('business_id', $business->id)
            ->set('tracking_id', 'IMEX002')
            ->set('delivery_address', 'Test address')
            ->set('delivery_contact', '9999999999')
            ->set('collected_on', now()->format('d/m/Y'))
            ->set('deliver_by', now()->addDays(5)->format('d/m/Y'))
            ->set('status', 'processing')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Package::whereTrackingId('IMEX002')
            ->whereLocationId($location->id)
            ->whereBusinessId($business->id)
            ->exists());
        $this->assertFalse(Package::whereTrackingId('IMEX001')->exists());
    }

    /** @test*/
    public function admin_can_change_package_status()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);
        $editPackage = Package::factory()->create([
            'location_id' => $location->id,
            'business_id' => $business->id,
            'tracking_id' => 'IMEX001',
            'status' => 'dispatched'
        ]);
        $user = User::factory()->create(['location_id' => $location->id, 'role' => 'admin']);

        Livewire::actingAs($user)
            ->test(ManagePackages::class)
            ->set('editPackage', $editPackage)
            ->set('changeStatus', 'delivered')
            ->set('collected_on', now()->format('d/m/Y'))
            ->set('deliver_by', now()->addDays(5)->format('d/m/Y'))
            ->set('reached_location_on', now()->addDays(1)->format('d/m/Y'))
            ->set('out_for_delivery_on', now()->addDays(2)->format('d/m/Y'))
            ->set('delivered_on', now()->addDays(5)->format('d/m/Y'))
            ->call('changeStatus')
            ->assertDispatchedBrowserEvent('notify');
        $editPackage->fresh();

        $this->assertTrue(Package::find($editPackage->id)->status === 'delivered');
    }

    /** @test*/
    public function admin_can_delete_package()
    {
        $location = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location->id]);
        $deletePackage = Package::factory()->create([
            'location_id' => $location->id,
            'business_id' => $business->id,
            'tracking_id' => 'IMEX001',
            'status' => 'dispatched'
        ]);
        $user = User::factory()->create(['location_id' => $location->id, 'role' => 'admin']);

        Livewire::actingAs($user)
            ->test(ManagePackages::class)
            ->set('deleteId', $deletePackage->id)
            ->call('delete')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(Package::whereKey($deletePackage->id)->exists());
    }

    /** @test*/
    public function admin_can_delete_selected_package()
    {
        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();
        $business = Business::factory()->create(['location_id' => $location1->id]);
        $package1 = Package::factory()->create([
            'location_id' => $location2->id,
            'business_id' => $business->id,
            'tracking_id' => 'IMEX001',
        ]);
        $package2 = Package::factory()->create([
            'location_id' => $location1->id,
            'business_id' => $business->id,
            'tracking_id' => 'IMEX002',
        ]);
        $package3 = Package::factory()->create([
            'location_id' => $location2->id,
            'business_id' => $business->id,
            'tracking_id' => 'IMEX003',
        ]);

        $this->assertTrue(Package::whereKey($package1->id)->exists());
        $this->assertTrue(Package::whereKey($package2->id)->exists());
        $this->assertTrue(Package::whereKey($package3->id)->exists());
        $this->assertDatabaseCount('packages', 3);

        $user = User::factory()->create(['location_id' => $location1->id, 'role' => 'admin']);

        Livewire::actingAs($user)
            ->test(ManagePackages::class)
            ->set('selected', ["$package1->id","$package2->id"])
            ->call('deleteSelected')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(Package::whereKey($package1->id)->exists());
        $this->assertFalse(Package::whereKey($package2->id)->exists());
        $this->assertTrue(Package::whereKey($package3->id)->exists());

        $this->assertDatabaseCount('packages', 1);
    }
}
