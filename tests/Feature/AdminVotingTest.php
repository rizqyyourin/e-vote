<?php

use App\Models\User;
use App\Models\Voting;
use App\Models\Candidate;
use Carbon\Carbon;

describe('Admin Voting Management', function () {
    beforeEach(function () {
        $this->admin = User::factory()->create(['role' => 'admin']);
    });

    it('admin can access dashboard', function () {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin');
    });

    it('voter cannot access admin dashboard', function () {
        $voter = User::factory()->create(['role' => 'voter']);
        $response = $this->actingAs($voter)->get('/admin/dashboard');
        $response->assertStatus(403);
    });

    it('admin can view create voting form', function () {
        $response = $this->actingAs($this->admin)->get('/admin/voting/create');
        $response->assertStatus(200);
        $response->assertSee('Buat Voting Baru');
    });

    it('admin can create voting with candidates', function () {
        $voting = Voting::create([
            'admin_id' => $this->admin->id,
            'title' => 'Pemilihan Ketua OSIS',
            'description' => 'Pilih ketua OSIS 2025',
            'status' => 'draft',
            'top_results' => 3,
        ]);

        Candidate::create([
            'voting_id' => $voting->id,
            'name' => 'Kandidat A',
            'order' => 1,
        ]);

        Candidate::create([
            'voting_id' => $voting->id,
            'name' => 'Kandidat B',
            'order' => 2,
        ]);

        $this->assertDatabaseHas('votings', [
            'title' => 'Pemilihan Ketua OSIS',
            'admin_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals(2, $voting->candidates()->count());
    });

    it('admin can view voting detail', function () {
        $voting = Voting::factory()->create(['admin_id' => $this->admin->id]);
        Candidate::factory(2)->create(['voting_id' => $voting->id]);

        $response = $this->actingAs($this->admin)->get("/admin/voting/{$voting->id}");
        $response->assertStatus(200);
        $response->assertSee($voting->title);
    });

    it('admin cannot view other admin voting', function () {
        $otherAdmin = User::factory()->create(['role' => 'admin']);
        $voting = Voting::factory()->create(['admin_id' => $otherAdmin->id]);

        $response = $this->actingAs($this->admin)->get("/admin/voting/{$voting->id}");
        $response->assertStatus(403);
    });

    it('admin can start voting', function () {
        $voting = Voting::factory()->create([
            'admin_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $voting->update([
            'status' => 'active',
            'starts_at' => now(),
        ]);

        $this->assertEquals('active', $voting->fresh()->status);
        $this->assertNotNull($voting->fresh()->starts_at);
    });

    it('admin can finish voting', function () {
        $voting = Voting::factory()->create([
            'admin_id' => $this->admin->id,
            'status' => 'active',
            'starts_at' => now(),
        ]);

        $voting->update([
            'status' => 'finished',
            'ends_at' => now(),
        ]);

        $this->assertEquals('finished', $voting->fresh()->status);
        $this->assertNotNull($voting->fresh()->ends_at);
    });

    it('admin can view voting results', function () {
        $voting = Voting::factory()->create(['admin_id' => $this->admin->id]);
        $candidate = Candidate::factory()->create(['voting_id' => $voting->id]);

        $voter = User::factory()->create(['role' => 'voter']);
        $voting->votes()->create([
            'candidate_id' => $candidate->id,
            'voter_id' => $voter->id,
        ]);

        $this->assertEquals(1, $voting->votes()->count());
        $this->assertEquals(1, $candidate->votes()->count());
    });

    it('admin can download PDF results', function () {
        $voting = Voting::factory()->create([
            'admin_id' => $this->admin->id,
            'status' => 'finished',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/voting/{$voting->id}/pdf");
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    });
});
