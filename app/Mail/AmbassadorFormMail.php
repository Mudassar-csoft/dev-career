<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AmbassadorFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;
    public $filePath;

    /**
     * Create a new message instance.
     *
     * @param array $formData
     * @param string $filePath
     */
    public function __construct($formData, $filePath)
    {
        $this->formData = $formData;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('ambassador@career.edu.pk', 'Career Ambassodar')
                      ->subject('Program Ambassador')
                      ->view('emails.ambassador_Form')
                      ->with('formData', $this->formData);

                      $fullPath = storage_path('app/public/' . $this->filePath);

                      if (file_exists($fullPath)) {
                          $email->attach($fullPath);
                      } else {
                          dd("File not found: " . $fullPath);
                      }

        return $email;
    }
}
