<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidAcceptedMailToEmployer extends Mailable
{
    use Queueable, SerializesModels;

    protected $bid;

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
        return $this->markdown('emails.bidAcceptedMailToEmployer')->subject("You have accepted the bid of "
            .$this->bid->amount )->with('bid',$this->bid);
    }
}
