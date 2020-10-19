<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Settings\LocationSettings;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class LocationSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function location_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        $this->get(route('admin.settings.general'))
            ->assertSeeLivewire('admin.settings.location-settings');
    }

    /** @test*/
    public function superadmin_can_add_location()
    {
        $name = 'Imphal West';

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(LocationSettings::class)
            ->set('name', $name)
            ->set('identifier', Str::kebab($name))
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertDatabaseHas('locations', [
            'name' => 'Imphal West',
            'identifier' => Str::kebab($name)
        ]);
    }

    /** @test*/
    public function admin_cannot_add_location()
    {
        $name = 'Imphal West';

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(LocationSettings::class)
            ->set('name', $name)
            ->set('identifier', Str::kebab($name))
            ->call('save')
            ->assertForbidden();

        $this->assertDatabaseMissing('locations', [
            'name' => 'Imphal West',
            'identifier' => Str::kebab($name)
        ]);
    }

    /** @test*/
    public function superadmin_can_update_location()
    {
        $location = Location::create([
            'name' => 'Imphal West',
            'identifier' => 'imphal-west'
        ]);
        $newName = 'Imphal East';

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(LocationSettings::class)
            ->set('editLocation', $location)
            ->set('name', $newName)
            ->set('identifier', Str::kebab($newName))
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => $newName,
            'identifier' => Str::kebab($newName)
        ]);
    }

    /** @test*/
    public function admin_cannot_update_location()
    {
        $data = [
            'name' => 'Imphal West',
            'identifier' => 'imphal-west'
        ];
        $location = Location::create($data);
        $newName = 'Imphal East';

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(LocationSettings::class)
            ->set('editLocation', $location)
            ->set('name', $newName)
            ->set('identifier', Str::kebab($newName))
            ->call('save')
            ->assertForbidden();

        $this->assertDatabaseMissing('locations', [
            'id' => $location->id,
            'name' => $newName,
            'identifier' => Str::kebab($newName)
        ]);
        $this->assertDatabaseHas('locations', $data);
    }

    /** @test*/
    public function superadmin_can_delete_location()
    {
        $data = [
            'name' => 'Imphal West',
            'identifier' => 'imphal-west',
        ];
        $location = Location::create($data);

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(LocationSettings::class)
            ->set('deleteLocation', Location::find($location->id))
            ->call('delete')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertDatabaseMissing('locations', $data);
    }

    /** @test*/
    public function admin_cannot_delete_location()
    {
        $data = [
            'name' => 'Imphal West',
            'identifier' => 'imphal-west',
        ];
        $location = Location::create($data);

        Livewire::actingAs(User::factory()->create(['role' => 'admin']))
            ->test(LocationSettings::class)
            ->set('deleteLocation', Location::find($location->id))
            ->call('delete');

        $this->assertDatabaseHas('locations', $data);
    }
}
