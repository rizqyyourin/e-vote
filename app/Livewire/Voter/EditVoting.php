<?php

namespace App\Livewire\Voter;

use App\Models\Voting;
use Carbon\Carbon;
use Livewire\Component;

class EditVoting extends Component
{
    public Voting $voting;
    public $starts_at;
    public $ends_at;
    public $top_results;
    public $hasSchedule = false;
    public $showEndModal = false;

    public function mount(Voting $voting)
    {
        // Only allow user who created this voting to edit it
        if ($voting->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        $this->voting = $voting;
        $this->starts_at = $voting->starts_at?->format('Y-m-d\TH:i');
        $this->ends_at = $voting->ends_at?->format('Y-m-d\TH:i');
        $this->top_results = $voting->top_results;
        $this->hasSchedule = $voting->starts_at !== null;
    }

    public function startVoting()
    {
        if ($this->hasSchedule) {
            $this->validate([
                'starts_at' => 'required|date_format:Y-m-d\TH:i',
            ]);

            $this->voting->update([
                'status' => 'active',
                'starts_at' => Carbon::createFromFormat('Y-m-d\TH:i', $this->starts_at),
                'ends_at' => $this->ends_at ? Carbon::createFromFormat('Y-m-d\TH:i', $this->ends_at) : null,
            ]);
        } else {
            // Start immediately
            $this->voting->update([
                'status' => 'active',
                'starts_at' => now(),
            ]);
        }

        $this->dispatch('flash', 'Vote started!');
        $this->dispatch('refresh');
    }

    public function finishVoting()
    {
        $this->voting->update([
            'status' => 'finished',
            'ends_at' => now(),
        ]);

        $this->dispatch('flash', 'Vote finished!');
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

        $this->dispatch('flash', 'Results settings saved!');
    }

    public function updateSchedule()
    {
        if ($this->voting->status !== 'draft') {
            session()->flash('error', 'Cannot update schedule after voting has started');
            return;
        }

        $rules = [];
        
        if ($this->hasSchedule) {
            $rules['starts_at'] = 'required|date_format:Y-m-d\TH:i|after:now';
            $rules['ends_at'] = 'nullable|date_format:Y-m-d\TH:i|after:starts_at';
        }

        $this->validate($rules);

        $this->voting->update([
            'starts_at' => $this->starts_at ? Carbon::createFromFormat('Y-m-d\TH:i', $this->starts_at) : null,
            'ends_at' => $this->ends_at ? Carbon::createFromFormat('Y-m-d\TH:i', $this->ends_at) : null,
        ]);

        $this->dispatch('flash', 'Schedule updated!');
    }

    public function deleteVoting()
    {
        $this->voting->delete();
        $this->dispatch('flash', 'Vote deleted!');
        return redirect()->route('voter.dashboard');
    }

    public function render()
    {
        return view('livewire.voter.edit-voting');
    }
}
