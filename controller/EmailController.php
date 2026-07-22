<?php
// controller/EmailController.php
namespace App\Controller;

use App\Model\Email;
use App\Dal\EmailTemplateDao;
use App\Dal\EmailDao;
use App\Dal\UsuarioDao; 
use App\Util\MailerFactory;
use App\View\emailView;

class EmailController {
    public static ?string $msg = null;

    public static function tela(): void {
        $templates = EmailTemplateDao::listar();
        emailView::listar($templates, self::$msg);
    }

    public static function enviar(): void {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $input = json_decode($_POST['dados'] ?? '{}', true);

        $assunto = trim($input['assunto'] ?? '');
        $corpo = $input['corpo'] ?? '';
        $templateId = isset($input['templateId']) && $input['templateId'] !== ''
            ? (int)$input['templateId'] : null;

        $destinatarios = $input['destinatarios'] ?? [];

        $email = Email::criar($templateId, $assunto, $corpo, $destinatarios);

        $anexosDoTemplate = [];
        $anexosFront = $input['anexosTemplate'] ?? [];

        if (!empty($anexosFront)) {
            foreach ($anexosFront as $anexo) {
                $caminho = is_array($anexo) ? ($anexo['nome_arquivo'] ?? $anexo['nome'] ?? $anexo['caminho'] ?? '') : $anexo;
                
                if (!empty($caminho)) {
                    $caminhoAbsoluto = __DIR__ . '/../' . $caminho;
                    
                    if (file_exists($caminhoAbsoluto) && is_file($caminhoAbsoluto)) {
                        $anexosDoTemplate[] = $caminhoAbsoluto;
                    } else {
                        error_log("Anexo de template não localizado no servidor: " . $caminhoAbsoluto);
                    }
                }
            }
        }

        $arquivosUpload = $_FILES['anexos'] ?? [];

        $mailer = MailerFactory::criar();
        $resultados = [];
        
        foreach ($email->getDestinatarios() as $d) {
            
            $resultados[] = $mailer->enviar(
                $d['email'], 
                $email->getAssunto(), 
                $email->getCorpo(), 
                $arquivosUpload, 
                $anexosDoTemplate 
            );

            
            sleep(6); 
        }

        $emailId = EmailDao::registrarEnvio($email, $resultados);

        $falhas = array_filter($resultados, fn($r) => !$r['sucesso']);

        echo json_encode([
            'sucesso' => count($falhas) === 0,
            'emailId' => $emailId,
            'totalEnviado' => count($resultados) - count($falhas),
            'totalFalha' => count($falhas),
            'detalhes_falhas' => $falhas 
        ]);
    } catch (\InvalidArgumentException $e) {
        http_response_code(422);
        echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
    } catch (\Exception $e) {
        http_response_code(500);
        
        echo json_encode([
            'sucesso' => false, 
            'erro' => $e->getMessage(), 
            'arquivo' => $e->getFile(), 
            'linha' => $e->getLine()
        ]); 
    }
    exit;
}

    public static function buscarContatos(): void {
        header('Content-Type: application/json; charset=utf-8');
        $q = trim($_GET['q'] ?? '');
        if (strlen($q) < 2) {
            echo json_encode([]);
            exit;
        }
        // // Ajuste para o Dao real que já lista Usuario/Cliente no seu sistema
        // $usuarios = UsuarioDao::buscarPorNomeOuEmail($q);
        // echo json_encode(array_map(fn($u) => [
        //     'id' => $u->getId(),
        //     'nome' => $u->getNome() ?? $u->getEmail(),
        //     'email' => $u->getEmail(),
        // ], $usuarios));
        // exit;
    }
}