<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class EnvoyerDevis extends Mailable
{
    use Queueable, SerializesModels;
    public $devis;
    public $contact;
    public $url_pdf;
    /**
     * Create a new message instance.
     */
    public function __construct($devis, $contact)
    {
        $this->devis = $devis;
        $this->contact = $contact;
        $this->url_pdf = "url";
    }
   
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'StylandGrip - Devis N°'.$this->devis->numero_devis,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.devis.envoyer_devis',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->devis->url_pdf),
        ];
    }
}
