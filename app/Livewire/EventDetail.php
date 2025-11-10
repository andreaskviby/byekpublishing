<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\SeoService;
use Illuminate\Support\Str;
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
        $seoData = SeoService::generateMetaTags(
            $this->event,
            $this->event->title,
            Str::limit(strip_tags($this->event->description), 155)
        );

        $structuredData = SeoService::generateStructuredData($this->event);

        return view('livewire.event-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
