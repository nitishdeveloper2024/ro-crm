<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;
use App\Models\Rental; // Correct model import

class RentalMail extends Mailable
{
    use Queueable, SerializesModels;


    public $rental;
    public $pdf;

    public function __construct(Rental $rental, $pdf)
    {
        // $this->complaint = $complaint;
        $this->rental = $rental;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Rental Submitted | Drinktech- The NextGEN RO')
                    ->view('emails.rental')
                    ->attachData($this->pdf->output(), 'rental.pdf');
    }

}
