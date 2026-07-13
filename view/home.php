<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Módulo de E-mails - Vocare Conecta</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
  <!-- CSS Base do Sistema apontando para a pasta assets -->
  <link rel="stylesheet" type="text/css" href="assets/estilovc.css">
  
  <!-- Bibliotecas extraídas do painel original -->
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

    /* Grid que alinha os botões lado a lado responsivamente */
    .modulos-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 16px;
      justify-items: center;
      margin: 20px auto;
      max-width: 1000px;
    }

    .modulo-item {
      display: flex;
      justify-content: center;
    }
  </style>
</head>

<body class="bodypainel">

  <!-- BARRA SUPERIOR (NAVBAR) - EXATAMENTE IGUAL ÀS OUTRAS TELAS -->
  <nav class="navbar navbar-light fixed-top" style="z-index:9999; background: #fff !important; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-bottom: 3px solid var(--color-barra) !important;">
    <div class="container-fluid">
      
      <!-- Lado Esquerdo: Logo e Título com fonte corrigida -->
      <div style="display: flex; align-items: center; height: 100%;">
        <img src="assets/img/vocaretax.png" style="margin-right:15px; height: 38px;" alt="Vocare Tax">
        <span class="topoincial1 fontmobile" style="margin-left: 20px; padding-top: 0 !important; margin: 0; font-size: 20px; display: inline-block; line-height: 1;">
            Painel Administrativo - <b>Módulo E-mail</b>
        </span>
      </div>

      <!-- Lado Direito: Estrutura nativa idêntica às outras Views -->
      <div class="topoinicial2">
        Você está conectado como <b>Usuário</b> 
        <img src="assets/img/semavatar.png" style="border-radius: 20px 20px; width:38px;height:38px;margin-right:10px; margin-left:10px;" alt="Avatar"> 
        | 
        <a href="../alterasenhagestao.php" class="mudarsenha-icon" style="color: #111e39;">
          <i class="fa-solid fa-lock fa-lg"></i>
        </a> 
        <a href="../logout.php" style="text-decoration: none; color: #111e39; margin-left: 10px;">
          <i class="fa fa-sign-out" aria-hidden="true"></i>Sair
        </a>
      </div>
      
    </div>
  </nav>

  <!-- CORPO DO PAINEL -->
  <center>
    <div class="container-geral" style="padding-top: 7em;">
      
      <!-- Caixa branca arredondada (incialnovo) -->
      <div class="incialnovo" style="width: 800px; max-width: 95vw; margin-top: 1%; padding: 40px 20px;">
        
        <!-- Título interno da página grande e destacado -->
        <h1 style="font-family: 'Ubuntu', sans-serif; font-size: 28px; color: #111e39; font-weight: 500; margin-bottom: 10px;">
          <i class="fas fa-envelope-open-text"></i> Módulo de E-mails
        </h1>
        <p style="font-size: 16px; color: #646464; margin-bottom: 35px;">
          Selecione uma das opções abaixo para gerenciar ou realizar disparos
        </p>

        <!-- Grid de Botões usando as classes originais e idênticas ao painel principal -->
        <div class="modulos-grid" style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">

          <!-- Botão 1: Templates -->
          <div class="modulo-item">
            <a href="?p=template-list" style="text-decoration: none;">
              <button type="button" class="btnovoinicial">
                <i class="fa-solid fa-file-invoice fa-2x"></i><br>
                <div style="margin-top:6px;">TEMPLATES DE<br>E-MAIL</div>
              </button>
            </a>
          </div>

          <!-- Botão 2: Disparo (Usando a cor verde/sucesso) -->
          <div class="modulo-item">
            <a href="?p=email" style="text-decoration: none;">
              <button type="button" class="btnovoinicial" style="background-color: #32aa66;">
                <i class="fa-solid fa-paper-plane fa-2x"></i><br>
                <div style="margin-top:6px;">DISPARAR<br>E-MAILS</div>
              </button>
            </a>
          </div>

        </div> <!-- /modulos-grid -->
        
      </div> <!-- /incialnovo -->
      
    </div> <!-- /container-geral -->
  </center>

  <!-- Script do Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>