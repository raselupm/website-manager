<?php

namespace App\Http\Livewire;

use App\Models\Server;
use Livewire\Component;

class ServerAdd extends Component
{
    public $name;
    public $ip;

    protected $rules = [
        'name' => 'required|unique:servers|max:200',
        'ip' => 'required'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function submitForm() {
        $this->validate();

        $server = new Server();
        $server->name = $this->name;
        $server->ip = $this->ip;


        $server->save();

        notify()->success('Server is added', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/servers' );



    }

    public function render()
    {
        return view('livewire.server-add');
    }
}
