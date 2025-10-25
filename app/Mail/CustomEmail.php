<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    /**
     * Create a new message instance.
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->emailData['subject'])
                    ->from($this->emailData['sender_email'], $this->emailData['sender_name'])
                    ->view('emails.custom')
                    ->with([
                        'content' => $this->emailData['content'],
                        'sender_name' => $this->emailData['sender_name'],
                        'sender_email' => $this->emailData['sender_email']
                    ]);
    }
}