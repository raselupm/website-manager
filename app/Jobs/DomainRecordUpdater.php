<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class DomainRecordUpdater implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $domain;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dnsResponse = Http::get(dnsAPIURL($this->domain->name));
        $whoisResponse = Http::get(whoisAPIURL($this->domain->name));


        if($dnsResponse->successful() && $whoisResponse->successful()) {
            $this->domain->dns_data = $dnsResponse->body();
            $this->domain->whois_data = $whoisResponse->body();

            $this->domain->save();
        }
    }
}
