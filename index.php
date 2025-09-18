<?php
require_once('session.php');
require_once('dbconnect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once('head.php'); ?>
<style>
body {
      background: linear-gradient(to right, #e0eafc, #cfdef3);
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
      padding: 80px 20px;
      text-align: center;
    }
    .hero h1 {
      font-size: 2.8rem;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }
    .info-box {
      background-color: #ffffffdd;
      border-radius: 10px;
      padding: 20px;
      margin: 30px auto;
      max-width: 700px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn-custom {
      min-width: 150px;
      font-weight: 600;
    }
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <?php require_once('top_menu.php'); ?>
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <?php require_once('dashboard.php'); ?>
  </aside><!-- End Sidebar-->

  <main id="main" class="main">

     <div class="hero">
   <div class="col-md-6 mb-4">
        <div class="event-info">
          <h3 class="text-primary">Primeira Reunião Científica de Saúde Cardiovascular</h3>
          <p>
            Venha fazer parte deste importante evento que reunirá profissionais de saúde nacionais e internacionais em prol do avanço da Cardiologia em Moçambique.
          </p>
          <ul class="list-unstyled">
            <li><strong>📅 Datas:</strong> 07 e 08 de Novembro de 2025</li>
            <li><strong>📍 Local:</strong> INDY VILLAGE MAPUTO</li>
            <li><strong>⏰ Horário:</strong> 08h00 – 17h00</li>
            <li><strong>📞 Contacto:</strong> (+258) 82 8751280 | 87 0112230</li>
            <li><strong>📧 Email:</strong> secretariado@reuniaocardiologia.co.mz</li>
          </ul>
        </div>
      </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
      <a href="login.php" class="btn btn-primary btn-lg btn-custom">Entrar</a>
      <a href="criar_conta.php" class="btn btn-outline-primary btn-lg btn-custom">Criar Conta</a>
    </div>
  </div>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
<?php require_once('footer.php'); ?>
  </footer><!-- End Footer -->


</body>

</html>
