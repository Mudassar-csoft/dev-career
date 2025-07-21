<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoworkingSpaceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    //public $filePath;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string $filePath
     */
    public function __construct($data, $filePath = null)
    {
        $this->data = $data;
        //$this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('workspace@career.edu.pk', 'Career WorkSpace')
                      ->subject('Coworking Space Request')
                      ->view('emails.coworking_space')
                      ->with('data', $this->data);

        // Attach file if the path is valid and the file exists
        // if ($this->filePath) {
        //     $fullPath = storage_path('app/public/' . $this->filePath);
        //     if (file_exists($fullPath)) {
        //         $email->attach($fullPath);
        //     } else {
        //         \Log::error("File not found: " . $fullPath);
        //     }
        // }

        return $email;
    }
}
