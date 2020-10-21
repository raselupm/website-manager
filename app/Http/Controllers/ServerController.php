<?php

namespace App\Http\Controllers;

use App\Models\Server;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::latest()->paginate(50);
        return view('servers', ['servers' => $servers]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|max:200|unique:servers',
            'ip' => 'required|unique:servers'
        ]);

        $server = new Server();
        $server->name = request('name');
        $server->ip = request('ip');

        $server->save();

        notify()->success('Server added', '', ["positionClass" => "toast-bottom-right"]);

        return redirect()->route('servers.list');
    }

    public function edit(Server $server)
    {
        return view('edit-server', ['server' => $server]);
    }

    public function update(Server $server)
    {
        request()->validate([
            'name' => 'required|max:200|unique:servers,name,'.$server->id,
            'ip' => 'required|unique:servers,ip,'.$server->id,
        ]);

        $server->name = request('name');
        $server->ip = request('ip');

        $server->save();

        notify()->success('Server updated', '', ["positionClass" => "toast-bottom-right"]);

        return redirect()->route('servers.list');
    }

    public function destroy(Server $server)
    {
        $server->delete();

        notify()->success('Server deleted', '', ["positionClass" => "toast-bottom-right"]);

        return redirect()->route('servers.list');
    }
}
