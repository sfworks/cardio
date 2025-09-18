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

$comprov_aux="";
if(isset($_POST['upload']) && is_array($_POST['input_comprovativo']))
{


  foreach ($_POST['input_comprovativo'] as $comprovativoi)
  {
    $comprov_aux.=$comprovativoi.",";

   }

$entradas_id_update= substr($comprov_aux, 0, -1);

           //upload file where entrada_id in($comprov_aux) remover ultimoa carater
           // verifica se foi enviado um comprovativo
           if(isset($_FILES['comprovativo']['name']) && $_FILES["comprovativo"]["error"] == 0)
           {

           	/*echo "Você enviou o comprovativo: <strong>" . $_FILES['comprovativo']['name'] . "</strong><br />";
           	echo "Este comprovativo é do tipo: <strong>" . $_FILES['comprovativo']['type'] . "</strong><br />";
           	echo "Temporáriamente foi salvo em: <strong>" . $_FILES['comprovativo']['tmp_name'] . "</strong><br />";
           	echo "Seu tamanho é: <strong>" . $_FILES['comprovativo']['size'] . "</strong> Bytes<br /><br />";
           	*/
           	$comprovativo_tmp = $_FILES['comprovativo']['tmp_name'];
           	$nome = $_FILES['comprovativo']['name'];


           	// Pega a extensao
           	$extensao = strrchr($nome, '.');

           	// Converte a extensao para mimusculo
           	$extensao = strtolower($extensao);

           	// Somente imagens, .jpg;.jpeg;.gif;.png
           	// Aqui eu enfilero as extesões permitidas e separo por ';'
           	// Isso server apenas para eu poder pesquisar dentro desta String
           	if(strstr('.jpg;.jpeg;.gif;.png;.pdf;.tiff;.heic', $extensao))
           	{
           		// Cria um nome único para esta imagem
           		// Evita que duplique as imagens no servidor.
           		//$novoNome = md5(microtime()) . '.' . $extensao;
           		$novoNome = 'comprovativo_talentos'.md5(microtime()).''.$extensao;

           		// Concatena a pasta com o nome
           		$destino = 'comprovativo/'.$novoNome;

           		// tenta mover o comprovativo para o destino
           		if( @move_uploaded_file( $comprovativo_tmp, $destino  ))
           		{
           			$update ="UPDATE entradas SET comprovativo='".$novoNome."' WHERE entrada_id in ($entradas_id_update)";
           			if ($db->query($update)===TRUE)
           				{
           					//header("LOCATION:cirurgia_registar.php");
           				}else
           			echo "Erro ao actualizar a comprovativo do paciente.<br />".$db->error;
           		}
           	else
             {die("não foi possivel importar a comprovativo");}
           }else
             {	die("Você poderá enviar apenas comprovativos \"*.jpg;*.jpeg;*.gif;*.png\"<br />");}
           }else {
             die("NENHUM UPLOAD FEITO".$_POST['comprovativo']);
           }






           //end
}else {
  $comprov_aux="";

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once('head.php'); ?>
<script>
  @media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</script>

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
      <h5 class="card-title">Requisição de fundos</h5> <span style="color:red"><?php echo $msg_error;?></span><span style="color:green"><?php echo $msg_success;?></span>

      <!-- Floating Labels Form -->
      <form class="row g-3" method="POST" action="insert_db_requisicao.php">

          <div class=" col-md-6">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="atrib_projecto"  name="input_projecto" required class="form-control" id="floatingProjecto" placeholder="Selecione o Projecto">
                <option value="">Selecione o Projecto: *</option>
                 <?php


                 $query = $db->query("SELECT `projecto_id`, `projecto_nome`, `ministerio_fk`, `responsavel_crente_fk` FROM `projecto` order by projecto_nome asc");
               $rowCount = $query->num_rows;
                 if($rowCount > 0){
                     while($row = $query->fetch_assoc()){
                       echo '<option value="'.$row['projecto_id'].'">'.$row['projecto_nome'].'  </option>';
                     }
                   }else{
                     echo '<option value="">Não existe nenhum Projecto registado no sistema</option>';
                   }

               ?>
             </select>
              <label for="floatinProjecto">Projecto</label>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating">
            <input type="text" class="form-control" name="input_titulo" min="0" id="id_titulo" placeholder="Títuto">
            <label for="forTitulo">Título / Objecto de compra</label>
            </div>
          </div>

         <div class="col-md-12">
            <div class="form-floating">
              <label for="floatingValor">Descrição</label>
            <textarea class="form-control" name="input_descricao" rows="4" cols="50" id="id_descricao" placeholder="Descricao"> </textarea>

            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
            <input type="number" class="form-control" required name="input_valor" min="0" id="id_titulo" placeholder="Valor">
            <label for="floatingValor">Valor Global</label>
            </div>
          </div>


          <div class="col-md-2">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="atrib_moeda"  name="sele_moeda" required class="form-control" id="id_sele_moeda" placeholder="Selecione a moeda">
                <option value="">Moeda: *</option>
                <option value="MZN">MZN</option>
                <option value="ZAR">ZAR</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>

             </select>
              <label for="floatingName">Moeda</label>
            </div>
          </div>




        <div class="col-md-6">
          <div class="col-md-12">
            <div class="form-floating">
              <input type="date" class="form-control" disabled name="input_data" id="floatingData" placeholder="Data de entrada">
              <label for="floatingData">Data</label>
            </div>
          </div>
        </div>


        <div class="text">
          <button type="submit" class="btn btn-primary">Registar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form><!-- End floating Labels Form -->

    </div>
  </div>
</section>




                  <?php

                      try
                        {
                          $query = $db->query("SELECT `requisicao_id`, `requisicao_titulo`, `descricao`, `documento`, `valor`, `projecto_fk`, `requisitou`, estado, `data_criacao`, `data_actualizacao` FROM `requisicao`
                          WHERE requisitou = $user_id and estado like 'Em Criação'
                          order by requisicao_id desc");
                        //    $query = mysqli_query($db, "$sql");
                          //  $result = $db->query($sql);

                          $rowCount = $query->num_rows;

                          //Display cities list
                          if($rowCount > 0){

                            ?>
                            <div class="pagetitle">
                              <h1>Requisições por validar</h1>

                            <!--  <nav>
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="index.php">Ínicio</a></li>
                                  <li class="breadcrumb-item">requisicoes</li>
                                  <li class="breadcrumb-item active">Criação</li>
                                </ol>
                              </nav>
                            </div>--><!-- End Page Title -->
                            <button onclick="window.print()">Print this page</button>
                            <section class="section">
                              <div class="row">
                                <div class="col-lg-12">

                                  <div class="card">
                                    <div class="card-body">
                                      <h5 class="card-title">Introduzir</h5>
                                      <p>Itens da requisicao</p>

                                      <!-- Table with stripped rows -->
                                      <form class="" action="" enctype="multipart/form-data" method="POST">


                                      <table class="table table-sm datatable">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Título</th>

                                            <th scope="col">Valor</th>
                                        <th scope="col">Projecto</th>
                                            <th scope="col">Data</th>

                                            <th scope="col">Ação</th>

                                          </tr>
                                        </thead>
                                        <tbody>
                            <?php

                            while ($row = mysqli_fetch_array($query))
                              {
                                if($row['estado']=="Em Criação")
                                {$btn="btn-danger";}
                                  else
                                 {$btn="btn-success";}


                     ?>
                                <tr>
                                    <td><h3><?php echo $row['requisicao_id'];?></h3></td>
                                    <td><?php echo $row['requisicao_titulo'];?></td>
                                    <td><?php echo $row['valor'];?></td>

                                        <td><?php echo $row['projecto_fk'];?></td>
                                    <td><?php echo $row['data_criacao'];?></td>

                                <!--    <td><input type="checkbox" id="id_comprovativo"  name="input_comprovativo[]" value="<?php // echo $row['entrada_id'];?>"></td> -->
                                    <td>
                                      <a href="requisicao_editar.php?id=<?php echo $row['requisicao_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="requisicao_apagar.php?id=<?php echo $row['requisicao_id'];?>"  id="apagar"  class="remove" data-toggle="tooltip" data-placement="left" title="Apagar"  onclick="if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
                                    </td>

                                </tr>
                    <?php
                              }
                              ?>
                              </tbody>
                            </table>

            <!--  <div class="row">


                            <div class="col-md-6">
                                <div class="col-md-12">
                                <div class="form-floating">
                                  <input class="form-control" type="file" name="comprovativo" required id="formFile" placeholder="Comprovativo de deposito">
                                  <label for="dorDescricao">Comprovativo</label>
                              </div>
                              </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="col-md-12">
                                  <div class="form-floating">
                              <div class="text-center">
                                <button type="submit" name="upload" class="btn btn-primary">Introduzir Comprovativo</button>
                                <button type="reset" class="btn btn-secondary">Cancelar</button>
                              </div>
                            </div>
                            </div>  </div>

              </div>  -->
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

      <script>
        ClassicEditor
            .create( document.querySelector( '#id_descricao' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>


<script>
  function PrintElem(elem: HTMLElement)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write(elem.innerHTML);

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
  	setTimeout(() => {
        // Without the timeout, the window seems to close immediately.
    	mywindow.close();    	
    }, 250);
}
</script>
</body>

</html>

<?php $_SESSION['msg_success']=$_SESSION['msg_error']=""; ?>
