<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServerRequest;
use App\Http\Requests\UpdateServerRequest;
use App\Models\Server;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::latest()->paginate(50);
        return view('servers.index', ['servers' => $servers]);
    }

    public function store(CreateServerRequest $request)
    {
        Server::create([
            'name' => $request->get('name'),
            'ip' => $request->get('ip')
        ]);

        notify()->success('Server added', '', ["positionClass" => "toast-bottom-right"]);

        return redirect()->route('servers.list');
    }

    public function edit(Server $server)
    {
        return view('servers.edit', ['server' => $server]);
    }

    public function update(UpdateServerRequest $request, $id)
    {
        Server::where('id', $id)
            ->update([
               'name' => $request->get('name'),
               'ip' => $request->get('ip')
            ]);

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
