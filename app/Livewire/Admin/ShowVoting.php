<?php

namespace App\Livewire\Admin;

use App\Models\Voting;
use Carbon\Carbon;
use Livewire\Component;

class ShowVoting extends Component
{
    public Voting $voting;
    public $starts_at;
    public $ends_at;
    public $top_results;

    public function mount(Voting $voting)
    {
        $this->authorize('update', $voting);
        
        $this->voting = $voting;
        $this->starts_at = $voting->starts_at?->format('Y-m-d\TH:i');
        $this->ends_at = $voting->ends_at?->format('Y-m-d\TH:i');
        $this->top_results = $voting->top_results;
    }

    public function startVoting()
    {
        $this->validate([
            'starts_at' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $this->voting->update([
            'status' => 'active',
            'starts_at' => Carbon::createFromFormat('Y-m-d\TH:i', $this->starts_at),
        ]);

        session()->flash('success', 'Voting dimulai!');
        $this->dispatch('refresh');
    }

    public function finishVoting()
    {
        $this->voting->update([
            'status' => 'finished',
            'ends_at' => now(),
        ]);

        session()->flash('success', 'Voting selesai!');
        $this->dispatch('refresh');
    }

    public function updateTopResults()
    {
        $this->validate([
            'top_results' => 'required|integer|min:1|max:100',
        ]);

        $this->voting->update([
            'top_results' => $this->top_results,
        ]);

        session()->flash('success', 'Pengaturan hasil tersimpan!');
    }

    public function render()
    {
        return view('livewire.admin.show-voting');
    }
}
