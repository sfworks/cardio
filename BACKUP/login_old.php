<?php
session_start();
 ob_start();
if($_SERVER['SERVER_PORT'] != '443')
{
		header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); exit();
}

  if(isset($_SESSION['msg_erro']))
  {
    $msg_erro=$_SESSION['msg_erro'];
  }else {
    $msg_erro="";
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once('head.php');

  ?>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Sitema de Gestao</h5>
                    <p class="text-center small">Introduza o seu nome de utilizador e senha</p>
                  </div>

                  <form class="row g-3 needs-validation" method="POST" action="action_login.php" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Utilizador</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Por favor introduza o seu utilizador.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Senha</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Por favor introduza a sua senha!</div>
                    </div>

             
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <span style="color:red"><?php echo $msg_erro;?></span>
                      <p class="small mb-0">Não tem uma conta? <a href="pages-register.html">Criar uma</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
               
                Designed by <a href="https://www.zindoga.com/">JZ</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
<?php // destroy the session
session_destroy(); ?>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
