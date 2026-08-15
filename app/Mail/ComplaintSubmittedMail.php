<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ComplaintSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;

    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complaint: ' . $this->complaint->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if (!empty($this->complaint->images)) {
            foreach ($this->complaint->images as $path) {
                $attachments[] = Attachment::fromStorageDisk('public', $path);
            }
        }

        return $attachments;
    }
}
