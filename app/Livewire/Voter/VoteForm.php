<?php

namespace App\Livewire\Voter;

use App\Models\Vote;
use App\Models\Voting;
use Livewire\Component;

class VoteForm extends Component
{
    public Voting $voting;
    public $selectedCandidate = null;
    public $hasVoted = false;
    public $isActive = false;

    public function mount(Voting $voting)
    {
        $this->voting = $voting;
        $this->isActive = $voting->isActive();
        
        if (auth()->check()) {
            $this->hasVoted = $voting->votes()
                ->where('voter_id', auth()->id())
                ->exists();
        }
    }

    public function submitVote()
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        if (!$this->isActive) {
            session()->flash('error', 'Vote is not active');
            return;
        }

        if ($this->hasVoted) {
            session()->flash('error', 'You have already cast your vote for this voting');
            return;
        }

        $this->validate([
            'selectedCandidate' => 'required|exists:candidates,id',
        ]);

        // Check if candidate belongs to this voting
        $candidate = $this->voting->candidates()
            ->where('id', $this->selectedCandidate)
            ->firstOrFail();

        // Create vote with unique constraint handling
        try {
            Vote::create([
                'voting_id' => $this->voting->id,
                'candidate_id' => $candidate->id,
                'voter_id' => auth()->id(),
            ]);

            $this->hasVoted = true;
            session()->flash('success', 'Your vote has been recorded successfully!');
            $this->dispatch('vote-submitted');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred. You may have already voted for this voting.');
        }
    }

    public function render()
    {
        return view('livewire.voter.vote-form');
    }
}
