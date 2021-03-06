<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DepositMadeSuccessfully extends Mailable
{
    use Queueable, SerializesModels;

    protected $projectPayment;

    /**
     * Create a new message instance.
     *
     * @param $projectPayment
     */
    public function __construct($projectPayment)
    {
        //
        $this->projectPayment = $projectPayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.depositMadeSuccessfully')->with('projectPayment', $this->projectPayment);
    }
}
