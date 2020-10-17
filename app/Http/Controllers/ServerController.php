<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServerController extends Controller
{
    //

    public function index() {
        $servers = Server::latest()->paginate(50);
        return view('servers', ['servers' => $servers]);
    }

    public function store() {
        request()->validate([
            'name' => 'required|max:200|unique:servers',
            'ip' => 'required|unique:servers'
        ]);

        $server = new Server();
        $server->name = request('name');
        $server->ip = request('ip');

        $server->save();

        notify()->success('Server added', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/servers');
    }

    public function edit($id) {
        $server = Server::findOrFail($id);
        return view('edit-server', ['server' => $server]);
    }

    public function update($id) {
        $server = Server::findOrFail($id);

        request()->validate([
            'name' => 'required|max:200|unique:servers,name,'.$server->id,
            'ip' => 'required|unique:servers,ip,'.$server->id,
        ]);



        $server->name = request('name');
        $server->ip = request('ip');

        $server->save();

        notify()->success('Server updated', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/servers');
    }

    public function destroy($id) {
        $server = Server::findOrFail($id);
        $server->delete();

        notify()->success('Server deleted', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/servers');
    }
}
