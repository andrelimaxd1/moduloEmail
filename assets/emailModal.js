// Variáveis globais
let templateIdSelecionado = null;
let destinatariosSelecionados = [];
let arquivosSelecionados = []; 
let anexosDoTemplate = [];     


function abrirModalEnvio(dados = null) {
    const modal = document.getElementById('modalEnvio');
    const modalMsg = document.getElementById('modalMsg');
    
    modal.style.display = 'block';
    modalMsg.style.display = 'none';

    arquivosSelecionados = [];
    anexosDoTemplate = [];

    if (dados) {
        templateIdSelecionado = dados.templateId;
        document.getElementById('inpAssunto').value = dados.assunto || '';
        document.getElementById('inpCorpo').value = dados.corpo || '';
        
        if (dados.anexos && Array.isArray(dados.anexos)) {
            anexosDoTemplate = dados.anexos;
        }
    } else {
        templateIdSelecionado = null;
        document.getElementById('inpAssunto').value = '';
        document.getElementById('inpCorpo').value = '';
    }

    destinatariosSelecionados = [];
    document.getElementById('inpBuscaContato').value = '';
    document.getElementById('listaSugestoes').innerHTML = '';
    
    atualizarTagsDestinatarios();
    renderizarListaAnexos(); 
}

function fecharModalEnvio() {
    document.getElementById('modalEnvio').style.display = 'none';
    arquivosSelecionados = []; 
    anexosDoTemplate = [];
    renderizarListaAnexos();
}

window.onclick = function(event) {
    const modal = document.getElementById('modalEnvio');
    if (event.target == modal) {
        fecharModalEnvio();
    }
}

async function processarAdicaoDestinatario() {
    const inpBusca = document.getElementById('inpBuscaContato');
    const q = inpBusca.value.trim();
    const listaSugestoes = document.getElementById('listaSugestoes');

    if (q === '') {
        mostrarMensagem("Por favor, digite um e-mail ou nome para adicionar.", true);
        return;
    }

    if (q.includes('@') && q.includes('.')) {
        adicionarDestinatario(q, null);
        return;
    }

    if (q.length < 2) {
        mostrarMensagem("Digite pelo menos 2 letras para buscar contatos.", true);
        return;
    }

    try {
        listaSugestoes.innerHTML = '<li style="padding:5px;">Buscando contato...</li>';
        
        const resposta = await fetch(`?p=email-buscar-contatos&q=${encodeURIComponent(q)}`);
        const contatos = await resposta.json();
        
        listaSugestoes.innerHTML = '';
        
        if (contatos.length === 0) {
            listaSugestoes.innerHTML = '<li style="padding:5px; color:red;">Nenhum contato encontrado.</li>';
            return;
        }

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

function adicionarDestinatario(email, usuarioId = null) {
    const jaExiste = destinatariosSelecionados.find(d => d.email === email);
    
    if (!jaExiste) {
        destinatariosSelecionados.push({ email: email, usuarioId: usuarioId });
        atualizarTagsDestinatarios();
    }
    
    document.getElementById('inpBuscaContato').value = '';
    document.getElementById('listaSugestoes').innerHTML = '';
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

function adicionarAnexos() {
    const input = document.getElementById('inpAnexos');
    const novosArquivos = Array.from(input.files);

    novosArquivos.forEach(novoArquivo => {
        const jaExiste = arquivosSelecionados.some(arq => arq.name === novoArquivo.name && arq.size === novoArquivo.size);
        if (!jaExiste) {
            arquivosSelecionados.push(novoArquivo);
        }
    });

    input.value = '';
    renderizarListaAnexos();
}

function removerAnexo(index) {
    arquivosSelecionados.splice(index, 1);
    renderizarListaAnexos();
}

function removerAnexoTemplate(index) {
    anexosDoTemplate.splice(index, 1);
    renderizarListaAnexos();
}

function renderizarListaAnexos() {
    const container = document.getElementById('listaAnexosContainer');
    container.innerHTML = ''; 

    anexosDoTemplate.forEach((anexo, index) => {

        let nomeAnexo = typeof anexo === 'string' ? anexo : (anexo.nome_arquivo || anexo.nome || 'Anexo do Template');

        const tag = document.createElement('div');
        tag.style.cssText = 'background: #fff3cd; border: 1px solid #ffe69c; padding: 5px 10px; border-radius: 15px; font-size: 13px; display: flex; align-items: center; gap: 8px;';
        
        tag.innerHTML = `
            <i class="fas fa-cloud" style="color: #664d03;" title="Anexo salvo no servidor"></i>
            <span style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-style: italic; color: #664d03;" title="${nomeAnexo}">${nomeAnexo}</span>
            <i class="fas fa-times" style="color: #dc3545; cursor: pointer;" onclick="removerAnexoTemplate(${index})"></i>
        `;
        container.appendChild(tag);
    });

    arquivosSelecionados.forEach((arquivo, index) => {
        const tag = document.createElement('div');
        tag.style.cssText = 'background: #e9ecef; border: 1px solid #ced4da; padding: 5px 10px; border-radius: 15px; font-size: 13px; display: flex; align-items: center; gap: 8px;';
        
        tag.innerHTML = `
            <i class="fas fa-file-upload" style="color: #2d5f8b;" title="Novo arquivo"></i>
            <span style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${arquivo.name}">${arquivo.name}</span>
            <i class="fas fa-times" style="color: #dc3545; cursor: pointer;" onclick="removerAnexo(${index})"></i>
        `;
        container.appendChild(tag);
    });
}

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
        destinatarios: destinatariosSelecionados,
        anexosTemplate: anexosDoTemplate 
    };

    const formData = new FormData();
    formData.append('dados', JSON.stringify(payload));

    arquivosSelecionados.forEach(arquivo => {
        formData.append('anexos[]', arquivo);
    });

    mostrarMensagem('A disparar e-mails...', false, '#111e39');

    const btnEnviar = document.querySelector('button[onclick="enviarEmail()"]');
    btnEnviar.disabled = true;
    btnEnviar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> A enviar...';

    try {
        const resposta = await fetch('?p=email-enviar', {
            method: 'POST',
            body: formData 
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
    } finally {
        if(btnEnviar) {
            btnEnviar.disabled = false;
            btnEnviar.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Iniciar Disparo';
        }
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