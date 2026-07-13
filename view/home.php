<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Módulo de E-mails - Vocare Conecta</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSS Base do Sistema -->
  <link rel="stylesheet" type="text/css" href="estilovc.css">
  
  <!-- Bibliotecas extraídas do painel original -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Estilos internos extraídos do painel -->
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

  <!-- BARRA SUPERIOR (NAVBAR) ESTATICA -->
  <nav class="navbar navbar-light fixed-top" style="z-index:9999; background: white; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div class="container-fluid">
      
      <div style="display: flex; align-items: center;">
        <!-- Substitua pelo caminho correto da logo no seu servidor local -->
        <img src="assets/img/vocaretax.png" style="margin-right:15px; height: 38px;" alt="Vocare Tax">
        <font class="topoincial1 fontmobile" style="margin-left:20px; font-size: 16px;">Painel Administrativo - <b>E-mail</b></font>
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

  <!-- CORPO DO PAINEL -->
  <center>
    <div class="container-geral" style="padding-top: 6em;">
      
      <!-- Caixa branca arredondada -->
      <div class="incialnovo" style="width: 800px; margin-top: 1%;">
        
        <font class="topoincial1" style="font-size: 22px;">Gestão de <b>E-mails</b></font><br><br>

        <!-- Grid de Botões usando as classes originais -->
        <div class="modulos-grid" style="display: flex; justify-content: center; gap: 20px;">

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