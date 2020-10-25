<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $modalIcon;
    public $modalBtnText;
    public $modalTitle;
    public $modalContent;

    public function render()
    {
        $random = rand(121213,13248776);
        return view('livewire.modal', ['random' => $random]);
    }
}
