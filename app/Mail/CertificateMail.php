<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = $this->details;
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Admin.Certificate.downloadpdf', compact('details'));
        $pdf->setPaper('A4', 'landscape');
        return $this->from('info@gmail.com', 'Career')
            ->subject('Career Institute')
            ->view('Admin.Certificate.email', compact('details'))
            ->attachData($pdf->output(), $details['admission']->registration->name . ' ' . $details['admission']->roll_number . '.pdf');
    }
}
