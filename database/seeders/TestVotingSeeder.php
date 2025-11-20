<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Voting;
use Illuminate\Database\Seeder;

class TestVotingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first voter user
        $user = User::where('is_voter', true)->first() ?? User::first();

        // Create test voting with immediate start (no schedule)
        $voting = Voting::create([
            'admin_id' => $user->id,
            'title' => 'Test Vote - E2E Flow',
            'description' => 'Testing end-to-end flow with auto-slug',
            'status' => 'active',
            'starts_at' => now(),
            'top_results' => 2,
        ]);

        $voting->candidates()->create(['name' => 'Candidate A', 'order' => 1]);
        $voting->candidates()->create(['name' => 'Candidate B', 'order' => 2]);

        echo "\n✅ Test voting created!\n";
        echo "📌 Slug: {$voting->slug}\n";
        echo "🔗 Vote link: http://e-voting.test/voting/{$voting->slug}\n";
        echo "✏️  Edit link: http://e-voting.test/voter/voting/{$voting->slug}/edit\n";
        echo "📊 Status: {$voting->status}\n";
        echo "⏱️  Start time: {$voting->starts_at}\n\n";
    }
}
