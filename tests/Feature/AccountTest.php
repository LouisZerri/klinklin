<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_update_their_profile(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('account.profile.update'), [
            'firstname' => 'Nouveau',
            'lastname' => 'Nom',
            'email' => 'nouveau@example.com',
            'phone' => '+33700000000',
            'language' => 'français',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firstname' => 'Nouveau',
            'email' => 'nouveau@example.com',
        ]);
    }

    public function test_profile_update_validates_the_email(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('account.profile.update'), [
            'firstname' => 'Nouveau',
            'lastname' => 'Nom',
            'email' => 'pas-un-email',
            'phone' => '+33700000000',
            'language' => 'français',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_update_requires_the_correct_current_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['password' => Hash::make('Current1@pass')]);

        $response = $this->actingAs($user)->put(route('account.security.update'), [
            'current_password' => 'wrong-current',
            'password' => 'NewStrong1@pass',
            'password_confirmation' => 'NewStrong1@pass',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('Current1@pass', $user->fresh()->password));
    }

    public function test_a_user_can_change_their_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['password' => Hash::make('Current1@pass')]);

        $this->actingAs($user)->put(route('account.security.update'), [
            'current_password' => 'Current1@pass',
            'password' => 'NewStrong1@pass',
            'password_confirmation' => 'NewStrong1@pass',
        ]);

        $this->assertTrue(Hash::check('NewStrong1@pass', $user->fresh()->password));
    }
}
