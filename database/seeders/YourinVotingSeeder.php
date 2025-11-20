<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Voting;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YourinVotingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create Yourin user
        $yourin = User::firstOrCreate(
            ['email' => 'yourin@gmail.com'],
            [
                'name' => 'Yourin',
                'password' => bcrypt('password'),
                'role' => 'voter',
                'timezone' => 'Asia/Jakarta',
            ]
        );

        // Create 20 finished votings and add Yourin's votes to each
        for ($i = 1; $i <= 20; $i++) {
            $voting = Voting::create([
                'admin_id' => User::where('role', 'admin')->first()?->id ?? User::factory()->create(['role' => 'admin'])->id,
                'slug' => substr(bin2hex(random_bytes(12)), 0, 24),
                'title' => 'Voting Test #' . $i,
                'description' => 'Test voting number ' . $i . ' for demonstration purposes',
                'status' => 'finished',
                'starts_at' => now()->subDays(30 - $i)->addHours(rand(1, 23)),
                'ends_at' => now()->subDays(29 - $i)->addHours(rand(1, 23)),
            ]);

            // Create candidates (random 2-4 candidates)
            $candidateCount = rand(2, 4);
            $candidates = [];
            for ($j = 1; $j <= $candidateCount; $j++) {
                $candidate = Candidate::create([
                    'voting_id' => $voting->id,
                    'name' => 'Candidate ' . chr(64 + $j),
                    'description' => 'Description for candidate ' . chr(64 + $j),
                    'order' => $j,
                ]);
                $candidates[] = $candidate;
            }

            // Create votes (5-15 votes from different voters)
            $voteCount = rand(5, 15);
            
            // Create voters for this voting
            $voters = User::factory(max(3, $candidateCount))
                ->create([
                    'role' => 'voter',
                    'timezone' => 'Asia/Jakarta',
                ]);

            // Add Yourin's vote to this voting
            $selectedCandidate = $candidates[array_rand($candidates)];
            Vote::create([
                'voting_id' => $voting->id,
                'voter_id' => $yourin->id,
                'candidate_id' => $selectedCandidate->id,
                'created_at' => $voting->starts_at->addMinutes(rand(0, 1440)),
            ]);

            // Assign additional votes to other voters
            foreach ($voters as $index => $voter) {
                if ($index < $voteCount - 1) { // -1 because Yourin already voted
                    $selectedCandidate = $candidates[array_rand($candidates)];
                    Vote::create([
                        'voting_id' => $voting->id,
                        'voter_id' => $voter->id,
                        'candidate_id' => $selectedCandidate->id,
                        'created_at' => $voting->starts_at->addMinutes(rand(0, 1440)),
                    ]);
                }
            }

            echo "Created finished voting #{$i} with {$candidateCount} candidates, {$voteCount} votes (including Yourin)\n";
        }

        echo "\n✅ Successfully created 20 finished votings with voting history for Yourin!\n";
    }
}
