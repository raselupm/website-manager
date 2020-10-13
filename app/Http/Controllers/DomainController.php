<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search() {
        $domain = Domain::latest()->get()->where('name', request('name'))->first();

        if(!empty($domain)) {
            return \redirect('/' . $domain->name);
        } else {
            return view('not-found', [
                'keyword' => request('name')
            ]);
        }
    }


    public function index()
    {
        //
        $domains = Domain::latest()->get();
        return view('index', [
            'domains' => $domains
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'name' => 'required'
        ]);


        $url = 'https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey=at_wrgWxLcSi3mEEBfqoRXOdQb9ebiIC&domainName='.request('name').'&type=A,MX&outputFormat=JSON';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);



        if(request('ssl') == 'on') {
            $ssl = 1;
        } else {
            $ssl = 0;
        }

        if(request('force_hosting') == 'on') {
            $force_hosting = 1;
        } else {
            $force_hosting = 0;
        }


        $domain = new Domain();
        $domain->name = request('name');
        $domain->description = request('description');
        $domain->ssl = $ssl;
        $domain->cms = request('cms');
        $domain->cms_version = request('cms_version');
        $domain->dns_data = $result;
        $domain->force_hosting = $force_hosting;

        $domain->save();

        notify()->success('Domain is added', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/' . $domain->name);

    }

    public function refresh() {

        request()->validate([
            'name' => 'required'
        ]);

        $domain = Domain::where('name', '=', request('name'))->firstOrFail();


        $url = 'https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey=at_wrgWxLcSi3mEEBfqoRXOdQb9ebiIC&domainName='.request('name').'&type=A,MX&outputFormat=JSON';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);



        $domain->dns_data = $result;

        $domain->save();

        notify()->success('Domain data refreshed', '', ["positionClass" => "toast-bottom-right"]);

        return Redirect::back();
    }

    public function check() {
        request()->validate([
            'name' => 'required'
        ]);

        $url = 'https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey=at_wrgWxLcSi3mEEBfqoRXOdQb9ebiIC&domainName='.request('name').'&type=A,MX&outputFormat=JSON';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);


        return view('not-found', [
            'result' => $result,
            'keyword' => request('name')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain, $name)
    {
        //
        $domain = Domain::where('name', $name)->firstOrFail();
        return view('domain', ['domain' => $domain]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain, $id)
    {
        //
        $domain = Domain::findOrFail($id);
        return view('edit-domain', ['domain' => $domain]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain, $id)
    {
        request()->validate([
            'name' => 'required'
        ]);



        if(request('ssl') == 'on') {
            $ssl = 1;
        } else {
            $ssl = 0;
        }

        if(request('force_hosting') == 'on') {
            $force_hosting = 1;
        } else {
            $force_hosting = 0;
        }


        $domain = Domain::findOrFail($id);
        $domain->name = request('name');
        $domain->description = request('description');
        $domain->ssl = $ssl;
        $domain->cms = request('cms');
        $domain->cms_version = request('cms_version');
        $domain->force_hosting = $force_hosting;

        $domain->save();

        notify()->success('Domain updated', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/' . $domain->name);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain, $id)
    {
        //
        $domain = Domain::findOrFail($id);
        $domain->delete();

        notify()->success('Domain deleted', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/');
    }
}
