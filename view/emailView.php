<?php
// view/emailTemplateView.php
namespace App\View;

use App\Model\EmailTemplate;

class emailView {

    // Renderiza o formulário (usado para cadastrar e para editar)
    public static function formulario(?string $msg = null, ?emailView $template = null): void {
        $isEdit = $template !== null;
        $action = $isEdit ? "?p=template-alt" : "?p=template-cad";
        
        if ($msg !== null): ?>
            <div class="alert" style="color: red; font-weight: bold; margin-bottom: 15px;"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <h2><?= $isEdit ? "Editar Template de E-mail" : "Cadastrar Novo Template" ?></h2>
        
        <form action="<?= $action ?>" method="POST" style="max-width: 600px;">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $template->getId() ?>">
            <?php endif; ?>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: bold;">Título do Template (Uso interno):</label>
                <input type="text" name="titulo" required style="width: 100%; padding: 8px;" 
                       value="<?= $isEdit ? htmlspecialchars($template->getTitulo()) : '' ?>">
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: bold;">Assunto do E-mail:</label>
                <input type="text" name="assunto" required style="width: 100%; padding: 8px;" 
                       value="<?= $isEdit ? htmlspecialchars($template->getAssunto()) : '' ?>">
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: bold;">Corpo do E-mail (HTML permitido):</label>
                <textarea name="corpo" rows="10" required style="width: 100%; padding: 8px;"><?= $isEdit ? htmlspecialchars($template->getCorpo()) : '' ?></textarea>
            </div>

            <button type="submit" style="padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer;">
                <?= $isEdit ? "Salvar Alterações" : "Salvar Template" ?>
            </button>
            
            <a href="?p=template-list" style="margin-left: 10px; text-decoration: none; color: #6c757d;">Cancelar</a>
        </form>
        <?php
    }

    // Renderiza a tabela com todos os templates salvos
    public static function listar(array $templates, ?int $deletar = null): void {
        // Se o controller passar um ID em $deletar, exibe uma mensagem de confirmação
        if ($deletar !== null): ?>
            <div style="background: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; margin-bottom: 20px;">
                <p style="margin: 0 0 10px 0;"><strong>Atenção:</strong> Tem certeza que deseja excluir este template permanentemente?</p>
                <a href="?p=template-deletar&deletar=<?= $deletar ?>" style="background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; display: inline-block; font-size: 14px;">Sim, desejo excluir</a>
                <a href="?p=template-list" style="background: #6c757d; color: white; padding: 6px 12px; text-decoration: none; display: inline-block; font-size: 14px; margin-left: 5px;">Cancelar</a>
            </div>
        <?php endif; ?>

        <h2>Templates de E-mail Cadastrados</h2>
        
        <div style="margin-bottom: 15px;">
            <a href="?p=template-cad" style="background: #007bff; color: white; padding: 8px 12px; text-decoration: none; display: inline-block;">+ Criar Novo Template</a>
            <a href="?p=email" style="background: #17a2b8; color: white; padding: 8px 12px; text-decoration: none; display: inline-block; margin-left: 5px;">Ir para Envio de E-mails</a>
        </div>

        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th>ID</th>
                    <th>Título Interno</th>
                    <th>Assunto do E-mail</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($templates)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #777;">Nenhum template encontrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($templates as $t): ?>
                        <tr>
                            <td><?= $t->getId() ?></td>
                            <td><?= htmlspecialchars($t->getTitulo()) ?></td>
                            <td><?= htmlspecialchars($t->getAssunto()) ?></td>
                            <td>
                                <a href="?p=template-alt&alt=<?= $t->getId() ?>" style="color: #007bff; text-decoration: none;">Editar</a>
                                <span style="color: #ccc;"> | </span>
                                <a href="?p=template-deletar&del=<?= $t->getId() ?>" style="color: #dc3545; text-decoration: none;">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <p style="margin-top: 15px;"><a href="?p=home" style="text-decoration: none; color: #6c757d;">← Voltar à Home</a></p>
        <?php
    }
}