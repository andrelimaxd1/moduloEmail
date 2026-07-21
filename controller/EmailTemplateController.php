<?php
// controller/EmailTemplateController.php
namespace App\Controller;

use App\Util\Functions as Util;
use App\Model\EmailTemplate;
use App\Dal\EmailTemplateDao;
use App\View\emailTemplateView;
use App\View\emailView;
use App\Util\UploadService;


class EmailTemplateController {
    public static ?string $msg = null;

    public static function cadastrar(): void {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["titulo"])) {
            try {

                $jsonAnexos = UploadService::uploadAnexosMultiplos($_FILES['anexos'] ?? null, 'templates');

                $t = EmailTemplate::criar(
                    null,
                    Util::preparaTexto($_POST["titulo"]),
                    Util::preparaTexto($_POST["assunto"]),
                    $_POST["corpo"],
                    $jsonAnexos
                );
                
                EmailTemplateDao::cadastrar($t);
                header("Location: ?p=template-list");
                exit;
            } catch (\Exception $e) {
                self::$msg = $e->getMessage();
            }
        }
        emailTemplateView::formulario(self::$msg);
    }

    public static function editar(): void {
        $template = null;
        if (isset($_GET["alt"])) {
            $template = EmailTemplateDao::buscarPorId((int)$_GET["alt"]);
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["id"])) {
            try {

                $templateAntigo = EmailTemplateDao::buscarPorId((int)$_POST["id"]);
                $jsonAnexos = $templateAntigo->getAnexos();

                $novosAnexos = UploadService::uploadAnexosMultiplos($_FILES['anexos'] ?? null, 'templates');
                
                if ($novosAnexos !== null) {
                    $jsonAnexos = $novosAnexos;
                }

                $t = EmailTemplate::criar(
                    (int)$_POST["id"],
                    Util::preparaTexto($_POST["titulo"]),
                    Util::preparaTexto($_POST["assunto"]),
                    $_POST["corpo"],
                    $jsonAnexos
                );
                
                EmailTemplateDao::editar($t);
                header("Location: ?p=template-list");
                exit;
            } catch (\Exception $e) {
                self::$msg = $e->getMessage();
            }
        }
        emailTemplateView::formulario(self::$msg, $template);
    }

    public static function listar(?int $deletar = null): void {
        $templates = EmailTemplateDao::listar();
        emailTemplateView::listar($templates, $deletar);
    }

    public static function deletar(): void {
    if (isset($_GET["del"])) {
        self::listar((int)$_GET["del"]);
        return;
    }
    
    if (isset($_GET["deletar"])) {
        $idDeletar = (int)$_GET["deletar"];
        
        $template = EmailTemplateDao::buscarPorId($idDeletar);
        
        UploadService::deletarArquivos($template->getAnexos());
        
        EmailTemplateDao::excluir($idDeletar);
        header("Location: ?p=template-list");
        exit;
    }
}
}