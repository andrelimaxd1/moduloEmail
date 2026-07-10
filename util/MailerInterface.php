<?php
// util/MailerInterface.php
namespace App\Util;

interface MailerInterface {
    /** @return array{sucesso: bool, erro: ?string} */
    public function enviar(string $destinatario, string $assunto, string $corpoHtml): array;
}