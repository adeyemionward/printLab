<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerOrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $orderDetails;
    public $amount_paid;
    public $userName;
    public $pdf_attachment;
    public function __construct($orderDetails, $amount_paid, $userName, $pdf_attachment)
    {
        $this->orderDetails  = $orderDetails;
        $this->amount_paid   = $amount_paid;
        $this->userName      = $userName;
        $this->pdf_attachment      = $pdf_attachment;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Customer Order Receipt',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'testmail',
    //         orderDetails: $this->orderDetails,
    //     );
    // }

    public function build()
    {
        return $this->view('testmail')
                    ->with([
                        'orderDetails' => $this->orderDetails,
                        'amount_paid' => $this->amount_paid,
                        'userName' => $this->userName,
                    ])->attachData($this->pdf_attachment->output(), 'invoice.pdf');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
