<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;
    public function __construct($data)
    {
        $this->data         = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Subscription Email ',
        );
    }



    public function build()
    {
        return $this->view('mail.subscriptionmail')
                    ->with([
                        'name'              =>  $this->data['name'],
                        'email'             =>  $this->data['email'],
                        'payment_mode'      =>  $this->data['payment_mode'],
                        'payment_plan'      =>  $this->data['payment_plan'],
                        'bank_name'         =>  $this->data['bank_name'],
                        'account_name'      =>  $this->data['account_name'],
                        'account_no'        =>  $this->data['account_no'],
                    ]);
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
