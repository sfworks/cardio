<?php
session_start();
ob_start();
if ($_SERVER['SERVER_PORT'] != '443') {
  header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}

$msg_erro = $_SESSION['msg_erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <?php require_once('head.php'); ?>
  <style>
    body {
      background: linear-gradient(to right, #e0eafc, #cfdef3);
    }
    .event-info {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .tabs-card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<main>
  <div class="container py-5">
    <div class="row align-items-center">
      <!-- Coluna 1 - Info do Evento -->
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

      <!-- Coluna 2 - Registo/Login -->
      <div class="col-md-6">
        <div class="tabs-card">
          <!-- Nav Tabs -->
          <ul class="nav nav-tabs mb-3" id="tabContent" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                      type="button" role="tab">Login</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
                      type="button" role="tab">Criar Conta</button>
            </li>
          </ul>

          <!-- Tab Contents -->
          <div class="tab-content" id="tabContent">
            <!-- Login Form -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">
              <form method="POST" action="action_login.php" class="needs-validation" novalidate>
                <div class="mb-3">
                  <label for="username" class="form-label">Utilizador</label>
                  <input type="text" class="form-control" name="username" id="username" required>
                  <div class="invalid-feedback">Por favor introduza o seu utilizador.</div>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Senha</label>
                  <input type="password" class="form-control" name="password" id="password" required>
                  <div class="invalid-feedback">Por favor introduza a sua senha.</div>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
                <div class="mt-2 text-danger text-center">
                  <?php echo $msg_erro; ?>
                </div>
              </form>
            </div>

            <!-- Registro Form -->
            <div class="tab-pane fade" id="register" role="tabpanel">
              <form method="POST" action="insert_registar_utilizador.php" class="needs-validation" novalidate onsubmit="return validarSenhas()">
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome Completo</label>
        <input type="text" class="form-control" name="nome" required>
      </div>
    </div>

    <div class="col">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>                    
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="input_password" class="form-label">Senha</label>
        <input type="password" class="form-control" name="password" id="input_password" required>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="input_confirmar_password" class="form-label">Confirmar</label>
        <input type="password" class="form-control" name="confirmar_password" id="input_confirmar_password" required>
      </div>
    </div>
  </div>

  <div class="d-grid">
    <button type="submit" class="btn btn-success">Criar Conta</button>
  </div>
</form>



            </div>
          </div>

        </div>
       
      </div>
    </div>
  </div>
</main>
 <div class="text-center mt-3">
          <small><?php
          if(isset($_GET['msg']))
          {
           echo $_GET['msg'];
           unset($_GET['msg']);
          }
          ?></small>
        </div>
<center><?php require('footer.php');?></center>


<script>
function validarSenhas() {
  const senha = document.getElementById('input_password').value;
  const confirmar = document.getElementById('input_confirmar_password').value;

  if (senha !== confirmar) {
    alert('As senhas não coincidem!');
    return false; // Impede o envio
  }
  return true;
}
</script>
<!-- Scripts -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
</body>
</html>

<?php session_destroy(); ?>
