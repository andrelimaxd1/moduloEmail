<?php
// view/emailTemplateView.php
namespace App\View;

use App\Model\EmailTemplate;

class emailTemplateView {

    public static function formulario(?string $msg = null, ?EmailTemplate $template = null): void {
        global $primeiroNome, $avatar;
        $isEdit = $template !== null;
        $action = $isEdit ? "?p=template-alt" : "?p=template-cad";
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title><?= $isEdit ? "Editar" : "Cadastrar" ?> Template - Vocare Conecta</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            
            <link rel="stylesheet" type="text/css" href="assets/estilovc.css">
            
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            
            <style>
                :root {
                    --primary-color: #2D5F8B;
                    --secondary-color: #F8F9FA;
                    --text-color: #333333;
                }
                body, html {
                    height: 100%;
                    margin: 0;
                    background-color: var(--secondary-color);
                    font-family: 'Ubuntu', sans-serif;
                    color: var(--text-color);
                }
            </style>
        </head>
        <body class="bodypainel">

            <nav class="navbar navbar-light fixed-top" style="z-index:9999; background: white; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="container-fluid">
                    <div style="display: flex; align-items: center;">
                        <img src="assets/img/vocaretax.png" style="margin-right:15px; height: 38px;" alt="Vocare Tax">
                        <font class="topoincial1 fontmobile" style="margin-left:20px; font-size: 16px;">Painel Administrativo - <b>Módulo E-mail</b></font>
                    </div>
                    <div class="topoinicial2">
                        Você está conectado como <b>Usuário</b> 
                        <img src="assets/img/semavatar.png" style="border-radius: 20px 20px; width:38px;height:38px;margin-right:10px; margin-left:10px;"> 
                        | 
                        <a href="#" class="mudarsenha-icon" style="color: #2D5F8B; margin-left: 10px; margin-right: 10px;">
                            <i class="fa-solid fa-lock fa-lg"></i>
                        </a> 
                        <a href="#" style="text-decoration: none; color: #2D5F8B;">
                            <i class="fa fa-sign-out" aria-hidden="true" style="margin-left:10px;"></i>Sair
                        </a>
                    </div>
                </div>
            </nav>

            <center>
                <div class="container-geral" style="padding-top: 6em; padding-bottom: 3em;">
                    <div class="incialnovo" style="width: 800px; max-width: 95vw; margin-top: 1%; text-align: left; padding: 30px;">
                        
                        <h2 class="txtmsgimportantes" style="font-size: 22px; margin-bottom: 25px; color: #111e39; font-weight: bold;">
                            <i class="fas fa-edit"></i> <?= $isEdit ? "Editar Template de E-mail" : "Cadastrar Novo Template" ?>
                        </h2>
                        
                        <?php if ($msg !== null): ?>
                            <div class="error-message"><?= htmlspecialchars($msg) ?></div>
                        <?php endif; ?>

                        <form action="<?= $action ?>" method="POST">
                            <?php if ($isEdit): ?>
                                <input type="hidden" name="id" value="<?= $template->getId() ?>">
                            <?php endif; ?>

                            <div style="margin-bottom: 18px;">
                                <label class="txtup1" style="font-weight: 500; margin-bottom: 5px; display: block;">Título do Template (Uso interno):</label>
                                <input type="text" name="titulo" class="search-input" required style="width: 100%; box-sizing: border-box;" 
                                       value="<?= $isEdit ? htmlspecialchars($template->getTitulo()) : '' ?>">
                            </div>

                            <div style="margin-bottom: 18px;">
                                <label class="txtup1" style="font-weight: 500; margin-bottom: 5px; display: block;">Assunto do E-mail:</label>
                                <input type="text" name="assunto" class="search-input" required style="width: 100%; box-sizing: border-box;" 
                                       value="<?= $isEdit ? htmlspecialchars($template->getAssunto()) : '' ?>">
                            </div>

                            <div style="margin-bottom: 25px;">
                                <label class="txtup1" style="font-weight: 500; margin-bottom: 5px; display: block;">Corpo do E-mail (HTML permitido):</label>
                                <textarea name="corpo" class="search-input" rows="10" required style="width: 100%; box-sizing: border-box; font-family: monospace; font-size: 14px;"><?= $isEdit ? htmlspecialchars($template->getCorpo()) : '' ?></textarea>
                            </div>

                            <div style="display: flex; gap: 12px;">
                                <button type="submit" class="btn btn-export"><i class="fas fa-save"></i> <?= $isEdit ? "Salvar Alterações" : "Salvar Template" ?></button>
                                <a href="?p=template-list" class="btn btn-search" style="text-decoration: none;"><i class="fas fa-times"></i> Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </center>

            <div class="retornar">
                <a href="?p=template-list" title="Voltar para a lista"><i class="fas fa-arrow-left fa-2x"></i></a>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }

    public static function listar(array $templates, ?int $deletar = null): void {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Templates de E-mail - Vocare Conecta</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            
            <link rel="stylesheet" type="text/css" href="assets/estilovc.css">
            
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            
            <style>
                :root {
                    --primary-color: #2D5F8B;
                    --secondary-color: #F8F9FA;
                    --text-color: #333333;
                }
                body, html {
                    height: 100%;
                    margin: 0;
                    background-color: var(--secondary-color);
                    font-family: 'Ubuntu', sans-serif;
                    color: var(--text-color);
                }
            </style>
        </head>
        <body class="bodypainel">

            <nav class="navbar navbar-light fixed-top" style="z-index:9999; background: white; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="container-fluid">
                    <div style="display: flex; align-items: center;">
                        <img src="assets/img/vocaretax.png" style="margin-right:15px; height: 38px;" alt="Vocare Tax">
                        <font class="topoincial1 fontmobile" style="margin-left:20px; font-size: 16px;">Painel Administrativo - <b>Módulo E-mail</b></font>
                    </div>
                    <div class="topoinicial2">
                        Você está conectado como <b>Usuário</b> 
                        <img src="https://via.placeholder.com/38" style="border-radius: 20px 20px; width:38px;height:38px;margin-right:10px; margin-left:10px;"> 
                        | 
                        <a href="#" class="mudarsenha-icon" style="color: #2D5F8B; margin-left: 10px; margin-right: 10px;">
                            <i class="fa-solid fa-lock fa-lg"></i>
                        </a> 
                        <a href="#" style="text-decoration: none; color: #2D5F8B;">
                            <i class="fa fa-sign-out" aria-hidden="true" style="margin-left:10px;"></i>Sair
                        </a>
                    </div>
                </div>
            </nav>

            <center>
                <div class="container-geral" style="padding-top: 6em; padding-bottom: 3em;">
                    
                    <div class="incialnovo" style="width: 1000px; max-width: 95vw; margin-top: 1%; text-align: left; padding: 30px;">
                        
                        <?php if ($deletar !== null): ?>
                            <div class="error-message" style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 20px; border-radius: 8px; margin-bottom: 25px; text-align: center;">
                                <h4 style="margin-top: 0; font-weight: bold; font-size: 16px;"><i class="fas fa-exclamation-triangle"></i> Atenção!</h4>
                                <p style="margin: 5px 0 15px 0; font-size: 15px;">Tem certeza que deseja excluir este template permanentemente?</p>
                                <div style="display: flex; gap: 12px; justify-content: center;">
                                    <a href="?p=template-deletar&deletar=<?= $deletar ?>" class="btn btn-export2" style="text-decoration: none;"><i class="fas fa-trash-alt"></i> Sim, excluir</a>
                                    <a href="?p=template-list" class="btn btn-search" style="text-decoration: none;"><i class="fas fa-times"></i> Cancelar</a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                            <h2 class="txtmsgimportantes" style="font-size: 22px; color: #111e39; font-weight: bold; margin: 0;">
                                <i class="fas fa-list"></i> Templates de E-mail Cadastrados
                            </h2>
                            <div style="display: flex; gap: 10px;">
                                <a href="?p=template-cad" class="btn btn-search" style="text-decoration: none;"><i class="fas fa-plus"></i> Novo Template</a>
                                <a href="?p=email" class="btn btn-export" style="text-decoration: none;"><i class="fas fa-paper-plane"></i> Ir para Disparos</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="tabela_dados">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">ID</th>
                                        <th>Título Interno</th>
                                        <th>Assunto do E-mail</th>
                                        <th style="width: 220px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($templates)): ?>
                                        <tr><td colspan="4" style="color: #6c757d; padding: 20px;">Nenhum template encontrado.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($templates as $t): ?>
                                            <tr>
                                                <td><strong><?= $t->getId() ?></strong></td>
                                                <td style="text-align: left; font-weight: 500;"><?= htmlspecialchars($t->getTitulo()) ?></td>
                                                <td style="text-align: left; color: #555;"><?= htmlspecialchars($t->getAssunto()) ?></td>
                                                <td>
                                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                                        <a href="?p=template-alt&alt=<?= $t->getId() ?>" class="botaoopcoesempresa" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px;">
                                                            <i class="fas fa-edit" style="font-size: 12px;"></i> Editar
                                                        </a>
                                                        <a href="?p=template-deletar&del=<?= $t->getId() ?>" class="botaoopcoesempresa" style="background-color: #dc3545; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px;">
                                                            <i class="fas fa-trash-alt" style="font-size: 12px;"></i> Excluir
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </center>

            <div class="retornar">
                <a href="?p=home" title="Voltar ao Menu Principal"><i class="fas fa-arrow-left fa-2x"></i></a>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}