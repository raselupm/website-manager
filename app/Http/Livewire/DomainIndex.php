<?php

namespace App\Http\Livewire;

use App\Models\Domain;
use Livewire\Component;
use Livewire\WithPagination;

class DomainIndex extends Component
{
    use WithPagination;


    public function render()
    {

        return view('livewire.domain-index', [
            'domains' => Domain::orderby('name')->paginate(50)
        ]);
    }
}
