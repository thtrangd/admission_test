<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function build()
    {
        return $this->markdown('emails.applications.accepted')
            ->subject('Your Application has been Accepted');
    }
}

