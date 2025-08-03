<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Class for sending email with login credentials (email and password).
 * Uses a configurable Blade template for the email content.
 */
class SendCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    // Public properties that will be available in the mail view
    public $email;
    public $password;

    // Blade view that will be used as the email template
    protected $templateView;

    /**
     * Create a new instance of the message.
     *
     * @param string $email The user's email address
     * @param string $password The user's password
     * @param string $templateView Blade view for the email content (default 'emails.credentials')
     */
    public function __construct($email, $password, $templateView = 'emails.credentials')
    {
        $this->email = $email;
        $this->password = $password;
        $this->templateView = $templateView;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus credenciales de acceso'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->templateView, // Blade view to be used for the email body
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
