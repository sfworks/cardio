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

<section> <!-- Formulario -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Registo de Centros | Provincias</h5> <span style="color:red"><?php echo $msg_error;?></span><span style="color:green"><?php echo $msg_success;?></span>

      <!-- Floating Labels Form -->
      <form class="row g-3" method="POST" action="insert_db_novo_centro.php">

  

        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" class="form-control" name="centro_nome" id="centro_nome" >
            <label for="centro_nome">Nome do Centro</label>
          </div>
          </div>



          
          <div class="col-md-3">
            <div class="input-group form-floating">
                  <input type="text" data-bs-toggle='tooltip' data-bs-placement='top' title="Dica: Utilize o % como separador de duas ou mias palavras Ex. Regiao%Matola" class="form-control" id="procurar_regiao" name="regiao" >
                  <button class="btn btn-outline-secondary" type="reset" data-bs-toggle='tooltip' data-bs-placement='top' title='Click para apagar texto deste campo' >
                                 <i class="bi bi-eraser-fill"></i> 
                                 </button>
                                 <label for="procurar_regiao">Região</label>
             </div>
            </div>
            


             <div class="col-md-3 d-none">
                <div class="form-floating">
                  <input type="text" id="regiao_selecionada" name="regiao_selecionada" class="form-control">
                  <label for="regiao_selecionada">Código da Região</label>
                </div>
            </div>



              <div class="col-md-3">
                  <div class="form-floating">
                      <select class="form-select" id="cidade" name="cidade_sel">
                          <option value=""></option>
                       
                      </select>
                      <label for="cidade">cidade</label>
                  </div>
              </div>





            <div class="col-md-3">
                  <div class="form-floating">
                      <select class="form-select" id="procurar_responsavel" name="procurar_responsavel">
                          <option value="1">-- Não Aplicável --</option>
                      
                      </select>
                      <label for="procurar_responsavel">Reponsável Local</label>
                  </div>
              </div>
            
             <div class="col-md-4 d-none">
                <div class="form-floating">
                  <input type="text" id="responsavel_selecionado" name="responsavel_selecionado" class="form-control">
                  <label for="responsavel_selecionado">Código da Província</label>
                </div>
            </div>



          

          




        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Gravar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form>

    </div>
  </div>
</section>


    <div class="pagetitle">
      <h1>Últimos registos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Ínicio</a></li>
          <li class="breadcrumb-item">Listar</li>
          <li class="breadcrumb-item active">Entradas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Centros | Provincias Registadas</h5>
              <p>Encontre abaixo, a lista dos últimos registos</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                  
                    <th scope="col">Centro/Província</th>
                    <th scope="col">Regiao</th>
                    <th scope="col">Pastor Provincial</th>
                   
                    <th scope="col"></th>
                    <th scope="col"></th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                      try
                        {

                          if($user_perfil=="Administrator")
                          {
                          $sql = "SELECT p.ada_provincia_id, p.ada_provincia_nome, case when r.ada_regiao_nome = 'Não Identificado' then '' else r.ada_regiao_nome end as ada_regiao_nome,  case when c.crente_nome='Não Identificado' then '' else c.crente_nome end as pastor_provincial FROM ada_provincia p
                          inner join ada_regiao r on r.ada_regiao_id =p.ada_regiao_fk
                          INNER join crente c on c.crente_id = p.pastor_fk
                          ORDER by p.ada_provincia_id desc;";
                        }else {
                          // code...
                          $sql = "SELECT p.ada_provincia_id, p.ada_provincia_nome, case when r.ada_regiao_nome = 'Não Identificado' then '' else r.ada_regiao_nome end as ada_regiao_nome,  case when c.crente_nome='Não Identificado' then '' else c.crente_nome end as pastor_provincial FROM ada_provincia p
                          inner join ada_regiao r on r.ada_regiao_id =p.ada_regiao_fk
                          INNER join crente c on c.crente_id = p.pastor_fk
                                  where r.ada_regiao_id =$user_regiao_id
                                ";
                        }
                       
                            $query = mysqli_query($db, "$sql");
                       
                            $cont=0;
                            while ($row = mysqli_fetch_array($query))
                              {$cont++;



                     ?>
                                <tr>
                                    <td><?php echo $row['ada_provincia_id'];?></td>
                                   
                                    <td><?php echo $row['ada_provincia_nome'];?></td>
                                    <td><?php echo $row['ada_regiao_nome'];?></td>
                                    <td><?php echo $row['pastor_provincial'];?></td>
                                  
                                    <td>
                                      <a href="centro_editar.php?id=<?php echo $row['ada_provincia_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="centro_apagar.php?id=<?php echo $row['ada_provincia_id'];?>" onclick='return confirm_alert(this);' data-toggle="tooltip" data-placement="left" title="Apagar"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
                                    </td>

                                </tr>
                    <?php
                              }
                          }
                                  catch(Exception $e)
                                  {
                                  echo "Erro:\n".$e->getMessage();
                                  }

                    ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
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
   $("#procurar_regiao").autocomplete({
     source: "fetch_suggestions_regiao.php",
    
     select: function(event, ui) {
//       ada_regiao_id
// ada_regiao_nome
// moz_provincia_fk
       $("#procurar_regiao").val(ui.item.ada_regiao_nome); // Update input value with label
        $("#regiao_selecionada").val(ui.item.ada_regiao_id); // Update input value with label
        fetchCidade($("#regiao_selecionada").val()); // Buscar os Lotes com base no item selecionado
     
       return false;
     },
     minLength: 2
   })
   .data("ui-autocomplete")._renderItem = function(ul, item) {
     return $("<li>")
       .append("<div>" + item.moz_provincia_fk +": "+ item.ada_regiao_nome + "</div>")
       .appendTo(ul);
   };
 });








    //####################
     function fetchCidade(ada_regiao_id) {
          
             $.ajax({
                 url: 'fetch_suggestions_cidade.php',
                 type: 'post',
                 data: {
                   ada_regiao_id: ada_regiao_id
                 },
                 success: function(response) {
                     $('#cidade').html(response);
                 }
             });
         }


//          //get crente
//  $(document).ready(function() {
//    $("#provincia_selecionada").autocomplete({
//      source: "fetch_suggestions_crentes.php",
    
//      select: function(event, ui) {
 
//        $("#crente_nome").val(ui.item.crente_nome); // Update input value with label
//        $("#crente_id").val(ui.item.crente_id); // Update input value with label
//         $("#cargo_fk").val(ui.item.cargo_fk); // Update input value with label
//         $("#ministerio_fk").val(ui.item.ministerio_fk); // Update input value with label
       
     
//        return false;
//      },
//      minLength: 2
//    })
//    .data("ui-autocomplete")._renderItem = function(ul, item) {
//      return $("<li>")
//        .append("<div>" + item.cargo_fk +": "+ item.crente_nome + "</div>")
//        .appendTo(ul);
//    };
//  });


</script>

</body>

</html>


<?php $_SESSION['msg_success']=$_SESSION['msg_error']=""; ?>
