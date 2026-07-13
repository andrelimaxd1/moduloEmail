// Variáveis globais
let templateIdSelecionado = null;
let destinatariosSelecionados = [];


// CONTROLE Modal


function abrirModalEnvio(dados = null) {
    const modal = document.getElementById('modalEnvio');
    const modalMsg = document.getElementById('modalMsg');
    
    modal.style.display = 'block';
    modalMsg.style.display = 'none';

    if (dados) {
        templateIdSelecionado = dados.templateId;
        document.getElementById('inpAssunto').value = dados.assunto || '';
        document.getElementById('inpCorpo').value = dados.corpo || '';
    } else {
        templateIdSelecionado = null;
        document.getElementById('inpAssunto').value = '';
        document.getElementById('inpCorpo').value = '';
    }

    destinatariosSelecionados = [];
    document.getElementById('inpBuscaContato').value = '';
    document.getElementById('listaSugestoes').innerHTML = '';
    atualizarTagsDestinatarios();
}

function fecharModalEnvio() {
    document.getElementById('modalEnvio').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('modalEnvio');
    if (event.target == modal) {
        fecharModalEnvio();
    }
}


// Adicionar

async function processarAdicaoDestinatario() {
    const inpBusca = document.getElementById('inpBuscaContato');
    const q = inpBusca.value.trim();
    const listaSugestoes = document.getElementById('listaSugestoes');

    if (q === '') {
        mostrarMensagem("Por favor, digite um e-mail ou nome para adicionar.", true);
        return;
    }

    // 1. Se for um e-mail válido, adiciona diretamente (Não vai ao banco de dados)
    if (q.includes('@') && q.includes('.')) {
        adicionarDestinatario(q, null);
        return;
    }

    // 2. Se for uma palavra curta, barra a pesquisa
    if (q.length < 2) {
        mostrarMensagem("Digite pelo menos 2 letras para buscar contatos.", true);
        return;
    }

    // 3. Se for um nome (ex: "ana"), faz a busca no banco APENAS 1 VEZ ao clicar no botão
    try {
        listaSugestoes.innerHTML = '<li style="padding:5px;">Buscando contato...</li>';
        
        const resposta = await fetch(`?p=email-buscar-contatos&q=${encodeURIComponent(q)}`);
        const contatos = await resposta.json();
        
        listaSugestoes.innerHTML = '';
        
        if (contatos.length === 0) {
            listaSugestoes.innerHTML = '<li style="padding:5px; color:red;">Nenhum contato encontrado.</li>';
            return;
        }

        // Mostra os contatos encontrados para o utilizador clicar
        contatos.forEach(c => {
            const li = document.createElement('li');
            li.textContent = `${c.nome} (${c.email})`;
            li.style.cursor = 'pointer';
            li.style.padding = '8px';
            li.style.borderBottom = '1px solid #eee';
            
            li.onclick = () => adicionarDestinatario(c.email, c.id);
            listaSugestoes.appendChild(li);
        });
    } catch (error) {
        console.error("Erro ao buscar", error);
        listaSugestoes.innerHTML = '<li style="color:red; padding:5px;">Erro na comunicação com o servidor.</li>';
    }
}

// Opcional: Permitir que o utilizador carregue no "Enter" no teclado para simular o clique no botão "Adicionar"
document.addEventListener("DOMContentLoaded", () => {
    const inpBusca = document.getElementById('inpBuscaContato');
    if(inpBusca) {
        inpBusca.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                processarAdicaoDestinatario();
            }
        });
    }
});


// Gestão de destinátario

function adicionarDestinatario(email, usuarioId = null) {
    const jaExiste = destinatariosSelecionados.find(d => d.email === email);
    
    if (!jaExiste) {
        destinatariosSelecionados.push({ email: email, usuarioId: usuarioId });
        atualizarTagsDestinatarios();
    }
    
    // Limpa o campo para o próximo e-mail
    document.getElementById('inpBuscaContato').value = '';
    document.getElementById('listaSugestoes').innerHTML = '';
    
    // Remove mensagens de erro anteriores
    document.getElementById('modalMsg').style.display = 'none'; 
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


// Disparo de email


async function enviarEmail() {
    const assunto = document.getElementById('inpAssunto').value;
    const corpo = document.getElementById('inpCorpo').value;

    if (destinatariosSelecionados.length === 0) {
        mostrarMensagem('Adicione pelo menos um destinatário na lista antes de enviar.', true);
        return;
    }

    if (assunto.trim() === '' || corpo.trim() === '') {
        mostrarMensagem('O assunto e o corpo do e-mail são obrigatórios.', true);
        return;
    }

    const payload = {
        templateId: templateIdSelecionado,
        assunto: assunto,
        corpo: corpo,
        destinatarios: destinatariosSelecionados
    };

    mostrarMensagem('A disparar e-mails...', false, '#000');

    try {
        const resposta = await fetch('?p=email-enviar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const resultado = await resposta.json();

        if (resposta.ok && resultado.sucesso) {
            mostrarMensagem(`E-mail enviado! Sucesso: ${resultado.totalEnviado} | Falhas: ${resultado.totalFalha}`, false);
            setTimeout(fecharModalEnvio, 2500);
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