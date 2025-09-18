<?php
require_once('session.php');
require_once('dbconnect.php');


$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$email = isset($_GET['email']) ? trim($_GET['email']) : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once('head.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

<section> <!-- Formulario -->

<?php
if(isset($_SESSION['msg_insert']))
{
  echo $_SESSION['msg_insert'];
  unset($_SESSION['msg_insert']);
}
?>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Registo de entrada</h5> <span></span>

      <!-- Floating Labels Form -->
      <form action="registar_action.php" method="POST" enctype="multipart/form-data">

      <div class="row">
        <div class="col">
           <div class="mb-3">
             <div class="form-floating">
           
            <input type="text" name="nome" value="<?= htmlspecialchars($nome ?? '', ENT_QUOTES, 'UTF-8') ?>" id="input_nome" class="form-control" required>

             <label for="input_nome" class="form-label">Nome completo</label>
             </div>
          </div>
        </div>

        <div class="col">
          <div class="mb-3">
            <div class="form-floating">        
              <select name="idade" id="input_idade"  class="form-select" required>
                <option value="">-- Escolha --</option>
                <option>20 – 30 anos</option>
                <option>31 – 40 anos</option>
                <option>41 – 50 anos</option>
                <option>51 – 60 anos</option>
                <option>Mais de 60 anos</option>
              </select>
              <label for="input_idade" class="form-label">Intervalo de idade</label>
            </div>
        </div>
      </div>

        <div class="col">
          <div class="mb-3">
             <div class="form-floating">   
              <input type="text" name="instituicao" class="form-control" required>
              <label class="form-label">Instituição de ensino ou trabalho</label>
             </div>
        </div>
      </div>
      </div>
       

        

        <div class="row">
          <div class="col">
            <div class="mb-3">
                <div class="form-floating">   
                  <input type="text" name="telefone" class="form-control" required>
                  <label class="form-label">Contacto telefónico</label>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="mb-3">
               <div class="form-floating">  
              <input type="email" name="email" value="<?=$email?>" class="form-control" required>
               <label class="form-label">E-mail</label>
            </div>
            </div>
          </div>

          <div class="col">
            <div class="mb-3">
               <div class="form-floating">
              <input type="password" name="password" class="form-control" required>
               <label class="form-label">Password</label>
            </div>
            </div>
          </div>

          <div class="col">
            <div class="mb-3">
               <div class="form-floating">
              <input type="password" name="confirm_password" class="form-control" required>
               <label class="form-label">Confirmar Password</label>
            </div>
            </div>
          </div>

          <div class="col">
            <div class="mb-3">
              <label for="formFile" class="form-label">Comprovativo de Pagamento</label>
              <input class="form-control" type="file" name="comprovativo" id="formFile" required>
            </div>
          </div>

          <div class="col">
  <div class="mb-3">
    <label class="form-label">Categoria profissional</label><br>

    <div class="form-check d-flex align-items-center gap-2">
      <input class="form-check-input" type="radio" name="categoria" id="cat_especialista" value="Médico Especialista" required>
      <label class="form-check-label mb-0" for="cat_especialista">Médico Especialista</label>
      <input type="text" name="especialidade_especialista" id="input_especialista" class="form-control ms-2" placeholder="Especialidade" style="display:none;" disabled>
    </div>

    <div class="form-check d-flex align-items-center gap-2 mt-2">
      <input class="form-check-input" type="radio" name="categoria" id="cat_residente" value="Médico Residente" required>
      <label class="form-check-label mb-0" for="cat_residente">Médico Residente</label>
      <input type="text" name="especialidade_residente" id="input_residente" class="form-control ms-2" placeholder="Especialidade" style="display:none;" disabled>
    </div>

    <div class="form-check d-flex align-items-center gap-2 mt-2">
      <input class="form-check-input" type="radio" name="categoria" value="Médico Generalista" id="cat_generalista" required>
      <label class="form-check-label mb-0" for="cat_generalista">Médico Generalista</label>
    </div>

    <div class="form-check d-flex align-items-center gap-2 mt-2">
      <input class="form-check-input" type="radio" name="categoria" value="Estudante de Medicina" id="cat_estudante" required>
      <label class="form-check-label mb-0" for="cat_estudante">Estudante de Medicina</label>
    </div>

    <div class="form-check d-flex align-items-center gap-2 mt-2">
      <input class="form-check-input" type="radio" name="categoria" value="Enfermeiro/Técnico de Medicina" id="cat_tecnico" required>
      <label class="form-check-label mb-0" for="cat_tecnico">Enfermeiro/Técnico de Medicina</label>
    </div>

  </div>
</div>

        </div>

        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Registar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form><!-- End floating Labels Form -->

    </div>
  </div>
</section>


<section>
  <?php
//  require('entradas_por_introduzir_comprovativo.php');
  ?>
</section>
<section class="section">
  <?php
    require('registos_listar.php');
  ?>
</section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
<?php require_once('footer.php'); ?>
  </footer><!-- End Footer -->




  <script>
          function geek() {
              var doc;
              var result = confirm("Está prestes a apagar a informação! Click em Ok caso deseja continuar...");
              if (result == true) {
                  doc = "OK was pressed.";
              } else {
                  doc = "Cancel was pressed.";
              }
              document.getElementById("g").innerHTML = doc;
          }
      </script>




<script>
$(document).ready(function () {
  $('input[name="categoria"]').change(function () {
    const categoria = $(this).val();

    if (categoria === 'Médico Especialista') {
      $('#input_especialista').show().prop('required', true).prop('disabled', false);
      $('#input_residente').hide().prop('required', false).prop('disabled', true).val('');
    } else if (categoria === 'Médico Residente') {
      $('#input_residente').show().prop('required', true).prop('disabled', false);
      $('#input_especialista').hide().prop('required', false).prop('disabled', true).val('');
    } else {
      $('#input_especialista, #input_residente').hide().prop('required', false).prop('disabled', true).val('');
    }
  });
});
</script>

</body>

</html>


