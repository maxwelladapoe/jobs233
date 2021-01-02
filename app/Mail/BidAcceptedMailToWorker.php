<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidAcceptedMailToWorker extends Mailable
{
    use Queueable, SerializesModels;

    private $bid;

    /**
     * Create a new message instance.
     *
     * @param $bid
     */
    public function __construct($bid)
    {
        //
        $this->bid = $bid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.bidAcceptedMailToWorker')->subject("Your Bid has been accepted")->with('bid',
            $this->bid);
    }
}
