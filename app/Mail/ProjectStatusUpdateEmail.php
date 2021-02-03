<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $statusUpdate,$project,$updateSentBy,$firstName;

    /**
     * Create a new message instance.
     *
     * @param $statusUpdate
     */
    public function __construct($statusUpdate,$project, $updateSentBy)
    {
        //
        $this->statusUpdate = $statusUpdate;
        $this->project = $project;
        $this->updateSentBy = $updateSentBy;

        if ($this->updateSentBy =='worker'){
            $this->firstName =$project->user->email;
        }else{
            $this->firstName =$project->worker->email;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.projectStatusUpdate')->with('statusUpdate',$this->statusUpdate)->with('project',$this->project)->with('firstName',$this->firstName);
    }
}
