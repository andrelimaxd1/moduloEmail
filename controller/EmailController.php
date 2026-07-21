<?php
// controller/EmailController.php
namespace App\Controller;

use App\Model\Email;
use App\Dal\EmailTemplateDao;
use App\Dal\EmailDao;
use App\Dal\UsuarioDao; // supondo que exista, ajuste ao seu Dao real de contatos
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
        if ($templateId) {
            $template = \App\Dal\EmailTemplateDao::buscarPorId($templateId);
            if ($template && $template->getAnexos()) {
                $lista = json_decode($template->getAnexos(), true);
                if (is_array($lista)) {
                    foreach ($lista as $caminho) {
                        $caminhoAbsoluto = __DIR__ . '/../' . $caminho;
                        if (file_exists($caminhoAbsoluto) && is_file($caminhoAbsoluto)) {
                            $anexosDoTemplate[] = $caminhoAbsoluto;
                        }
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
        }

        $emailId = EmailDao::registrarEnvio($email, $resultados);

        $falhas = array_filter($resultados, fn($r) => !$r['sucesso']);

        echo json_encode([
            'sucesso' => count($falhas) === 0,
            'emailId' => $emailId,
            'totalEnviado' => count($resultados) - count($falhas),
            'totalFalha' => count($falhas),
        ]);
    } catch (\InvalidArgumentException $e) {
        http_response_code(422);
        echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'erro' => 'Erro interno ao enviar.']);
    }
    exit;
}

    // AJAX de autocomplete: ?p=email-buscar-contatos&q=ana
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