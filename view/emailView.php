<?php
// view/emailView.php
namespace App\View;

class emailView {
    public static function listar(array $templates, ?string $msg = null): void {
        global $primeiroNome, $avatar;
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Disparo de E-mails - Vocare Conecta</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            
            <link rel="stylesheet" type="text/css" href="assets/estilovc.css">
            
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            
            <style>
                :root {
                    --primary-color: #111e39;
                    --secondary-color: #F8F9FA;
                    --text-color: #333333;
                    --color-barra: #2d5f8b;
                }
                body, html {
                    height: 100%;
                    margin: 0;
                    background-color: var(--secondary-color);
                    font-family: 'Ubuntu', sans-serif;
                    color: var(--text-color);
                }
                /* Estilização extra para a lista de sugestões do Autocomplete */
                #listaSugestoes li:hover {
                    background-color: #f1f1f1;
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
                    <!-- Lado Direito: Usuário e Avatar -->
                    <div class="topoinicial2" style="display: flex; align-items: center;">
    
                        Você está conectado como <b><?php echo $primeiroNome; ?></b> 
    
                        <!-- Link para o perfil e Imagem dinâmica do Avatar -->
                    <a href="../infousuario.php">
                    <img src="<?php echo $avatar; ?>" style="border-radius: 20px 20px; width: 38px; height: 38px; margin-right: 10px; margin-left: 10px;" alt="Avatar do Usuário">
                    </a> | 
    
                <!-- Botão de alterar senha -->
                    <a href="../alterasenhagestao.php" class="mudarsenha-icon" style="color: #111e39; margin-left: 10px; margin-right: 10px;">
                    <i class="fa-solid fa-lock fa-lg"></i>
                     </a> 
    
                <!-- Botão de Sair -->
                    <a href="../logout.php" style="text-decoration: none; color: #111e39;">
                    <i class="fa fa-sign-out" aria-hidden="true" style="margin-left: 10px;"></i>Sair
                 </a>
    
</div>
                </div>
            </nav>

            <center>
                <div class="container-geral" style="padding-top: 6em; padding-bottom: 3em;">
                    
                    <div class="incialnovo" style="width: 1000px; max-width: 95vw; margin-top: 1%; text-align: left; padding: 30px;">
                        
                        <?php if ($msg !== null): ?>
                            <div class="sucess-message" style="margin-bottom: 20px; padding: 15px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; text-align: center;">
                                <?= htmlspecialchars($msg) ?>
                            </div>
                        <?php endif; ?>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                            <h2 class="txtmsgimportantes" style="font-size: 22px; color: #111e39; font-weight: bold; margin: 0;">
                                <i class="fas fa-paper-plane"></i> Central de Disparos
                            </h2>
                            <button type="button" onclick="abrirModalEnvio()" class="btn btn-export" style="border-radius: 5px; font-weight: bold;">
                                <i class="fas fa-bolt"></i> Novo Envio Avulso
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="tabela_dados">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Título do Template</th>
                                        <th>Assunto Base</th>
                                        <th style="width: 180px;">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (empty($templates)): ?>
                                    <tr><td colspan="3" style="color: #6c757d; padding: 20px; text-align: center;">Nenhum template cadastrado para uso.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($templates as $t): ?>
                                        <tr>
                                            <td style="text-align: left; font-weight: 500;"><?= htmlspecialchars($t->getTitulo()) ?></td>
                                            <td style="text-align: left; color: #555;"><?= htmlspecialchars($t->getAssunto()) ?></td>
                                            <td>
                                                <button type="button" class="botaoopcoesempresa" style="margin: 0 auto; display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%;"
                                                    onclick='abrirModalEnvio(<?= json_encode([
                                                        "templateId" => $t->getId(),
                                                        "assunto" => $t->getAssunto(),
                                                        "corpo" => $t->getCorpo(),
                                                    ]) ?>)'>
                                                    <i class="fas fa-check-circle"></i> Usar Template
                                                </button>
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

            <div id="modalEnvio" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(17,30,57,0.85); z-index: 10000; overflow-y: auto;">
                
                <div class="incialnovo" style="margin: 5% auto; max-width: 750px; width: 90%; position: relative; text-align: left; padding: 30px; box-shadow: 0 15px 50px rgba(0,0,0,0.5);">
                    
                    <span onclick="fecharModalEnvio()" style="position: absolute; right: 25px; top: 25px; font-size: 26px; cursor: pointer; color: #dc3545; transition: 0.3s;">
                        <i class="fas fa-times-circle"></i>
                    </span>
                    
                    <h2 class="txtmsgimportantes" style="font-size: 24px; border-bottom: 2px solid var(--color-barra); padding-bottom: 12px; margin-bottom: 25px; color: #111e39; font-weight: bold;">
                        <i class="fas fa-envelope-open-text"></i> Configurar Envio
                    </h2>

                    <div style="margin-bottom: 20px;">
                        <label class="txtup1" style="font-weight: 500; margin-bottom: 5px; display: block;">Assunto:</label>
                        <input type="text" id="inpAssunto" class="search-input" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="txtup1" style="font-weight: 500; margin-bottom: 5px; display: block;">Corpo do e-mail:</label>
                        <textarea id="inpCorpo" class="search-input" rows="8" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-family: monospace;"></textarea>
                    </div>

                    <div style="margin-bottom: 20px; background-color: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #e9ecef;">
                        <label class="txtup1" style="font-weight: bold; margin-bottom: 10px; display: block; color: #111e39;">
                            <i class="fas fa-users"></i> Adicionar Destinatários:
                        </label>
                        
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <input type="text" id="inpBuscaContato" class="search-input" placeholder="Digite um e-mail livre ou busque um contato pelo nome..." style="flex: 1; min-width: 250px; box-sizing: border-box;">
                            <button type="button" onclick="processarAdicaoDestinatario()" class="btn btn-search" style="white-space: nowrap; font-weight: bold;">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                        </div>
                        
                        <ul id="listaSugestoes" style="list-style: none; padding: 0; margin: 5px 0 0 0; background: #fff; border: 1px solid #ccc; max-height: 150px; overflow-y: auto; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></ul>
                        
                        <div id="tagsDestinatarios" style="margin-top: 15px; display: flex; flex-wrap: wrap; gap: 8px;"></div>
                    </div>

                    <div id="modalMsg" style="display:none; padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold; text-align: center;"></div>

                    <div style="text-align: right; margin-top: 20px;">
                        <button type="button" onclick="enviarEmail()" class="btn btn-export" style="width: 100%; justify-content: center; font-size: 18px; padding: 15px; border-radius: 8px; font-weight: bold;">
                            <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Iniciar Disparo
                        </button>
                    </div>

                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="assets/emailModal.js"></script>
        </body>
        </html>
        <?php
    }
}