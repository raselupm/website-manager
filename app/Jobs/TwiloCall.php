<?php

namespace App\Jobs;

use App\Models\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class TwiloCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $domain;
    public $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain, $type)
    {
        //
        $this->domain = $domain;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $client = new Client(env('TWILO_SID'), env('TWILO_TOKEN'));
        $domain = Domain::where('name', $this->domain)->firstOrFail();
        $lastEvent = $domain->events()->latest()->get()->first();


        // check if still down then call
        if($lastEvent->type == $this->type) {
            $client->calls->create(env('TWILO_TO_NUMBER'), env('TWILO_FORM_NUMBER'), [
                    'twiml' => '<Response><Say loop="3" voice="woman">Bad news! Your domain ' . $domain->name . ' is down.</Say></Response>'
                ]
            );
        }

    }
}
