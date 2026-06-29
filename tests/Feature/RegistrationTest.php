<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'lastname' => 'Dupont',
            'firstname' => 'Jean',
            'phone' => '+33612345678',
            'email' => 'jean@example.com',
            'password' => 'Strong1@pass',
        ], $overrides);
    }

    public function test_register_page_is_accessible(): void
    {
        $this->get('/register')->assertOk();
    }

    public function test_a_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', $this->validData());

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'jean@example.com',
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
        ]);
    }

    public function test_registration_rejects_a_weak_password(): void
    {
        $response = $this->post('/register', $this->validData(['password' => 'faible']));

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'jean@example.com']);
    }

    public function test_registration_rejects_a_duplicate_email(): void
    {
        User::factory()->create(['email' => 'jean@example.com']);

        $response = $this->post('/register', $this->validData());

        $response->assertSessionHasErrors('email');
    }
}
