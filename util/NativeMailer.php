<?php
// util/NativeMailer.php
// Implementação provisória com mail() nativo, SÓ para não travar o desenvolvimento
// enquanto você confirma com o gestor como o SMTP real está configurado.
// Quando souber, crie ex: PhpMailerAdapter implements MailerInterface e troque
// a linha em MailerFactory::criar() lá embaixo.
namespace App\Util;

class NativeMailer implements MailerInterface {
    public function enviar(string $destinatario, string $assunto, string $corpoHtml): array {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: naoresponda@suaempresa.com.br\r\n";

        $ok = mail($destinatario, $assunto, $corpoHtml, $headers);

        return $ok
            ? ['sucesso' => true, 'erro' => null]
            : ['sucesso' => false, 'erro' => 'Falha ao enviar via mail()'];
    }
}