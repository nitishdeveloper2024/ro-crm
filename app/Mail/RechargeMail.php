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
use App\Models\Recharge; // Correct model import

class RechargeMail extends Mailable
{
    use Queueable, SerializesModels;


    public $recharge;
    public $pdf;
    // public $recharge;

    public function __construct(Recharge $recharge, $pdf, $rental)
    {
        $this->recharge = $recharge;
        $this->pdf = $pdf;
        $this->rental = $rental;

    }

    public function build()
    {
        return $this->subject('Recharge Submitted | Drinktech- The NextGEN RO')
                    ->view('emails.recharge')
                    ->attachData($this->pdf->output(), 'recharge.pdf');
    }
}
