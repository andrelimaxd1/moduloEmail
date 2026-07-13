<?php
// view/emailView.php
namespace App\View;

class emailView {
    public static function listar(array $templates, ?string $msg = null): void {
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
                    
                    <?php if ($msg !== null): ?>
                        <div class="sucess-message"><?= $msg ?></div>
                    <?php endif; ?>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 class="txtmsgimportantes" style="font-size: 24px;"><i class="fas fa-paper-plane"></i> Disparo de E-mails</h2>
                        <button type="button" onclick="abrirModalEnvio()" class="btn btn-export">
                            <i class="fas fa-plus"></i> Novo Envio Avulso
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="tabela_dados">
                            <thead>
                                <tr>
                                    <th>Título do Template</th>
                                    <th>Assunto Base</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($templates as $t): ?>
                                <tr>
                                    <td><?= htmlspecialchars($t->getTitulo()) ?></td>
                                    <td><?= htmlspecialchars($t->getAssunto()) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-search" style="margin: 0 auto;"
                                            onclick='abrirModalEnvio(<?= json_encode([
                                                "templateId" => $t->getId(),
                                                "assunto" => $t->getAssunto(),
                                                "corpo" => $t->getCorpo(),
                                            ]) ?>)'>
                                            <i class="fas fa-check"></i> Usar neste envio
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="retornar">
                        <a href="?p=home"><i class="fas fa-arrow-left fa-2x"></i></a>
                    </div>

                    <div id="modalEnvio" class="modal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(17,30,57,0.8); z-index: 9999;">
                        <div class="boxdentro" style="margin: 3% auto; max-width: 700px; position: relative;">
                            
                            <span class="close" onclick="fecharModalEnvio()" style="position: absolute; right: 20px; top: 20px; font-size: 24px; cursor: pointer; color: var(--error-color);"><i class="fas fa-times"></i></span>
                            
                            <h2 class="txtmsgimportantes" style="font-size: 24px; border-bottom: 2px solid var(--color-barra); padding-bottom: 10px; margin-bottom: 20px;">
                                <i class="fas fa-envelope-open-text"></i> Enviar E-mail
                            </h2>

                            <div style="margin-bottom: 15px;">
                                <label class="txtup1">Assunto:</label>
                                <input type="text" id="inpAssunto" class="search-input" style="width: 100%; box-sizing: border-box;">
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label class="txtup1">Corpo do e-mail:</label>
                                <textarea id="inpCorpo" class="search-input" rows="6" style="width: 100%; box-sizing: border-box;"></textarea>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label class="txtup1">Destinatários:</label>
                                <div style="display: flex; gap: 10px;">
                                    <input type="text" id="inpBuscaContato" class="search-input" placeholder="Digite um e-mail livre ou busque um contato..." style="width: 100%; box-sizing: border-box;">
                                    <button type="button" onclick="processarAdicaoDestinatario()" class="btn btn-search" style="white-space: nowrap;"><i class="fas fa-plus"></i> Adicionar</button>
                                </div>
                                
                                <ul id="listaSugestoes" style="list-style: none; padding: 0; margin: 0; background: #fff; border: 1px solid #ccc; max-height: 150px; overflow-y: auto; border-radius: 5px;"></ul>
                                <div id="tagsDestinatarios" style="margin-top: 15px;"></div>
                            </div>

                            <div id="modalMsg" class="error-message" style="display:none; padding: 10px; margin-bottom: 15px;"></div>

                            <div style="text-align: right; margin-top: 10px;">
                                <button type="button" onclick="enviarEmail()" class="btn btn-export" style="width: 100%; justify-content: center; font-size: 18px;">
                                    <i class="fas fa-paper-plane"></i> Disparar E-mail
                                </button>
                            </div>
                        </div>
                    </div>

                    <script src="./assets/emailModal.js"></script>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
