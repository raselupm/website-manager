<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServerController extends Controller
{
    //

    public function index() {
        return view('servers.index' );
    }


    public function edit($id) {
        return view('servers.edit', ['serverID' => $id]);
    }



    public function destroy($id) {
        $server = Server::findOrFail($id);
        $server->delete();

        notify()->success('Server deleted', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/servers');
    }
}
