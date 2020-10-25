<?php

namespace App\Http\Livewire;

use App\Models\Server;
use Livewire\Component;

class ServerEdit extends Component
{
    public $serverID;

    public $name;
    public $ip;

    public function mount($serverID)
    {

        $server = Server::findOrFail($serverID);

        $this->name = $server->name;
        $this->ip = $server->ip;

        $this->serverID = $server->id;



        return view('livewire.server-edit' );
    }


    protected $rules = [

    ];


    public function updated($propertyName) {
        $this->validateOnly(
            $propertyName,
            $this->getValidationRules()
        );
    }

    public function submitForm() {
        $this->validate($this->getValidationRules());

        $server = Server::findOrFail($this->serverID);



        $server->name = $this->name;
        $server->ip = $this->ip;

        $server->save();

        return \redirect()->to('/servers');
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array_merge(
            $this->rules,
            [
                'name' => 'required|unique:domains,name,' . $this->serverID,
                'ip' => 'required'
            ]
        );
    }
}
