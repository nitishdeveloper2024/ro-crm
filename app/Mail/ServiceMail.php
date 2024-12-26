<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;
use App\Models\Service; // Correct model import
use App\Models\Complaint; // Correct model import
class ServiceMail extends Mailable
{
    use Queueable, SerializesModels;


    public $complaint;
    public $pdf;

    public function __construct(Complaint $complaint, $pdf, $service)
    {
        $this->complaint = $complaint;
        $this->service = $service;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Service Complaint Submitted | Drinktech- The NextGEN RO')
                    ->view('emails.service')
                    ->attachData($this->pdf->output(), 'service.pdf');
    }

}
