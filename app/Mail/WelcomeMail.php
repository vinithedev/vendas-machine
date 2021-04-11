<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $fname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fname)
    {
        $this->fname = $fname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->fname == null){
            return $this->markdown('emails.welcome');
        }else{
            return $this->markdown('emails.welcome')->attach($this->fname);
        }
    }
}
