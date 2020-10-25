<?php

namespace App\Http\Livewire;

use App\Models\Domain;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DomainAdd extends Component
{
    public $name;
    public $description;
    public $ssl = 1;
    public $cms;
    public $cms_version;
    public $force_hosting = 0;

    protected $rules = [
        'name' => 'required|unique:domains|max:200'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function submitForm() {
        $this->validate();

        if(!empty(env('WHOISXML_APIKEY'))) {
            $dnsResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.$this->name.'&type=A,MX&outputFormat=JSON');

            $whoisResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.$this->name.'&outputFormat=JSON');
        }


        $domain = new Domain();
        $domain->name = $this->name;
        $domain->description = $this->description;
        $domain->ssl = $this->ssl;
        $domain->cms_version = $this->cms_version;
        $domain->force_hosting = $this->force_hosting;

        if(!empty(env('WHOISXML_APIKEY'))) {
            if($dnsResponse->successful()) {
                $domain->dns_data = $dnsResponse->body();
            }

            if($whoisResponse->successful()) {
                $domain->whois_data = $whoisResponse->body();
            }
        }

        $domain->save();

        notify()->success('Domain is added', '', ["positionClass" => "toast-bottom-right"]);

        return \redirect('/' . $domain->name);



    }

    public function render()
    {
        return view('livewire.domain-add');
    }
}
