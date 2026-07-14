<?php
namespace App\Util;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PhpMailerAdapter implements MailerInterface {
    
    public function enviar(string $destinatario, string $assunto, string $corpoHtml, array $anexos = []): array {
        
        $mail = new PHPMailer(true);

        try {
            
            // 1. CONFIGURAÇÕES DO SERVIDOR (MAILTRAP)
            
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = '140dbaf52fb5c2'; 
            $mail->Password   = 'ef149b966db915'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525; 
            $mail->CharSet    = 'UTF-8';

           
            // 2. REMETENTE E DESTINATÁRIO
            
            // Como é um teste, você pode inventar qualquer e-mail de remetente
            $mail->setFrom('sistema@vocareconecta.com.br', 'Vocare Conecta (Teste)');
            $mail->addAddress($destinatario);

            
            // 3. CONTEÚDO DO E-MAIL
            
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $corpoHtml;
            
            $mail->AltBody = strip_tags($corpoHtml); 

            
            // 4. LÓGICA DE ANEXOS (Múltiplos arquivos)
            
            if (!empty($anexos['name']) && is_array($anexos['name'])) {
                for ($i = 0; $i < count($anexos['name']); $i++) {
                    
                    if ($anexos['error'][$i] === UPLOAD_ERR_OK) {
                        
                        $tmpName = $anexos['tmp_name'][$i];
                        $fileName = $anexos['name'][$i];
                        
                        $mail->addAttachment($tmpName, $fileName);
                    }
                }
            }

            
            // 5. DISPARO
            
            $mail->send();
            return ['sucesso' => true, 'erro' => null];

        } catch (Exception $e) {
        
            return ['sucesso' => false, 'erro' => $mail->ErrorInfo];
        }
    }
}