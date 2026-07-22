<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Módulo de E-mails - Vocare Conecta</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
  <link rel="stylesheet" type="text/css" href="assets/estilovc.css">
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

  <?php require __DIR__ . '/../menu.php'; ?>

  
  <div style="display: flex; justify-content: center; align-items: flex-start; width: 100%; padding-top: 100px; padding-bottom: 50px; box-sizing: border-box;">
    
    <div class="container-geral" style="width: 100%; display: flex; justify-content: center; padding: 0 15px; box-sizing: border-box;">
        
        <div class="incialnovo" style="width: 100%; max-width: 700px; margin: 0 auto; padding: 30px; box-sizing: border-box; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center;">
        
        
        <h1 style="font-family: 'Ubuntu', sans-serif; font-size: 28px; color: #111e39; font-weight: 500; margin-bottom: 10px;">
          <i class="fas fa-envelope-open-text"></i> Módulo de E-mails
        </h1>
        <p style="font-size: 16px; color: #646464; margin-bottom: 35px;">
          Selecione uma das opções abaixo para gerenciar ou realizar disparos
        </p>

        
        <div class="modulos-grid" style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 10px;">

        
          <div class="modulo-item">
            <a href="?p=template-list" style="text-decoration: none;">
              <button type="button" class="btnovoinicial">
                <i class="fa-solid fa-file-invoice fa-2x"></i><br>
                <div style="margin-top:6px;">TEMPLATES DE<br>E-MAIL</div>
              </button>
            </a>
          </div>

          
          <div class="modulo-item">
            <a href="?p=email" style="text-decoration: none;">
              <button type="button" class="btnovoinicial" style="background-color: #32aa66;">
                <i class="fa-solid fa-paper-plane fa-2x"></i><br>
                <div style="margin-top:6px;">DISPARAR<br>E-MAILS</div>
              </button>
            </a>
          </div>

        </div> 
        
      </div> 
      
    </div> 
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>