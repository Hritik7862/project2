<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\Sandmail;
use App\Events\Sendmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\=Sendmail  $event
     * @return void
     */
    public function handle( Sandmail $event)
    {

        $user = User::find($event->userId)->toArray();
        Mail::send('eventMail', $user,function($message) use($user){
            $message->to($user['email']);
            $message->subject('Message sent from Mail to Mail server at  '); 


        });
        //
    }
}
