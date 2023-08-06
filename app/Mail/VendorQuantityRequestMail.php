<?php

namespace App\Mail;

use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorQuantityRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;
    public $item;

    /**
     * Create a new message instance.
     */
    public function __construct(Vendor $vendor, Item $item = null)
    {
        $this->vendor = $vendor;
        $this->item = $item;
    }

//    /**
//     * Build the message.
//     *
//     * @return $this
//     */
    public function build()
    {
        $subject = $this->item ? 'Request for New Quantity for Item: ' . $this->item->name : 'Request for New Quantity';

        return $this->subject($subject)
            ->view('emails.vendor_quantity_request');
    }

    /**
     * Get the message envelope.
     */
//    public function envelope(): Envelope
//    {
//        return new Envelope(
//            subject: 'Request for New Quantity',
//        );
//    }

    /**
     * Get the message content definition.
     */
//    public function content(): Content
//    {
//        return new Content(
//            view: 'emails.vendor_quantity_request',
//        );
//    }

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
