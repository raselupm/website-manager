<?php

namespace App\Http\Livewire;

use App\Models\Domain;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DomainEdit extends Component
{
    public $domainID;

    public $name;
    public $description;
    public $ssl;
    public $cms;
    public $cms_version;
    public $force_hosting;

    public function mount($domainID)
    {

        $domain = Domain::findOrFail($domainID);

        $this->name = $domain->name;
        $this->description = $domain->code;
        $this->ssl = $domain->ssl;
        $this->cms = $domain->cms;
        $this->cms_version = $domain->cms_version;
        $this->force_hosting = $domain->force_hosting;

        $this->domainID = $domain->id;



        return view('livewire.domain-edit' );
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

        $domain = Domain::findOrFail($this->domainID);



        // update DNS data if domain is different
        if(!empty(env('WHOISXML_APIKEY'))) {

            if($this->name != $domain->name) {
                $dnsResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/DNSService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.$this->name.'&type=A,MX&outputFormat=JSON');

                $whoisResponse = Http::get('https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey='.env('WHOISXML_APIKEY').'&domainName='.$this->name.'&outputFormat=JSON');

                if($dnsResponse->successful() && $whoisResponse->successful()) {
                    $domain->dns_data = $dnsResponse->body();
                    $domain->whois_data = $whoisResponse->body();
                }
            }
        }


        $domain->name = $this->name;
        $domain->description = $this->description;
        $domain->ssl = $this->ssl;
        $domain->cms = $this->cms;
        $domain->cms_version = $this->cms_version;
        $domain->force_hosting = $this->force_hosting;



        $domain->save();

        return \redirect()->to('/');



    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return array_merge(
            $this->rules,
            [
                'name' => 'required|unique:domains,name,' . $this->domainID,
            ]
        );
    }
}
