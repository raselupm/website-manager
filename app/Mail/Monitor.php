<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Monitor extends Mailable
{
    use Queueable, SerializesModels;

    public $domain;
    public $type;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 1) {
            $type_text = 'up';
        } else {
            $type_text = 'down';
        }
        return $this->view('domains/monitor-email')->subject(' '.strtoupper($type_text).' alert: '.$this->domain.' is '.$type_text.'');
    }
}
