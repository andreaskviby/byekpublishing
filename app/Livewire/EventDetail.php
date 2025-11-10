<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class EventDetail extends Component
{
    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.event-detail')->layout('layouts.app')->title($this->event->title);
    }
}
