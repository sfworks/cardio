<?php
require_once('session.php');
require_once('dbconnect.php');


$msg_error="";

if(isset($_SESSION['msg_success']))
{
  $msg_success=$_SESSION['msg_success'];
}else{
  $msg_success="";
}

if(isset($_SESSION['msg_error']))
{
  $msg_error=$_SESSION['msg_error'];
}else{
  $msg_error="";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once('head.php'); ?>

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

  <div class="pagetitle">
      <h1>Registo de Crentes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Ínicio</a></li>
          <li class="breadcrumb-item">Registar</li>
          <li class="breadcrumb-item active">Crente</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

<section> <!-- Formulario -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Registo de Crentes</h5> <span style="color:red"><?php echo $msg_error;?></span><span style="color:green"><?php echo $msg_success;?></span>

      <!-- Floating Labels Form -->
      <form class="row g-3" method="POST" action="insert_db_novo_crente.php">

      <div class="col-md-4">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="sel_cargo"  name="sel_cargo" required class="form-control" id="sel_cargo" placeholder="">
                <option value=""></option>
                 <?php


                 $query = $db->query("SELECT `cargo_nome` FROM `crente_cargo` order by cargo_nome ASC");

               $rowCount = $query->num_rows;
                 if($rowCount > 0){
                     while($row = $query->fetch_assoc()){
                       echo '<option value="'.$row['cargo_nome'].'">'.$row['cargo_nome'].'  </option>';
                     }
                   }else{
                     echo '<option value="">Não existe nenhuma cargo registado no sistema</option>';
                   }

               ?>
             </select>
              <label for="floatingName">Cargo / Tipo de crente</label>
            </div>
          </div>

        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" class="form-control" name="input_nome" id="floatingName" >
            <label for="floatinCrente">Nome do Crente</label>
          </div>
          </div>


          <div class=" col-md-4">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="sele_sexo"  name="sele_sexo" required class="form-control" id="sele_sexo" >
                <option value=""></option>
                <option value="Feminino">Feminino</option>
                <option value="Masculino">Masculino</option>

             </select>
              <label for="floatinProjecto">Genero/Sexo</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
              <input type="mail" class="form-control" name="input_email" id="input_email" >
              <label for="input_email">E-mail</label>
            </div>
            </div>


          <div class="col-md-4">
            <div class="form-floating">
              <input type="text" class="form-control" name="input_telefone" id="Telefone" >
              <label for="Telefone">Telefone</label>
            </div>
            </div>






        

          <div class="col-md-4">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="sel_ministerio"  name="sel_ministerio" required class="form-control" id="sel_ministerio" placeholder="">
                <option value=""></option>
                 <?php


                 $query = $db->query("SELECT `ministerio` FROM `ministerio` order by ministerio asc");

               $rowCount = $query->num_rows;
                 if($rowCount > 0){
                     while($row = $query->fetch_assoc()){
                       echo '<option value="'.$row['ministerio'].'">'.$row['ministerio'].'  </option>';
                     }
                   }else{
                     echo '<option value="">Não existe nenhuma ministerio registado no sistema</option>';
                   }

               ?>
             </select>
              <label for="sel_ministerio">Ministério</label>
            </div>
          </div>
          <br>

          <div class="col-md-4">
          

            <div class=" input-group form-floating">
                  <input type="text" data-bs-toggle='tooltip' data-bs-placement='top' required title="Dica: Utilize o % como separador de duas ou mias palavras Ex. Ruptura%joelho" class="form-control" id="procurar_igreja" name="igreja" >
                  <button class="btn btn-outline-secondary" type="reset" data-bs-toggle='tooltip' data-bs-placement='top' title='Click para apagar texto deste campo' >
                                 <i class="bi bi-eraser-fill"></i> 
                                 </button>
                                 <label for="procurar_igreja">Igreja</label>
                   
             </div>
             <small><i>Selecione "Não Identificado" caso nao conheca a igreja</i></small>             
            

             <div class="col-md-4 d-none">
                <div class="form-floating">
                  <input type="text" id="igreja_id" name="id_igreja" class="form-control">
                  <label for="igreja_id">Codigo da Igreja</label>
                </div>
            </div>


          </div>

          




        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Gravar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form><!-- End floating Labels Form -->

    </div>
  </div>
</section>


    

    <section class="section">
      <?php require('crentes_listar.php');?>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
<?php require_once('footer.php'); ?>
  </footer><!-- End Footer -->

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
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/script.js"></script>

<!-- Inclua o jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Inclua o jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">




  <script>
          function confirme_alert() {
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
$(document).ready(function() {
  $("#procurar_igreja").autocomplete({
    source: "fetch_suggestions_igreja.php",
    
    select: function(event, ui) {
      // Set the selected value in the form input
      $("#procurar_igreja").val(ui.item.igreja); // Update input value with label
       $("#igreja_id").val(ui.item.igreja_id); // Update input value with label
      // $("#selected-id").val(ui.item.ada_provincia_nome);    // Store ID code in another hidden input
      return false;
    },
    minLength: 2
  })
  .data("ui-autocomplete")._renderItem = function(ul, item) {
    return $("<li>")
      .append("<div>" +item.ada_provincia_nome+": "+ item.igreja + "</div>")
      .appendTo(ul);
  };
});
</script>

</body>

</html>


<?php $_SESSION['msg_success']=$_SESSION['msg_error']=""; ?>
