<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class SubscriptionInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }


    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF invoice
        $pdf = Pdf::loadView('pdf.subscription_invoice', ['subscription' => $this->subscription]);

        return $this->subject('Subscription Invoice')
                    ->markdown('emails.subscription_invoice')
                    ->with([
                        'subscription' => $this->subscription,
                    ])
                    ->attachData($pdf->output(), "invoice_{$this->subscription->id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Get the message envelope.
    */

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Invoice Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscription_invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
