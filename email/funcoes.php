<?php
// funcoes.php

function conectarBanco() {
    // usa as mesmas credenciais/conexão que o resto do Conecta usa
}

function buscarTemplates() {
    // SELECT * FROM email_templates
}

function buscarTemplatePorId($id) {
    // SELECT com JOIN nos anexos
}

function salvarTemplate($nome, $assunto, $corpo) {
    // INSERT
}

function atualizarTemplate($id, $nome, $assunto, $corpo) {
    // UPDATE
}

function excluirTemplate($id) {
    // DELETE
}

function salvarAnexo($templateId, $arquivo) {
    // move_uploaded_file + INSERT na tabela de anexos
}

function enviarEmail($destinatario, $assunto, $corpo, $anexos = []) {
    // PHPMailer aqui
}