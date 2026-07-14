<?php
namespace App\Util;

interface MailerInterface {
    
    public function enviar(string $destinatario, string $assunto, string $corpoHtml, array $anexos = []): array;
}