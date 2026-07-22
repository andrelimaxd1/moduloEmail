<?php
global $primeiroNome, $avatar;

$nomeUsuario = !empty($primeiroNome) ? htmlspecialchars($primeiroNome) : 'Usuário';
$fotoAvatar  = !empty($avatar) ? htmlspecialchars($avatar) : 'assets/img/semavatar.png';
?>

<style>
  .menu-fluido {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    white-space: nowrap; 
    overflow: hidden;
  }

  .logo-fluida {
    height: clamp(24px, 3vw, 38px);
    margin-right: clamp(10px, 1.5vw, 23px);
    margin-left: 5px;
  }

  .avatar-fluido {
    width: clamp(26px, 3vw, 38px);
    height: clamp(26px, 3vw, 38px);
    border-radius: 20px;
    margin-right: 10px;
    margin-left: 10px;
    object-fit: cover;
  }

  /* Nova classe para tratar o alinhamento do título de forma inteligente */
  .titulo-fluido {
    margin-left: 20px;
    padding-top: 0 !important;
    font-size: clamp(13px, 1.5vw, 19px);
    display: inline-block;
    line-height: 1;
    margin-top: -5px; /* Mantém o SEU alinhamento original em telas grandes */
  }

  /* Quando a janela diminui, reduzimos o "puxão" para cima para manter tudo centralizado */
  @media (max-width: 1100px) {
    .titulo-fluido {
      margin-top: -2px;
    }
  }

  /* Em janelas bem pequenas/celulares, tiramos totalmente o puxão */
  @media (max-width: 768px) {
    .titulo-fluido {
      margin-top: 0px; 
    }
  }
</style>

<nav class="navbar navbar-light fixed-top" style="z-index:9999; background: white; padding: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div class="container-fluid" style="padding-left: 0;">
        
        <div class="menu-fluido">
            
            <!-- Lado Esquerdo -->
            <div style="display: flex; align-items: center; height: 100%;">
                
                <img src="assets/img/vocaretax.png" class="logo-fluida" alt="Vocare Tax">
                
                <!-- Limpamos o style e aplicamos a nossa nova classe titulo-fluido -->
                <span class="topoincial1 fontmobile titulo-fluido">
                    Painel Administrativo - <b>Módulo E-mail</b>
                </span>
                
            </div>
            
            <!-- Lado Direito -->
            <div class="topoinicial2" style="display: flex; align-items: center; font-size: clamp(11px, 1.2vw, 16px);">
                
                <span>Você está conectado como <b><?= $nomeUsuario ?></b></span> 
                
                <img src="<?= $fotoAvatar ?>" class="avatar-fluido" alt="Avatar"> 
                
                <span style="color: #ccc; margin: 0 clamp(5px, 0.5vw, 10px);">|</span> 
                
                <a href="#" class="mudarsenha-icon" style="color: #2D5F8B; margin: 0 clamp(5px, 1vw, 10px); font-size: clamp(12px, 1.2vw, 16px);" title="Mudar Senha">
                    <i class="fa-solid fa-lock"></i>
                </a> 
                
                <a href="#" style="text-decoration: none; color: #2D5F8B; display: flex; align-items: center; margin-left: clamp(5px, 1vw, 10px); font-size: clamp(12px, 1.2vw, 16px);" title="Sair">
                    <i class="fa fa-sign-out" aria-hidden="true" style="margin-right: 5px;"></i>
                    <span>Sair</span>
                </a>
                
            </div>
            
        </div>

    </div>
</nav>