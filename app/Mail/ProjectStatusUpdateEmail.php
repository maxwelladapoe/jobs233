<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $statusUpdate,$project;

    /**
     * Create a new message instance.
     *
     * @param $statusUpdate
     */
    public function __construct($statusUpdate,$project)
    {
        //
        $this->statusUpdate = $statusUpdate;
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.projectStatusUpdate')->with('statusUpdate',$this->statusUpdate)->with('project',$this->project);
    }
}
