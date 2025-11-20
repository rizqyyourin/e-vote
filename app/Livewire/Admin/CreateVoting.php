<?php

namespace App\Livewire\Admin;

use App\Models\Voting;
use Livewire\Component;

class CreateVoting extends Component
{
    public $title = '';
    public $description = '';
    public $candidates = [['name' => ''], ['name' => '']];
    public $top_results = 3;

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
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'candidates' => 'required|array|min:2',
            'candidates.*.name' => 'required|string|max:255',
            'top_results' => 'required|integer|min:1|max:100',
        ]);

        $voting = Voting::create([
            'admin_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'draft',
            'top_results' => $this->top_results,
        ]);

        foreach ($this->candidates as $index => $candidate) {
            if ($candidate['name']) {
                $voting->candidates()->create([
                    'name' => $candidate['name'],
                    'order' => $index + 1,
                ]);
            }
        }

        session()->flash('success', 'Voting berhasil dibuat!');
        $this->redirect(route('admin.voting.show', $voting));
    }

    public function render()
    {
        return view('livewire.admin.create-voting');
    }
}
