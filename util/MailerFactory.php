<?php
namespace App\Util;

abstract class MailerFactory {
    public static function criar(): MailerInterface {
        return new PhpMailerAdapter();
        
    }
}