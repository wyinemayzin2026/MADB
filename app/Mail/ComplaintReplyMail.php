<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;
    public $replyNote;
    public $status;
    public $replyFromEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $complaint, $replyNote, $status, $replyFromEmail)
    {
        $this->complaint      = $complaint;
        $this->replyNote      = $replyNote;
        $this->status         = $status;
        $this->replyFromEmail = $replyFromEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->replyFromEmail, 'Customer Support'),
            subject: 'Re: ' . $this->complaint->subject . ' [အကြောင်းပြန်စာ]',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint_reply',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
