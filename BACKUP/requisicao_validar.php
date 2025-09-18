<?php
require_once('session.php');
require_once('dbconnect.php');


if(isset($_GET['id']) && ($_GET['id'])>0)
{
  $get_requisicao_id=$_GET['id'];
}else{
  header('location: requisicao_pendente.php');
}


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


try {
  //code...
  $sql = "SELECT `requisicao_titulo`, `descricao`, `documento`, `valor`, `moeda`, `projecto_fk`, `requisitou`, `estado`, `data_criacao`, `data_actualizacao` FROM `requisicao` 
          WHERE requisicao_id=$get_requisicao_id";
        $query = mysqli_query($db, "$sql");
        $result = $db->query($sql);

  while ($row = mysqli_fetch_array($query))
      {
        $titulo=$row['requisicao_titulo'];
        $valor=$row['valor'];
        $moeda=$row['moeda'];
        $projecto_fk=$row['projecto_fk'];
        $requisitou=$row['requisitou'];
        $estado=$row['estado'];
        $data_criacao=$row['data_criacao'];
        $data_actualizacao=$row['data_actualizacao'];
        $descricao=$row['descricao'];
      }
}catch(Exception $e)
{
echo "Erro:\n".$e->getMessage();
}

//Insert item do

if(isset($_POST['submit']))
{

  $get_descricao=$_POST['input_item_descricao'];
  $get_qtd=$_POST['input_qtd'];
  $get_valor=$_POST['input_valor'];
  $get_obs=$_POST['input_obs'];


  $insert="INSERT INTO `requisicao_itens`(`requisicao_fk`, `descricao`, `qtd`, `valor`, `obs`) 
            VALUES ('".$get_requisicao_id."','".$get_descricao."','".$get_qtd."','".$get_valor."','".$get_obs."')";

          if ($db->query($insert)===TRUE)
            {
              $msg_success = "O Seu registo foi efectuado com sucesso. Queira acrescentar os devidos itens desta requisição ou clicar no botão submeter para fechar a criação";
              //header('location: requisicao_add_itens.php');
            }else
              {
                $msg_error = "Erro ao tentar efectuar o seu registo. Contacte o administrador do sistema para mais detalhes ".$db->error;
               // header('location: requisicao_registar.php');
              }
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


  <section>
  
  </section>


<section> <!-- Formulario -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Requisição de fundos - Aprovação</h5> <span style="color:red"><?php echo $msg_error;?></span><span style="color:green"><?php echo $msg_success;?></span>
<span>Dados da requisição</span>
      <hr>

      <div class="row">
      <div class="col-md">Título: <?php echo $titulo;?></div>
      <div class="col-md">Valor Global: <?php echo $valor.' '.$moeda;?></div>
      <div class="col-md">Projecto: <?php echo $projecto_fk;?></div>
      <div class="col-md">Estado: <?php echo $estado;?></div>
      <div class="col-md-12"><br>Detalhes: <br> <?php echo $descricao;?></div>
    </div>
<hr>
      <!-- Floating Labels Form -->
      <form class="row g-3" method="POST" action="">
<!--
          <div class=" col-md-5">
            <div class="form-floating">
            <input type="text" class="form-control" id="floatingName" name="input_item_descricao" placeholder="Descrição"> 
            <label for="floatinProjecto">Item Descrição</label>
            </div>
          </div>

          <div class="col-md-1">
            <div class="form-floating">
            <input type="text" class="form-control" name="input_qtd" min="0" id="id_titulo" placeholder="Qtd">
            <label for="forTitulo">Qtd</label>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-floating">
            <input type="text" class="form-control" name="input_valor" min="0" id="id_titulo" placeholder="Valor">
            <label for="forTitulo">Valor</label>
            </div>
          </div>

-->

          <div class="col-md-8">
            <div class="form-floating">
           <!-- <input type="text" class="form-control" name="input_obs" min="0" id="id_titulo" placeholder="Obs"> -->
            <textarea name="" class="form-control" name="input_obs" id="id_obs" cols="30" rows="3"></textarea>
            <label for="forTitulo">Obs</label>
            </div>
          </div>

          
          <div class="col-md-4">
            <div class="form-floating">
           <!-- <input type="text" class="form-control" name="input_obs" min="0" id="id_titulo" placeholder="Obs"> -->
            <select name="sele_estado" class="form-control" id="id_sele_estado">
            <option value="">Aprovar? * </option>
              <option value="Aprovado - Aguarda Segunda aprovação">Aprovar - Submeter para segunda aprovação</option>
              <option value="Aprovado - Aguarda Terceira aprovação">Aprovar - Submeter para  terceira aprovação</option>
              <option value="Aprovado - Aguarda Pagamento">Aprovar - Submeter para  Pagamento</option>
            </select>
            <label for="forTitulo">Aprovação</label>
            </div>
          </div>

        
        

        <div class="text">
          <button type="submit" name="submit" class="btn btn-primary">Registar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form><!-- End floating Labels Form -->

    </div>
  </div>
</section>




                  <?php

                      try
                        {
                          $query = $db->query("SELECT `item_id`, `requisicao_fk`, `descricao`, `qtd`, `valor`, `obs` FROM `requisicao_itens` WHERE requisicao_fk =$get_requisicao_id");
                        //    $query = mysqli_query($db, "$sql");
                          //  $result = $db->query($sql);

                          $rowCount = $query->num_rows;

                          //Display cities list
                          if($rowCount > 0){
                            $linha=0;
                            ?>
                            <div class="pagetitle">
                              <h1>Itens desta requisição </h1>

                            <!--  <nav>
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="index.php">Ínicio</a></li>
                                  <li class="breadcrumb-item">reqisocoes</li>
                                  <li class="breadcrumb-item active">Criação</li>
                                </ol>
                              </nav> -->
                            </div><!-- End Page Title -->

                            <section class="section">
                              <div class="row">
                                <div class="col-lg-12">

                                  <div class="card">
                                    <div class="card-body">
                                   <!--   <h5 class="card-title">Introduzir</h5> -->
                                  

                                      <!-- Table with stripped rows -->
                                      <form class="" action="" enctype="multipart/form-data" method="POST">


                                      <table class="table table-sm datatable">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Qtd</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Obs</th>
                                            <th scope="col"></th>

                                          </tr>
                                        </thead>
                                        <tbody>
                            <?php

                            while ($row = mysqli_fetch_array($query))
                              {
                                
                                $linha++;

                     ?>
                                <tr>
                                    <td><h3><?php echo $linha;?></h3></td>
                                    <td><?php echo $row['descricao'];?></td>
                                    <td><?php echo $row['qtd'];?></td>
                                   <td><?php echo $row['valor'];?></td>
                                    <td><?php echo $row['obs'];?></td>
                                     <td>
                                      <a href="requisicao_item_editar.php?id=<?php echo $row['item_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="apagar_item_requisicao.php?id=<?php echo $row['item_id'];?>"  id="apagar"  class="remove" data-toggle="tooltip" data-placement="left" title="Apagar"  onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
                                    </td>

                                </tr>
                    <?php
                              }
                              ?>
                              </tbody>
                            </table>

          
                            <!-- End Table with stripped rows -->
                            </form>

                          </div>
                        </div>

                      </div>
                    </div>
                  </section>

                  <?php
                          }}
                                  catch(Exception $e)
                                  {
                                  echo "Erro:\n".$e->getMessage();
                                  }

                    ?>



    

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

</body>

</html>

<?php $_SESSION['msg_success']=$_SESSION['msg_error']=""; ?>
