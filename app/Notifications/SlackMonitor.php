<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackMonitor extends Notification implements ShouldQueue
{
    use Queueable;

    public $domain;
    public $type;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSlack($notifiable)
    {
        if($this->type == 1) {
            $type_text = 'up';
        } else {
            $type_text = 'down';
        }

        return (new SlackMessage())->content(''.strtoupper($type_text).' alert: '.$this->domain.' is '.$type_text.'.')->from('Website Monitor', ':robot_face:');
    }
}
