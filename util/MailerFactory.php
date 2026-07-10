<?php
// util/MailerFactory.php
namespace App\Util;

abstract class MailerFactory {
    public static function criar(): MailerInterface {
        // Único ponto de troca no dia em que confirmar o SMTP com o gestor:
        // return new PhpMailerAdapter();
        return new NativeMailer();
    }
}