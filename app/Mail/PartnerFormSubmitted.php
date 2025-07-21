<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $partnerDetails;

    public function __construct($partnerDetails)
    {
        $this->partnerDetails = $partnerDetails;
    }

    public function build()
    {
        return $this->view('Web.email.partner_form_submitted')
                    ->with('partnerDetails', $this->partnerDetails)
                    ->subject('New Partner Form Submission');
    }
}
