<?php

namespace App\Livewire\Voter;

use App\Models\Voting;
use Livewire\Component;

class CreateVoting extends Component
{
    public $title = '';
    public $description = '';
    public $candidates = [['name' => ''], ['name' => '']];
    public $top_results = 3;
    public $enableSchedule = false;
    public $starts_at = '';
    public $ends_at = '';

    public function addCandidate()
    {
        $this->candidates[] = ['name' => ''];
    }

    public function removeCandidate($index)
    {
        unset($this->candidates[$index]);
        $this->candidates = array_values($this->candidates);
    }

    public function createVoting()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'candidates' => 'required|array|min:2',
            'candidates.*.name' => 'required|string|max:255',
            'top_results' => 'required|integer|min:1|max:100',
        ];

        if ($this->enableSchedule) {
            $rules['starts_at'] = 'required|date_format:Y-m-d\TH:i|after:now';
            $rules['ends_at'] = 'nullable|date_format:Y-m-d\TH:i|after:starts_at';
        }

        $this->validate($rules);

        $voting = Voting::create([
            'admin_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'draft',
            'top_results' => $this->top_results,
            'starts_at' => $this->enableSchedule ? $this->starts_at : null,
            'ends_at' => $this->enableSchedule && $this->ends_at ? $this->ends_at : null,
        ]);

        foreach ($this->candidates as $index => $candidate) {
            $voting->candidates()->create([
                'name' => $candidate['name'],
                'order' => $index + 1,
            ]);
        }

        session()->flash('success', 'Vote created successfully! Now you can start it.');
        $this->redirect(route('voter.voting.edit', $voting));
    }

    public function render()
    {
        return view('livewire.voter.create-voting');
    }
}
