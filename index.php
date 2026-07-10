$page = $_GET["p"] ?? "home";
match($page) {
    "home" => require_once("./view/home.php"),

    "template-list" => EmailTemplateController::listar(),
    "template-cad" => EmailTemplateController::cadastrar(),
    "template-alt" => EmailTemplateController::editar(),
    "template-deletar" => EmailTemplateController::deletar(),

    "email" => EmailController::tela(),
    "email-enviar" => EmailController::enviar(),          // POST via fetch (JSON)
    "email-buscar-contatos" => EmailController::buscarContatos(), // GET via fetch

    default => require_once("./view/404.php"),
};