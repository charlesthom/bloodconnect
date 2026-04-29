<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclineRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $donationRequest;

    public function __construct($donationRequest)
    {
        $this->donationRequest = $donationRequest;
    }

    public function build()
    {
        return $this->subject('Screening Request Cancelled')
            ->view('emails.decline-request-mail');
    }
}