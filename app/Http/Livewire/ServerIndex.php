<?php

namespace App\Http\Livewire;

use App\Models\Server;
use Livewire\Component;

class ServerIndex extends Component
{
    public function render()
    {
        return view('livewire.server-index', [
            'servers' => Server::orderby('name')->paginate(50)
        ]);
    }
}
