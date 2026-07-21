<?php
global $primeiroNome, $avatar;

$nomeUsuario = !empty($primeiroNome) ? htmlspecialchars($primeiroNome) : 'Usuário';
$fotoAvatar  = !empty($avatar) ? htmlspecialchars($avatar) : 'assets/img/semavatar.png';
?>

<nav class="navbar navbar-light fixed-top" style="z-index:9999; background: white; padding: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div class="container-fluid" style="padding-left: 0;">
        
        <div style="display: flex; align-items: center; height: 100%;">
            <img src="assets/img/vocaretax.png" style="margin-left: 5px; margin-right: 23px; height: 38px;" alt="Vocare Tax">
            <span class="topoincial1 fontmobile" style="margin-left: 20px; margin-top: -5px; padding-top: 0 !important; font-size: 19px; display: inline-block; line-height: 1;">
                Painel Administrativo - <b>Módulo E-mail</b>
            </span>
        </div>
        
        <div class="topoinicial2">
            Você está conectado como <b><?= $nomeUsuario ?></b> 
            <img src="<?= $fotoAvatar ?>" style="border-radius: 20px 20px; width:38px; height:38px; margin-right:10px; margin-left:10px;" alt="Avatar"> 
            | 
            <a href="#" class="mudarsenha-icon" style="color: #2D5F8B; margin-left: 10px; margin-right: 10px;" title="Mudar Senha">
                <i class="fa-solid fa-lock fa-lg"></i>
            </a> 
            <a href="#" style="text-decoration: none; color: #2D5F8B;" title="Sair">
                <i class="fa fa-sign-out" aria-hidden="true" style="margin-left:10px;"></i>Sair
            </a>
        </div>

    </div>
</nav>