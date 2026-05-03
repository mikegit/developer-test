<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_log_in_with_configured_credentials(): void
    {
        $user = User::query()->firstWhere('email', config('setup.admin_email'));

        if (! $user) {
            $user = User::query()->create([
                'name' => config('setup.admin_name'),
                'email' => config('setup.admin_email'),
                'email_verified_at' => now(),
                'password' => Hash::make(config('setup.password')),
            ]);
        }

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => config('setup.password'),
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}
