<?php
// view/emailView.php
namespace App\View;

class emailView {
    public static function listar(array $templates, ?string $msg = null): void {
        if ($msg !== null): ?>
            <div class="alert"><?= $msg ?></div>
        <?php endif; ?>

        <button type="button" onclick="abrirModalEnvio()">Enviar E-mail</button>

        <table>
            <thead><tr><th>Título</th><th>Assunto</th><th>Ação</th></tr></thead>
            <tbody>
            <?php foreach ($templates as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t->getTitulo()) ?></td>
                    <td><?= htmlspecialchars($t->getAssunto()) ?></td>
                    <td>
                        <button type="button"
                            onclick='abrirModalEnvio(<?= json_encode([
                                "templateId" => $t->getId(),
                                "assunto" => $t->getAssunto(),
                                "corpo" => $t->getCorpo(),
                            ]) ?>)'>
                            Usar neste envio
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- MODAL -->
        <div id="modalEnvio" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="fecharModalEnvio()">&times;</span>
                <h2>Enviar E-mail</h2>

                <label>Assunto:</label>
                <input type="text" id="inpAssunto">

                <label>Corpo:</label>
                <textarea id="inpCorpo" rows="6"></textarea>

                <label>Destinatários:</label>
                <input type="text" id="inpBuscaContato" placeholder="Digite um e-mail ou nome cadastrado...">
                <ul id="listaSugestoes"></ul>
                <div id="tagsDestinatarios"></div>

                <div id="modalMsg" class="alert" style="display:none;"></div>

                <button type="button" onclick="enviarEmail()">Enviar</button>
            </div>
        </div>

        <script src="./assets/emailModal.js"></script>
        <?php
    }
}