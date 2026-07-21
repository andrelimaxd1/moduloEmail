<?php

namespace App\Util;

class NativeMailer implements MailerInterface {
    
    public function enviar(string $destinatario, string $assunto, string $corpoHtml, array $arquivosUpload = [], array $anexosDoTemplate = []): array {
        
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: naoresponda@suaempresa.com.br\r\n";

        $ok = mail($destinatario, $assunto, $corpoHtml, $headers);

        return $ok
            ? ['sucesso' => true, 'erro' => null]
            : ['sucesso' => false, 'erro' => 'Falha ao enviar via mail()'];
    }
}