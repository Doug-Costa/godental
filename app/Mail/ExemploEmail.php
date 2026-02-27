<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExemploEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $assunto;
    public $nomeUsuario;
    public $linkRecuperacao;

    public function __construct($assunto, $nomeUsuario, $linkRecuperacao)
    {
        $this->assunto = $assunto;
        $this->nomeUsuario = $nomeUsuario;
        $this->linkRecuperacao = $linkRecuperacao;
    }

    public function build()
    {
        return $this->subject($this->assunto)->view('emails.exemplo');
    }
}
?>