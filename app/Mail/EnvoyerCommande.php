<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Commande;
use App\Models\Contact;

class EnvoyerCommande extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $contact;
    public $message_perso;

    /**
     * Create a new message instance.
     */
    public function __construct(Commande $commande, Contact $contact, $message = null)
    {
        $this->commande = $commande;
        $this->contact = $contact;
        $this->message_perso = $message;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $sujet = 'Commande N° ' . $this->commande->numero_commande;
        
        return $this->subject($sujet)
                    ->view('emails.commande')
                    ->attach($this->commande->url_pdf, [
                        'as' => 'commande_' . $this->commande->numero_commande . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
} 