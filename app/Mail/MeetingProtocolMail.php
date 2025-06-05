<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingProtocolMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Meeting $meeting, public string $pdfPath)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Meeting Protocol',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting-protocol',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject('Fertiges Sitzungsprotokoll')
            ->view('emails.meeting.protocol')
            ->attach($this->pdfPath, [
                'as' => 'sitzungsprotokoll.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
