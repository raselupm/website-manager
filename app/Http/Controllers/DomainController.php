<?php

namespace App\Http\Controllers;

use App\Jobs\CreateEvent;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class DomainController extends Controller
{


    public function getDomains(Request $request){

        $search = $request->search;

        if($search == ''){
            $domains = Domain::orderby('name','asc')->select('id','name')->limit(20)->get();
        }else{
            $domains = Domain::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(20)->get();
        }

        $response = array();
        foreach($domains as $domain){
            $response[] = array("value"=>$domain->id,"label"=>$domain->name);
        }

        return response()->json($response);
    }


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
        $domains = Domain::orderby('name')->paginate(50);
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
            'name' => 'required|unique:domains|max:200'
        ]);

        $dnsResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&type=A,MX&outputFormat=JSON');

        $whoisResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&outputFormat=JSON');



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

        if($dnsResponse->successful()) {
            $domain->dns_data = $dnsResponse->body();
        }

        if($whoisResponse->successful()) {
            $domain->whois_data = $whoisResponse->body();
        }


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


        $dnsResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&type=A,MX&outputFormat=JSON');

        $whoisResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&outputFormat=JSON');




        if($dnsResponse->successful() && $whoisResponse->successful()) {
            $domain->dns_data = $dnsResponse->body();
            $domain->whois_data = $whoisResponse->body();

            $domain->save();

            notify()->success('Domain data refreshed', '', ["positionClass" => "toast-bottom-right"]);
        } else {
            notify()->error('Problem on API', '', ["positionClass" => "toast-bottom-right"]);
        }



        return Redirect::back();
    }

    public function check() {
        request()->validate([
            'name' => 'required'
        ]);

        $dnsResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&type=A,MX&outputFormat=JSON');

        $whoisResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&outputFormat=JSON');

        if($dnsResponse->successful() && $whoisResponse->successful()) {
            $result = $dnsResponse->body();
            $whois_result = $whoisResponse->body();
        } else {
            notify()->error('Problem on API', '', ["positionClass" => "toast-bottom-right"]);
        }

        if(count(json_decode($dnsResponse, true)['DNSData']['dnsRecords']) > 0   ) {
            $ping = Http::get('http://' . request('name'));

            if($ping->successful()) {
                $up = true;
            } else {
                $up = false;
            }
        } else {
            $up = false;
        }


        return view('not-found', [
            'result' => $result,
            'whois_result' => $whois_result,
            'keyword' => request('name'),
            'up' => $up
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

        $lastEvent = $domain->events()->latest()->get()->first();



        return view('domain', [
            'domain' => $domain,
            'lastEvent' => $lastEvent,
        ]);
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
        $domain = Domain::findOrFail($id);

        request()->validate([
            'name' => 'required|max:200|unique:domains,name,'.$domain->id
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

        // update DNS data if domain is different
        if(request('name') != $domain->name) {
            $dnsResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&type=A,MX&outputFormat=JSON');

            $whoisResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.request('name').'&outputFormat=JSON');

            if($dnsResponse->successful() && $whoisResponse->successful()) {
                $domain->dns_data = $dnsResponse->body();
                $domain->whois_data = $whoisResponse->body();
            }
        }

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
