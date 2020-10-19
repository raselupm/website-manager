<?php

namespace App\Jobs;

use App\Mail\Monitor;
use App\Models\Domain;
use App\Models\Event;
use App\Models\User;
use App\Notifications\SlackMonitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

use Twilio\Rest\Client;

use Exception;


class CreateEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const TYPE_UP = 1;
    const TYPE_DOWN = 2;

    public $timeout = 300;

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

        $domains = Domain::select(['id', 'name'])->get();


        foreach ($domains as $domain) {
            // checking a single domain
            try {
                $ping = Http::get('http://' . $domain->name);
                $crawlerError = false;
            } catch (Exception $e) {
                $crawlerError = true;
            }

            if($crawlerError == false) {
                if($ping->successful()) {
                    $this->doDomainMonitorTasks($domain, self::TYPE_UP);
                } else {
                    $this->doDomainMonitorTasks($domain, self::TYPE_DOWN);
                }
            } else {
                $this->doDomainMonitorTasks($domain, self::TYPE_DOWN);
            }

        }
    }

    private function endEvent($eventID) {
        $event = Event::findOrFail($eventID);
        $event->end_time = now();
        $event->save();
    }

    private function recordEvent(Domain $domain, $type) {
        $event = new Event();
        $event->type = $type;
        $event->save();
        $domain->events()->attach($event->id);
    }

    private function sendNotifications($domain, $type) {
        $user = User::findOrFail(1);

        // email admin about site is down
        Mail::to($user)->send(new Monitor($domain, $type));

        // Slack notification
        if(!empty(env('SLACK_HOOK'))) {
            $user->notify(new SlackMonitor($domain, $type));
        }

        // Twilo notification
        if(!empty(env('TWILO_SID')) && !empty(env('TWILO_TOKEN')) && !empty(env('TWILO_TO_NUMBER')) && !empty(env('TWILO_FORM_NUMBER'))) {
            $this->sendTwiloNotification($domain, $type, $type);
        }
    }

    private function sendTwiloNotification($domain, $type, $method) {

        if($type == 1) {
            $type_text = 'up';
            $news_text = 'Good';
        } else {
            $type_text = 'down';
            $news_text = 'Bad';
        }

        $client = new Client(env('TWILO_SID'), env('TWILO_TOKEN'));


        // SMS if site up or down
        $client->messages->create(env('TWILO_TO_NUMBER'), [
            'from' => env('TWILO_FORM_NUMBER'),
            'body' => ''.$news_text.' news! Your domain ' . $domain . ' is '.$type_text.'. since '.date('F j, Y - g:i a', strtotime(now())).'.'
        ]);

        // call only if site down
        if($method == self::TYPE_DOWN) {
            // Actually wait more 10 minutes if still down.
            dispatch(new TwiloCall($domain, self::TYPE_DOWN))->delay(now()->addMinutes(10));
        }
    }

    private function doDomainMonitorTasks($domain, $type) {
        $checkLatestEvent = $domain->events()->latest()->get()->first();


        if(empty($checkLatestEvent) ) {
            // no record found, so adding a new one
            $this->recordEvent($domain, $type);
        } else {
            // found record isn't up do adding a new up event
            if($checkLatestEvent->type != $type) {
                $this->endEvent($checkLatestEvent->id);
                $this->recordEvent($domain, $type);

                $this->sendNotifications($domain->name, $type);
            }
        }
    }
}
