<?php

namespace App\Http\Controllers;


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
            return view('domains.not-found', [
                'keyword' => request('name')
            ]);
        }
    }


    public function index() {
        return view('domains.index' );
    }




    public function refresh() {

        request()->validate([
            'name' => 'required'
        ]);

        $domain = Domain::where('name', '=', request('name'))->firstOrFail();


        if(!empty(env('WHOISXML_APIKEY'))) {
            $dnsResponse = Http::get(dnsAPIURL(request('name')));
            $whoisResponse = Http::get(whoisAPIURL(request('name')));


            if($dnsResponse->successful() && $whoisResponse->successful()) {
                $domain->dns_data = $dnsResponse->body();
                $domain->whois_data = $whoisResponse->body();

                $domain->save();

                notify()->success('Domain data refreshed', '', ["positionClass" => "toast-bottom-right"]);
            } else {
                notify()->error('Problem on API', '', ["positionClass" => "toast-bottom-right"]);
            }
        }



        return Redirect::back();
    }

    public function check() {
        request()->validate([
            'name' => 'required'
        ]);

        $up = false;

        if(!empty(env('WHOISXML_APIKEY'))) {
            $dnsResponse = Http::get(dnsAPIURL(request('name')));
            $whoisResponse = Http::get(whoisAPIURL(request('name')));

            if($dnsResponse->successful() && $whoisResponse->successful()) {
                $result = $dnsResponse->body();
                $whois_result = $whoisResponse->body();
            } else {
                notify()->error('Problem on API', '', ["positionClass" => "toast-bottom-right"]);
            }

            if(count(json_decode($dnsResponse, true)['DNSData']['dnsRecords']) > 0   ) {
                $ping = Http::head('http://' . request('name'));

                if($ping->successful()) {
                    $up = true;
                }
            }
        }




        return view('domains.not-found', [
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



        return view('domains.single', [
            'domain' => $domain,
            'lastEvent' => $lastEvent,
        ]);
    }


    public function edit($id) {
        return view('domains.edit', ['domainID' => $id]);
    }


    public function destroy(Domain $domain, $id)
    {
        //
        $domain = Domain::findOrFail($id);
        $domain->delete();


        notify()->success('Domain deleted', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/');
    }
}
