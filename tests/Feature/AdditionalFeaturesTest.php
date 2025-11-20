<?php

use App\Models\User;
use App\Models\Voting;
use App\Models\Candidate;
use App\Models\Vote;

describe('Additional Features', function () {
    beforeEach(function () {
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->voter = User::factory()->create(['role' => 'voter']);
    });

    describe('Voting Lifecycle', function () {
        it('voting starts as draft', function () {
            $voting = Voting::factory()->create(['admin_id' => $this->admin->id]);
            $this->assertEquals('draft', $voting->status);
        });

        it('voting transitions draft -> active -> finished', function () {
            $voting = Voting::factory()->create(['admin_id' => $this->admin->id]);

            $voting->update(['status' => 'active', 'starts_at' => now()]);
            $this->assertEquals('active', $voting->fresh()->status);

            $voting->update(['status' => 'finished', 'ends_at' => now()]);
            $this->assertEquals('finished', $voting->fresh()->status);
        });

        it('can check if voting is active', function () {
            $activeVoting = Voting::factory()->create([
                'status' => 'active',
                'starts_at' => now()->subMinutes(5),
                'ends_at' => now()->addMinutes(55),
            ]);

            $draftVoting = Voting::factory()->create([
                'status' => 'draft',
            ]);

            $finishedVoting = Voting::factory()->create([
                'status' => 'finished',
                'ends_at' => now()->subMinutes(5),
            ]);

            $this->assertTrue($activeVoting->isActive());
            $this->assertFalse($draftVoting->isActive());
            $this->assertFalse($finishedVoting->isActive());
        });
    });

    describe('Vote Results', function () {
        it('calculates top results correctly', function () {
            $voting = Voting::factory()->create([
                'admin_id' => $this->admin->id,
                'top_results' => 2,
            ]);

            $c1 = Candidate::factory()->create(['voting_id' => $voting->id, 'name' => 'A']);
            $c2 = Candidate::factory()->create(['voting_id' => $voting->id, 'name' => 'B']);
            $c3 = Candidate::factory()->create(['voting_id' => $voting->id, 'name' => 'C']);

            // Create votes
            for ($i = 0; $i < 5; $i++) {
                Vote::create([
                    'voting_id' => $voting->id,
                    'candidate_id' => $c1->id,
                    'voter_id' => User::factory()->create()->id,
                ]);
            }

            for ($i = 0; $i < 3; $i++) {
                Vote::create([
                    'voting_id' => $voting->id,
                    'candidate_id' => $c2->id,
                    'voter_id' => User::factory()->create()->id,
                ]);
            }

            Vote::create([
                'voting_id' => $voting->id,
                'candidate_id' => $c3->id,
                'voter_id' => User::factory()->create()->id,
            ]);

            $topResults = $voting->getTopResults();

            $this->assertCount(2, $topResults);
            $this->assertEquals('A', $topResults[0]['name']);
            $this->assertEquals(5, $topResults[0]['vote_count']);
            $this->assertEquals('B', $topResults[1]['name']);
            $this->assertEquals(3, $topResults[1]['vote_count']);
        });

        it('gets all vote counts', function () {
            $voting = Voting::factory()->create(['admin_id' => $this->admin->id]);
            $c1 = Candidate::factory()->create(['voting_id' => $voting->id]);
            $c2 = Candidate::factory()->create(['voting_id' => $voting->id]);

            Vote::create([
                'voting_id' => $voting->id,
                'candidate_id' => $c1->id,
                'voter_id' => User::factory()->create()->id,
            ]);

            $voteCounts = $voting->getVoteCount();
            $this->assertCount(2, $voteCounts);
            $this->assertEquals(1, $voteCounts[0]['vote_count']);
        });
    });

    describe('Voter History', function () {
        it('voter can see voting history', function () {
            $voting1 = Voting::factory()->create(['status' => 'finished']);
            $voting2 = Voting::factory()->create(['status' => 'finished']);
            $c1 = Candidate::factory()->create(['voting_id' => $voting1->id]);
            $c2 = Candidate::factory()->create(['voting_id' => $voting2->id]);

            Vote::create([
                'voting_id' => $voting1->id,
                'candidate_id' => $c1->id,
                'voter_id' => $this->voter->id,
            ]);

            Vote::create([
                'voting_id' => $voting2->id,
                'candidate_id' => $c2->id,
                'voter_id' => $this->voter->id,
            ]);

            $votes = $this->voter->votes()->get();
            $this->assertCount(2, $votes);
        });

        it('voter can track which voting they participated in', function () {
            $voting = Voting::factory()->create();
            $candidate = Candidate::factory()->create(['voting_id' => $voting->id]);

            Vote::create([
                'voting_id' => $voting->id,
                'candidate_id' => $candidate->id,
                'voter_id' => $this->voter->id,
            ]);

            $hasVoted = $voting->votes()
                ->where('voter_id', $this->voter->id)
                ->exists();

            $this->assertTrue($hasVoted);
        });
    });

    describe('Share Voting', function () {
        it('voting has shareable URL', function () {
            $voting = Voting::factory()->create(['admin_id' => $this->admin->id]);
            $url = route('voting.show', $voting);

            $this->assertStringContainsString('/voting/' . $voting->id, $url);
        });

        it('public can access voting page via share link', function () {
            $voting = Voting::factory()->create();
            $response = $this->get("/voting/{$voting->id}");

            $response->assertStatus(200);
            $response->assertSee($voting->title);
        });
    });

    describe('User Roles', function () {
        it('user has isAdmin method', function () {
            $admin = User::factory()->create(['role' => 'admin']);
            $voter = User::factory()->create(['role' => 'voter']);

            $this->assertTrue($admin->isAdmin());
            $this->assertFalse($voter->isAdmin());
        });

        it('user has isVoter method', function () {
            $admin = User::factory()->create(['role' => 'admin']);
            $voter = User::factory()->create(['role' => 'voter']);

            $this->assertTrue($voter->isVoter());
            $this->assertFalse($admin->isVoter());
        });

        it('admin can have multiple votings', function () {
            $voting1 = Voting::factory()->create(['admin_id' => $this->admin->id]);
            $voting2 = Voting::factory()->create(['admin_id' => $this->admin->id]);

            $votings = $this->admin->votings()->get();
            $this->assertCount(2, $votings);
        });
    });
});
