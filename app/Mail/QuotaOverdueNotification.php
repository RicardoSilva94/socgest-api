<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class QuotaOverdueNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $socio;
    protected $quota;


    /**
     * Create a new message instance.
     */
    public function __construct($socio, $quota)
    {
        $this->socio = $socio;
        $this->quota = $quota;
    }
    public function build()
    {
        $dataPagamento = \Carbon\Carbon::parse($this->quota->data_pagamento);

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Quota em Atraso')
            ->view('emails.quota_overdue')
            ->cc($this->socio->entidade->email)
            ->with([
                'socioName' => $this->socio->nome,
                'quotaId' => $this->quota->id,
                'quotaValue' => $this->quota->valor,
                'dueDate' => $dataPagamento->format('d/m/Y'),
                'quotaDescricao' => $this->quota->descricao,
                'entidadeNome' => $this->socio->entidade->nome,
                'periodo' => $this->quota->periodo,
            ]);
    }



    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificação de Quota em Atraso',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quota_overdue',
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
