<?php

namespace App\Mail;

use App\Remjob;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemjobUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The remjob instance.
     *
     * @var Remjob
     */
    public $remjob;

    /**
     * Create a new message instance.
     *
     * @param  \App\Remjob  $remjob
     * @return void
     */
    public function __construct(Remjob $remjob)
    {
        $this->remjob = $remjob;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.remjobs.updated');
    }
    
}
