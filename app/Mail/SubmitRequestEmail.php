<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmitRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $requestDetails;

    /**
     * Create a new message instance.
     *
     * @param $requestDetails
     */
    public function __construct($requestDetails)
    {
        //
        $this->requestDetails = $requestDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.submitRequest')->with('requestDetails', $this->requestDetails)->replyTo
        ($this->requestDetails['email'])->from($this->requestDetails['email']);
    }
}
