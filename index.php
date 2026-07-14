<?php
require_once "./vendor/autoload.php";
require_once "./Autoload.php";

use App\Controller\EmailTemplateController;
use App\Controller\EmailController;

$page = $_GET["p"] ?? "home";
match($page) {
    "home" => require_once("./view/home.php"),

    "template-list" => EmailTemplateController::listar(),
    "template-cad" => EmailTemplateController::cadastrar(),
    "template-alt" => EmailTemplateController::editar(),
    "template-deletar" => EmailTemplateController::deletar(),

    "email" => EmailController::tela(),
    "email-enviar" => EmailController::enviar(),
    "email-buscar-contatos" => EmailController::buscarContatos(),

    default => require_once("./view/404.php"),
};