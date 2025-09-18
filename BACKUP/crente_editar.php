<?php
require_once('session.php');
require_once('dbconnect.php');

if(isset($_GET['id']))
{
  $crente_id=$_GET['id'];
  $query=$db->query("SELECT `crente_id`, `crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`, igreja.igreja_nome FROM `crente` 
          inner join igreja on igreja.igreja_id = crente.igreja_fk WHERE crente_id =$crente_id");
  if($query->num_rows>0)
  {
    while($row = $query->fetch_assoc())
    {
      $crente_nome=$row['crente_nome'];
      $crente_sexo=$row['sexo_fk'];
      $email=$row['email'];
      $telefone=$row['telefone'];
      $cargo=$row['cargo_fk'];
      $ministerio=$row['ministerio_fk'];
      $igreja_fk=$row['igreja_fk'];
      $igreja_nome=$row['igreja_nome'];
    }
  }else{
    header("location: crente_registar.php?");
  }
}else
{
  header("location: crente_registar.php?");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once('head.html'); ?>
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
      <h5 class="card-title">Registo de Crentes</h5>

      <!-- Floating Labels Form -->
      <form class="row g-3" method="POST" action="crente_update_db.php">

        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" class="form-control" name="input_crente" value="<?php echo $crente_nome;?>"  id="floatingName" placeholder="Nome do crente">
            <label for="floatinCrente">Nome do Crente</label>
          </div>
          </div>


          <div class=" col-md-4">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="sele_sexo"  name="sele_sexo" required class="form-control" id="sele_sexo" placeholder="Selecione o Projecto">
                <option value="<?php echo $crente_sexo ;?>"><?php echo $crente_sexo ;?></option>
                <option value="Feminino">Feminino</option>
                <option value="Masculino">Masculino</option>

             </select>
              <label for="floatinProjecto">Genero/Sexo</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
              <input type="mail" class="form-control" name="inoutEmail" value="<?php echo $email ;?>" id="floatingEmail" placeholder="E-mail">
              <label for="floatinEmail">E-mail</label>
            </div>
            </div>


          <div class="col-md-4">
            <div class="form-floating">
              <input type="text" class="form-control" name="inputTelefone" value="<?php echo $telefone ;?>" id="floatingEmail" placeholder="E-mail">
              <label for="floatinTelefoneCrente">Telefone</label>
            </div>
            </div>






          <div class="col-md-4">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="sel_cargo"  name="sel_cargo" required class="form-control" id="sel_cargo" placeholder="Selecione Cargo">
                <option value="<?php echo $cargo ;?>"><?php echo $cargo ;?></option>
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
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="sel_ministerio"  name="sel_ministerio" required class="form-control" id="sel_ministerio" placeholder="Selecione Ministerio">
                <option value="<?php echo $email ;?>"><?php echo $ministerio ;?></option>
                 <?php


                 $query = $db->query("SSELECT `ministerio` FROM `ministerio` order by ministerio asc");

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
              <label for="floatingName">Ministério</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
              <select id="sel_igreja"  name="sel_igreja" required class="form-control" id="sel_igreja" placeholder="Selecione a Igreja">
                <option value="<?php echo $igreja_fk ;?>"><?php echo $igreja_nome ;?></option>
                 <?php

                 if($user_perfil=="Administrator")
                 {
                 $query = $db->query("SELECT `igreja_id`, `igreja_nome`, `ada_provincia_fk`, `ada_autonomia_fk`, `pastor_local`, p.ada_provincia_nome, r.ada_regiao_nome FROM `igreja` i
inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
Inner JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
ORDER by i.igreja_nome ASC");
               }else {
                 // code...
                 $query = $db->query("SELECT `igreja_id`, `igreja_nome`, `ada_provincia_fk`, `ada_autonomia_fk`, `pastor_local`, p.ada_provincia_nome, r.ada_regiao_nome FROM `igreja` i
inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
Inner JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
where ada_provincia_fk in ('$user_provincia_id') 
ORDER by i.igreja_nome ASC  ");

               }$rowCount = $query->num_rows;
                 if($rowCount > 0){
                     while($row = $query->fetch_assoc()){
                       echo '<option value="'.$row['igreja_id'].'" title="'.$row['igreja_nome'].'">'.$row['igreja_nome'].'  </option>';
                     }
                   }else{
                     echo '<option value="">Não existe nenhuma Igreja registada no sistema</option>';
                   }

               ?>
             </select>
              <label for="floatingName">Igreja</label>
            </div>
          </div>




        <div class="text-center">
          <button type="submit" class="btn btn-primary">Editar / Gravar</button>
          <button type="reset" class="btn btn-secondary">Limpar</button>
        </div>
      </form><!-- End floating Labels Form -->

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
              <h5 class="card-title">Crentes Registados</h5>
              <p>Encontre abaixo, o último registo</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Igreja</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Contactos</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Ministerio</th>
                    <th scope="col">Regiao</th>
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
                          $sql = "SELECT `crente_id`, `crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome,p.ada_provincia_nome FROM `crente` c
                                  INNER join igreja i on i.igreja_id = c.igreja_fk
                                  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
                                  INNER JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
                                  where crente_id=$crente_id
                                  ORDER BY crente_id DESC";
                        }else {
                          // code...
                          $sql = "SELECT `crente_id`, `crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome,p.ada_provincia_nome FROM `crente` c
                                  INNER join igreja i on i.igreja_id = c.igreja_fk
                                  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
                                  INNER JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
                                  where p.ada_provincia_id =$user_provincia_id and  crente_id=$crente_id
                                  ORDER BY crente_id DESC";
                        }
                        /*  $sql = "SELECT `crente_id`, `crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome,p.ada_provincia_nome FROM `crente` c
                                INNER join igreja i on i.igreja_id = c.igreja_fk
                                  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
                                  INNER JOIN ada_regiao r on r.ada_regiao_id = p.ada_regiao_fk
                                  ORDER BY crente_id DESC";*/
                            $query = mysqli_query($db, "$sql");
                            $result = $db->query($sql);

                            while ($row = mysqli_fetch_array($query))
                              {



                     ?>
                                <tr>
                                    <td><h3><?php echo $row['crente_id'];?></h3></td>
                                    <td><?php echo $row['crente_nome'];?></td>
                                    <td><?php echo $row['igreja_nome'];?></td>
                                    <td><?php echo $row['sexo_fk'];?></td>
                                    <td><?php echo $row['email'].'<br>'.$row['telefone'];?></td>

                                    <td><?php echo $row['cargo_fk'];?></td>
                                    <td><?php echo $row['ministerio_fk'];?></td>
                                    <td><?php echo $row['igreja_nome'];?></td>
                                    <td>
                                      <a href="editar.php?id=<?php echo $row['crente_id'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="apagar_registo.php?id=<?php echo $row['crente_id'];?>" onclick='return confirm_alert(this);' data-toggle="tooltip" data-placement="left" title="Apagar"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
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

</body>

</html>
