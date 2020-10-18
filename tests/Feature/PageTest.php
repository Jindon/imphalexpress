<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function visitors_can_view_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Request callback');
    }

    /** @test */
    public function visitors_can_view_track_page()
    {
        $response = $this->get('/track');
        $response->assertStatus(200);
        $response->assertSeeText('Track package');
    }

    /** @test */
    public function guest_cannot_see_admin_packages_page()
    {
        $response = $this->get(route('admin.packages'));
        $response->assertStatus(302);
    }

    /** @test */
    public function admin_can_see_packages_page()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get(route('admin.packages'));
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_see_admin_general_settings_page()
    {
        $response = $this->get(route('admin.settings.general'));
        $response->assertStatus(302);
    }

    /** @test */
    public function admin_cannot_see_admin_general_settings_page()
    {
        $response = $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get(route('admin.settings.general'));
        $response->assertStatus(302);
    }

    /** @test */
    public function superadmin_can_see_admin_general_settings_page()
    {
        $response = $this->actingAs(User::factory()->create(['role' => 'superadmin']))
            ->get(route('admin.settings.general'));
        $response->assertStatus(200);
    }

}
