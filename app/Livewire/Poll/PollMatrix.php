<?php

namespace App\Livewire\Poll;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Vote;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PollMatrix extends Component
{

    public Poll $poll;
    public $votes = []; // [option_id => ['yes', 'no', 'maybe']]
    public $name = '';

    public function mount(Poll $poll)
    {
        $this->poll = $poll;

        foreach ($poll->pollOptions as $option) {
            $this->votes[$option->id] = null;
        }
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'votes' => 'required|array',
        ]);

        $participant = Participant::create([
            'poll_id' => $this->poll->id,
            'name' => $this->name,
        ]);

        foreach ($this->votes as $optionId => $choice) {
            if (in_array($choice, ['yes', 'maybe', 'no'])) {
                Vote::create([
                    'poll_option_id' => $optionId,
                    'participant_id' => $participant->id,
                    'choice' => $choice,
                ]);
            }
        }

        session()->flash('success', 'Deine Stimmen wurden gespeichert!');
        return redirect()->route('poll.show', $this->poll->public_token);
    }
    public function render()
    {
        return view('livewire.poll.poll-matrix');
    }
}
