<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Settings\UserSettings;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function user_settings_livewire_component_is_present()
    {
        $this->actingAs(User::factory()->create(['role' => 'superadmin']));

        $this->get(route('admin.settings.users'))
            ->assertSeeLivewire('admin.settings.user-settings');
    }

    /** @test*/
    public function superadmin_can_add_user()
    {
        $location = Location::factory()->create();

        Livewire::actingAs(User::factory()->create(['role' => 'superadmin']))
            ->test(UserSettings::class)
            ->set('location_id', $location->id)
            ->set('name', 'Test user')
            ->set('phone', '9999999999')
            ->set('email', 'test@mail.com')
            ->set('password', 'welcome')
            ->set('status', '1')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(User::whereName('Test user')
            ->whereLocationId($location->id)
            ->whereEmail('test@mail.com')
            ->exists());
    }

    /** @test*/
    public function superadmin_can_update_user()
    {
        $location = Location::factory()->create();
        $user = User::factory()->create([
            'name' => 'Test 1',
            'email' => 'test1@email.com',
            'location_id' => $location->id,
            'role' => 'admin'
        ]);
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        Livewire::actingAs($superadmin)
            ->test(UserSettings::class)
            ->set('editUser', $user)
            ->set('editId', $user->id)
            ->set('location_id', $location->id)
            ->set('name', 'Test user')
            ->set('email', $user->email)
            ->set('phone', $user->phone)
            ->set('status', '1')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(User::whereName('Test user')->whereLocationId($location->id)->exists());
        $this->assertTrue(User::whereLocationId($location->id)->count() === 1);
    }

    /** @test*/
    public function superadmin_can_update_user_password()
    {
        $location = Location::factory()->create();
        $user = User::factory()->create([
            'name' => 'Test 1',
            'email' => 'test1@email.com',
            'location_id' => $location->id,
            'role' => 'admin'
        ]);
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        Livewire::actingAs($superadmin)
            ->test(UserSettings::class)
            ->set('editUser', $user)
            ->set('editId', $user->id)
            ->set('location_id', $location->id)
            ->set('name', 'Test user')
            ->set('email', $user->email)
            ->set('phone', $user->phone)
            ->set('password', 'newpassword')
            ->set('status', '1')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(Hash::check('newpassword', User::find($user->id)->password));
    }

    /** @test*/
    public function superadmin_can_update_status()
    {
        $location = Location::factory()->create();
        $user = User::factory()->create(['location_id' => $location->id]);
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        Livewire::actingAs($superadmin)
            ->test(UserSettings::class)
            ->call('changeStatus', $user, 0)
            ->assertDispatchedBrowserEvent('notify');

        $this->assertTrue(User::find($user->id)->status == 0);
    }

    /** @test*/
    public function superadmin_can_delete_user()
    {
        $location = Location::factory()->create();
        $user = User::factory()->create(['location_id' => $location->id]);
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        Livewire::actingAs($superadmin)
            ->test(UserSettings::class)
            ->set('deleteId', $user->id)
            ->call('delete')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(User::whereId($user->id)->exists());
    }

    /** @test*/
    public function superadmin_can_delete_selected_user()
    {
        $location = Location::factory()->create();
        $user1 = User::factory()->create(['location_id' => $location->id]);
        $user2 = User::factory()->create(['location_id' => $location->id]);
        $user3 = User::factory()->create(['location_id' => $location->id]);
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        Livewire::actingAs($superadmin)
            ->test(UserSettings::class)
            ->set('selected', ["$user1->id", "$user2->id"])
            ->call('deleteSelected')
            ->assertDispatchedBrowserEvent('notify');

        $this->assertFalse(User::whereId($user1->id)->exists());
        $this->assertFalse(User::whereId($user2->id)->exists());
        $this->assertTrue(User::whereId($user3->id)->exists());
    }
}
