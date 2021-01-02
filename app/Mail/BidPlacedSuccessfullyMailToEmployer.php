<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidPlacedSuccessfullyMailToEmployer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $bid;
    protected $projectCreator;

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
        return $this->markdown('emails.bidPlacedSuccessfullyMailToEmployer')
            ->with('bid', $this->bid)->subject("A bid has been placed");
    }
}
