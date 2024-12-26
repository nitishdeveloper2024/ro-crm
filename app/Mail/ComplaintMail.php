<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;
use App\Models\Complaint; // Correct model import

class ComplaintMail extends Mailable
{
    use Queueable, SerializesModels;


    public $complaint;
    public $pdf;

    public function __construct(Complaint $complaint, $pdf)
    {
        $this->complaint = $complaint;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Complaint Submitted | Drinktech- The NextGEN RO')
                    ->view('emails.complaint')
                    ->attachData($this->pdf->output(), 'complaint.pdf');
    }

}
