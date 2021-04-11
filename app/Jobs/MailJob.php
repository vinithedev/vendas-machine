<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sendto;
    public $fname;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sendto, $fname=null)
    {
        //Mail::to($request->exportar)->queue(new WelcomeMail($filename));
        $this->sendto = $sendto;
        $this->fname = $fname;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // return $this->markdown('emails.welcome')->attach($this->filename);
        $email = new WelcomeMail($this->fname);
        Mail::to($this->sendto)->send($email);
    }
}
