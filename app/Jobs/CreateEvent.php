<?php

namespace App\Jobs;

use App\Mail\Monitor;
use App\Models\Domain;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

use Exception;


class CreateEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const TYPE_UP = 1;
    const TYPE_DOWN = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $user = User::findOrFail(1);

        $domains = Domain::select(['id', 'name'])->get();



        foreach ($domains as $domain) {
            // checking a single domain
            try {
                $ping = Http::get('http://' . $domain->name);
                $crawlerError = false;
            } catch (Exception $e) {
                $crawlerError = true;
            }

            // checking last previous record
            $checkLatestEvent = $domain->events()->latest()->get()->first();

            if($crawlerError == false) {
                // no crawl error, means domain is up
                if($ping->successful()) {
                    if(empty($checkLatestEvent) ) {
                        // no record found, so adding a new one
                        $this->recordEvent($domain, self::TYPE_UP);
                    } else {
                        // found record isn't up do adding a new up event
                        if($checkLatestEvent->type == 2) {
                            $this->recordEvent($domain, self::TYPE_UP);

                            // email admin about site is up
                            Mail::to($user)->send(new Monitor(self::TYPE_UP, $domain->name, now()));
                        }
                    }
                }
            } else {
                // crawl error, means domain is down
                if(empty($checkLatestEvent) ) {
                    // no record found, so adding a new one
                    $this->recordEvent($domain, self::TYPE_DOWN);
                } else {
                    // found record isn't down do adding a new down event
                    if($checkLatestEvent->type == 1) {
                        $this->recordEvent($domain, self::TYPE_DOWN);

                        // email admin about site is down
                        Mail::to($user)->send(new Monitor(self::TYPE_DOWN, $domain->name, now()));
                    }
                }
            }

        }
    }

    private function recordEvent(Domain $domain, $latestEventType) {

        $event = new Event();
        $event->type = $latestEventType; // 2 = down
        $event->save();
        $domain->events()->attach($event->id);

    }
}
