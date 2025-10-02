<?php

namespace App\Livewire;

use Livewire\Component;

class AuthorPage extends Component
{
    public function render()
    {
        return view('livewire.author-page')->layout('layouts.app')->title('About Linda');
    }
}
