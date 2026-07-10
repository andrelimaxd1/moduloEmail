// Variáveis de estado para controlar os envios e seleções
let templateIdSelecionado = null;
let destinatariosSelecionados = [];

// ==========================================
// CONTROLO DO MODAL
// ==========================================

function abrirModalEnvio(dados = null) {
    const modal = document.getElementById('modalEnvio');
    const modalMsg = document.getElementById('modalMsg');
    
    modal.style.display = 'block';
    modalMsg.style.display = 'none';

    // Se vierem dados (via botão "Usar neste envio"), preenche os campos
    if (dados) {
        templateIdSelecionado = dados.templateId;
        document.getElementById('inpAssunto').value = dados.assunto || '';
        document.getElementById('inpCorpo').value = dados.corpo || '';
    } else {
        templateIdSelecionado = null;
        document.getElementById('inpAssunto').value = '';
        document.getElementById('inpCorpo').value = '';
    }

    // Limpa destinatários anteriores
    destinatariosSelecionados = [];
    document.getElementById('inpBuscaContato').value = '';
    document.getElementById('listaSugestoes').innerHTML = '';
    atualizarTagsDestinatarios();
}

function fecharModalEnvio() {
    document.getElementById('modalEnvio').style.display = 'none';
}

// Fechar modal ao clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById('modalEnvio');
    if (event.target == modal) {
        fecharModalEnvio();
    }
}

// ==========================================
// BUSCA DE CONTATOS E AUTOCORRECT
// ==========================================

document.addEventListener("DOMContentLoaded", () => {
    const inpBusca = document.getElementById('inpBuscaContato');
    
    if(inpBusca) {
        inpBusca.addEventListener('input', async (e) => {
            const q = e.target.value.trim();
            const listaSugestoes = document.getElementById('listaSugestoes');

            if (q.length < 2) {
                listaSugestoes.innerHTML = '';
                return;
            }

            try {
                // Faz a requisição GET ao controller para buscar os contatos
                const resposta = await fetch(`?p=email-buscar-contatos&q=${encodeURIComponent(q)}`);
                const contatos = await resposta.json();
                
                listaSugestoes.innerHTML = '';
                
                contatos.forEach(c => {
                    const li = document.createElement('li');
                    li.textContent = `${c.nome} (${c.email})`;
                    li.style.cursor = 'pointer';
                    // Ao clicar na sugestão, adiciona o contato aos destinatários
                    li.onclick = () => adicionarDestinatario(c.email, c.id);
                    listaSugestoes.appendChild(li);
                });
            } catch (error) {
                console.error("Erro ao buscar contatos", error);
            }
        });

        // Permite adicionar um e-mail livre ao pressionar "Enter"
        inpBusca.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const emailDigitado = e.target.value.trim();
                // Validação básica de e-mail
                if (emailDigitado.includes('@') && emailDigitado.includes('.')) {
                    adicionarDestinatario(emailDigitado, null);
                } else {
                    mostrarMensagem("Por favor, introduza um e-mail válido.", true);
                }
            }
        });
    }
});

// ==========================================
// GESTÃO DE DESTINATÁRIOS (TAGS)
// ==========================================

function adicionarDestinatario(email, usuarioId = null) {
    // Evitar adicionar e-mails duplicados
    const jaExiste = destinatariosSelecionados.find(d => d.email === email);
    
    if (!jaExiste) {
        destinatariosSelecionados.push({ email: email, usuarioId: usuarioId });
        atualizarTagsDestinatarios();
    }
    
    // Limpa o campo de busca e a lista
    document.getElementById('inpBuscaContato').value = '';
    document.getElementById('listaSugestoes').innerHTML = '';
}

function removerDestinatario(email) {
    destinatariosSelecionados = destinatariosSelecionados.filter(d => d.email !== email);
    atualizarTagsDestinatarios();
}

function atualizarTagsDestinatarios() {
    const container = document.getElementById('tagsDestinatarios');
    container.innerHTML = '';
    
    destinatariosSelecionados.forEach(d => {
        const span = document.createElement('span');
        // Estilização básica da tag (podes ajustar o CSS)
        span.style.display = 'inline-block';
        span.style.background = '#e2e8f0';
        span.style.padding = '5px 10px';
        span.style.margin = '2px';
        span.style.borderRadius = '15px';
        span.style.fontSize = '14px';
        
        span.innerHTML = `${d.email} <strong style="cursor:pointer; color:red; margin-left:5px;" onclick="removerDestinatario('${d.email}')">&times;</strong>`;
        container.appendChild(span);
    });
}

// ==========================================
// ENVIO DO E-MAIL
// ==========================================

async function enviarEmail() {
    const assunto = document.getElementById('inpAssunto').value;
    const corpo = document.getElementById('inpCorpo').value;

    if (destinatariosSelecionados.length === 0) {
        mostrarMensagem('Adicione pelo menos um destinatário.', true);
        return;
    }

    if (assunto.trim() === '' || corpo.trim() === '') {
        mostrarMensagem('O assunto e o corpo do e-mail são obrigatórios.', true);
        return;
    }

    // Monta o payload no formato esperado pelo EmailController::enviar()
    const payload = {
        templateId: templateIdSelecionado,
        assunto: assunto,
        corpo: corpo,
        destinatarios: destinatariosSelecionados
    };

    mostrarMensagem('A enviar...', false, '#000');

    try {
        const resposta = await fetch('?p=email-enviar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const resultado = await resposta.json();

        if (resposta.ok && resultado.sucesso) {
            mostrarMensagem(`E-mail enviado! Sucesso: ${resultado.totalEnviado} | Falhas: ${resultado.totalFalha}`, false);
            // Fecha o modal passado 2 segundos em caso de sucesso
            setTimeout(fecharModalEnvio, 2000);
        } else {
            mostrarMensagem(resultado.erro || 'Erro ao enviar os e-mails.', true);
        }
    } catch (error) {
        console.error(error);
        mostrarMensagem('Erro de conexão com o servidor ao tentar enviar.', true);
    }
}

function mostrarMensagem(msg, isError, corFixa = null) {
    const modalMsg = document.getElementById('modalMsg');
    modalMsg.textContent = msg;
    modalMsg.style.display = 'block';
    
    if (corFixa) {
        modalMsg.style.color = corFixa;
    } else {
        modalMsg.style.color = isError ? 'red' : 'green';
    }
}