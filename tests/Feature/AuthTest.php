<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'welcome27'
        ]);
        $response->assertRedirect('/');
        $this->assertTrue(Auth::check());
        $this->assertAuthenticatedAs($user);
    }
}
