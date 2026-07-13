<?php
// view/emailTemplateView.php
namespace App\View;

use App\Model\EmailTemplate;

class emailTemplateView {

    public static function formulario(?string $msg = null, ?EmailTemplate $template = null): void {
        $isEdit = $template !== null;
        $action = $isEdit ? "?p=template-alt" : "?p=template-cad";
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="./estilovc.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        </head>
        <body class="bodyportal">
            <div class="container-geral">
                <div class="boxdentro" style="max-width: 800px;">
                    <h2 class="txtmsgimportantes" style="font-size: 24px; margin-bottom: 20px;">
                        <i class="fas fa-edit"></i> <?= $isEdit ? "Editar Template de E-mail" : "Cadastrar Novo Template" ?>
                    </h2>
                    
                    <?php if ($msg !== null): ?>
                        <div class="error-message"><?= htmlspecialchars($msg) ?></div>
                    <?php endif; ?>

                    <form action="<?= $action ?>" method="POST">
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="id" value="<?= $template->getId() ?>">
                        <?php endif; ?>

                        <div style="margin-bottom: 15px;">
                            <label class="txtup1">Título do Template (Uso interno):</label>
                            <input type="text" name="titulo" class="search-input" required style="width: 100%; box-sizing: border-box;" 
                                   value="<?= $isEdit ? htmlspecialchars($template->getTitulo()) : '' ?>">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label class="txtup1">Assunto do E-mail:</label>
                            <input type="text" name="assunto" class="search-input" required style="width: 100%; box-sizing: border-box;" 
                                   value="<?= $isEdit ? htmlspecialchars($template->getAssunto()) : '' ?>">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="txtup1">Corpo do E-mail (HTML permitido):</label>
                            <textarea name="corpo" class="search-input" rows="10" required style="width: 100%; box-sizing: border-box;"><?= $isEdit ? htmlspecialchars($template->getCorpo()) : '' ?></textarea>
                        </div>

                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-export"><i class="fas fa-save"></i> <?= $isEdit ? "Salvar Alterações" : "Salvar Template" ?></button>
                            <a href="?p=template-list" class="btn btn-search" style="text-decoration: none;">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
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
            <link rel="stylesheet" href="./estilovc.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        </head>
        <body class="bodyportal">
            <div class="container-geral">
                <div class="boxdentro" style="width: 90vw;">
                    
                    <?php if ($deletar !== null): ?>
                        <div class="error-message" style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                            <p style="margin: 0 0 10px 0;"><strong>Atenção:</strong> Tem certeza que deseja excluir este template permanentemente?</p>
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <a href="?p=template-deletar&deletar=<?= $deletar ?>" class="btn btn-export2">Sim, excluir</a>
                                <a href="?p=template-list" class="btn btn-search" style="text-decoration: none;">Cancelar</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 class="txtmsgimportantes" style="font-size: 24px;"><i class="fas fa-list"></i> Templates de E-mail</h2>
                        <div style="display: flex; gap: 10px;">
                            <a href="?p=template-cad" class="btn btn-search" style="text-decoration: none;"><i class="fas fa-plus"></i> Novo Template</a>
                            <a href="?p=email" class="btn btn-export" style="text-decoration: none;"><i class="fas fa-paper-plane"></i> Ir para Disparos</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tabela_dados">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título Interno</th>
                                    <th>Assunto do E-mail</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($templates)): ?>
                                    <tr><td colspan="4">Nenhum template encontrado.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($templates as $t): ?>
                                        <tr>
                                            <td><?= $t->getId() ?></td>
                                            <td><?= htmlspecialchars($t->getTitulo()) ?></td>
                                            <td><?= htmlspecialchars($t->getAssunto()) ?></td>
                                            <td>
                                                <a href="?p=template-alt&alt=<?= $t->getId() ?>" class="botaoopcoesempresa" style="text-decoration: none; display: inline-block; margin-right: 5px;">Editar</a>
                                                <a href="?p=template-deletar&del=<?= $t->getId() ?>" class="botaoopcoesempresa" style="background-color: #dc3545; text-decoration: none; display: inline-block;">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="retornar">
                        <a href="?p=home"><i class="fas fa-arrow-left fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}