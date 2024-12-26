<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RechargeExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recharge;
    public $pdfContent;
    public $status;


    public function __construct($recharge, $pdfContent)
    {
        $this->recharge = $recharge;
        $this->pdfContent = $pdfContent;
        $this->status = "expired";
    }

    public function build()
    {
        return $this->view('emails.recharge_expired')
                    ->subject('Your Rental Recharge has Expired')
                    ->with([
                        'status'=>$this->status
                    ])
                    ->attachData($this->pdfContent, $this->recharge->rental_id . '_expired.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }


}
