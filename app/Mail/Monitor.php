<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Monitor extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $domain_name;
    public $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $domain_name, $time)
    {
        //
        $this->type = $type;
        $this->domain_name = $domain_name;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('monitor-email');
    }
}
