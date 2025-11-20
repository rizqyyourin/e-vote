<?php

use App\Models\User;
use App\Models\Voting;
use App\Models\Candidate;

describe('Authentication', function () {
    it('shows login page', function () {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    });

    it('shows register page', function () {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar');
    });

    it('can register as voter', function () {
        $response = $this->post('/register', [
            'name' => 'Test Voter',
            'email' => 'voter@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/voter/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'voter@test.com',
            'role' => 'voter',
        ]);
    });

    it('can login as admin and redirects to admin dashboard', function () {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    });

    it('can login as voter and redirects to voter dashboard', function () {
        $voter = User::factory()->create([
            'email' => 'voter@test.com',
            'role' => 'voter',
        ]);

        $response = $this->post('/login', [
            'email' => 'voter@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/voter/dashboard');
        $this->assertAuthenticatedAs($voter);
    });

    it('cannot login with invalid credentials', function () {
        $response = $this->post('/login', [
            'email' => 'nonexistent@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
    });

    it('can logout', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    });

    it('redirects unauthenticated users from admin dashboard', function () {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    });

    it('redirects unauthenticated users from voter dashboard', function () {
        $response = $this->get('/voter/dashboard');
        $response->assertRedirect('/login');
    });
});
