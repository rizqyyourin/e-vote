<?php

namespace App\Livewire\Voter;

use Livewire\Component;
use Livewire\WithPagination;

class VotingHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'latest';

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->sortBy = 'latest';
        $this->resetPage();
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $query = auth()->user()->votes()
            ->with(['voting', 'candidate']);

        // Apply search filter
        if ($this->search) {
            $query->whereHas('voting', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })->orWhereHas('candidate', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'candidate':
                $query->with('candidate')->orderBy('candidate_id', 'asc');
                break;
            case 'voting':
                $query->with('voting')->orderBy('voting_id', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $votes = $query->paginate(10);

        return view('livewire.voter.voting-history', [
            'votes' => $votes,
        ]);
    }
}
