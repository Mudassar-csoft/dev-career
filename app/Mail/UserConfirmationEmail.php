<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $partnerDetails;

    public function __construct($partnerDetails)
    {
        $this->partnerDetails = $partnerDetails;
    }

    public function build()
    {
        return $this->view('Web.email.user_confirmation')
                    ->with('partnerDetails', $this->partnerDetails)
                    ->subject('Your Partnership Request Confirmation');
    }
}
