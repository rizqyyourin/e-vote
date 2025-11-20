<?php

namespace App\Livewire\Voter;

use App\Models\Voting;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyVotesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortBy = 'latest';

    public function resetFilters()
    {
        $this->reset(['search', 'status', 'sortBy']);
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $query = Auth::user()->votings();

        // Apply search filter
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            case 'votes':
                $query->withCount('votes')
                    ->orderByRaw('(select count(*) from votes where votes.voting_id = votings.id) desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $votings = $query->paginate(10);

        return view('livewire.voter.my-votes-table', [
            'votings' => $votings,
        ]);
    }
}



