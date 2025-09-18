<?php
require_once('session.php');
require_once('dbconnect.php');
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
      <h5 class="card-title">Registo de entrada</h5>

      <!-- Floating Labels Form -->
      <form class="row g-3" method="POST" action="insert_db_nova_entrada.php">

          <div class=" col-md-12">
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






          <div class="col-md-4">
            <div class="form-floating">
            <!--  <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> -->
              <select id="atrib_tecnico"  name="input_regiao" required class="form-control" id="floatingRegiao" placeholder="Selecione a regiao">
                <option value="">Selecione a região: *</option>
                 <?php

                 if($user_perfil=="Administrator")
                 {
                 $query = $db->query("SELECT `ada_regiao_id`, `ada_regiao_nome`, `moz_provincia_fk` FROM `ada_regiao`");
               }else {
                 // code...
                 $query = $db->query("SELECT `ada_regiao_id`, `ada_regiao_nome`, `moz_provincia_fk` FROM `ada_regiao` where ada_regiao.ada_regiao_id in (select ada_regiao.ada_regiao_id FROM `utilizador` INNER join ada_provincia on ada_provincia.ada_provincia_id = utilizador.provincia_fk INNER join ada_regiao on ada_regiao.ada_regiao_id =ada_provincia.ada_regiao_fk where utilizador.provincia_fk ='$user_provincia_id')");

               }$rowCount = $query->num_rows;
                 if($rowCount > 0){
                     while($row = $query->fetch_assoc()){
                       echo '<option value="'.$row['ada_regiao_id'].'">'.$row['ada_regiao_nome'].'  </option>';
                     }
                   }else{
                     echo '<option value="">Não existe nenhuma regiao registada no sistema</option>';
                   }

               ?>
             </select>
              <label for="floatingName">Região</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
              <select id="atrib_tecnico"  name="input_provincia" required class="form-control" id="floatingProvincia" placeholder="Selecione a Provincia">
                <option value="">Selecione a provincia: *</option>
                 <?php

                 if($user_perfil=="Administrator")
                 {
                 $query = $db->query("SELECT `ada_provincia_id`, `ada_provincia_nome`, `ada_regiao_fk` FROM `ada_provincia`");
               }else {
                 // code...
                 $query = $db->query("SELECT `ada_provincia_id`, `ada_provincia_nome`, `ada_regiao_fk` FROM `ada_provincia` where ada_provincia.ada_provincia_id in ('$user_provincia_id')");

               }$rowCount = $query->num_rows;
                 if($rowCount > 0){
                     while($row = $query->fetch_assoc()){
                       echo '<option value="'.$row['ada_provincia_id'].'">'.$row['ada_provincia_nome'].'  </option>';
                     }
                   }else{
                     echo '<option value="">Não existe nenhuma regiao registada no sistema</option>';
                   }

               ?>
             </select>
              <label for="floatingName">Província</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
              <label for="floatingName">Crente</label>
            </div>
          </div>


        <div class="col-md-3">
          <div class="form-floating">
            <!--<input type="email" class="form-control" id="floatingEmail" placeholder="Your Email">-->
            <select class="form-control" name="input_tipo_entrada">
              <option value="Dinheiro" disabled>Dinheiro</option>
            </select>
            <label for="floatinTipo">Tipo de entrada</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
          <!--  <input type="password" class="form-control" id="floatingPassword" placeholder="Password"> -->
          <select class="form-control" name="input_origem_entrada">
            <option value="Talento" disabled>Talentos</option>
          </select>
            <label for="floatingorigem">Origem</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
          <input type="number" class="form-control" min="0" id="floatingValor" placeholder="Valor">

            <label for="floatingValor">Valor</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
          <select class="form-control" name="input_moeda">
            <option value="MT">MZN</option>
            <option value="ZAR">ZAR</option>
            <option value="USD">USD</option>
            <option value="EUR">MZN</option>
          </select>

            <label for="floatingValor">Valor</label>
          </div>
        </div>
      <!--  <div class="col-12">
          <div class="form-floating">
            <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
            <label for="floatingTextarea">Address</label>
          </div>
        </div>-->
        <div class="col-md-6">
          <div class="col-md-12">
            <div class="form-floating">
              <input type="date" class="form-control" id="floatingData" placeholder="Data de entrada">
              <label for="floatingData">Data</label>
            </div>
          </div>
        </div>
      <div class="col-md-6">
          <div class="col-md-12">
          <div class="form-floating">
            <input class="form-control" type="file" id="formFile" placeholder="Comprovativo de deposito">
              <label for="floatingComprovativo">Comprovativo</label>
        </div>
        </div>
        </div>
      <!--  <div class="col-md-2">
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingZip" placeholder="Zip">
            <label for="floatingZip">Zip</label>
          </div>
        </div>-->
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form><!-- End floating Labels Form -->

    </div>
  </div>
</section>


    <div class="pagetitle">
      <h1>Últimos registos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Ínicio</a></li>
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
              <h5 class="card-title">Entradas</h5>
              <p>Encontre abaixo, a lista dos últimos registos</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Igreja</th>
                    <th scope="col">Tipo de entrada</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data</th>
                    <th scope="col">Projecto</th>
                    <th scope="col">Estado</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                      try
                        {
                          $sql = "SELECT entrada_id, crente_fk, crente.crente_nome, entradas.igreja_fk, igreja.igreja_nome, autonomia_fk, autonomia.autonomia_nome, entradas.provincia_fk, ada_provincia.ada_provincia_nome, tipo_entrada_fk, tipo_origem_fk, valor_total, produto_fk, produto_qtd, pruduto_qtd_unidade, descricao, data_entrada, dt_actualizacao, projecto_fk, projecto.projecto_nome, estado_fk, comprovativo, registou, alterou, data_actualizacao, metas_fk
                           FROM entradas
                          INNER join crente on crente.crente_id = entradas.crente_fk
                          INNER join igreja on igreja.igreja_id = entradas.igreja_fk
                          INNER JOIN autonomia on autonomia.autonomia_id = entradas.autonomia_fk
                          INNER JOIN ada_provincia on ada_provincia.ada_provincia_id = entradas.provincia_fk
                          inner join projecto on projecto.projecto_id = entradas.projecto_fk
                          order by entrada_id desc";
                            $query = mysqli_query($db, "$sql");
                            $result = $db->query($sql);

                            while ($row = mysqli_fetch_array($query))
                              {
                                if($row['estado_bk']=="Aguarda Comprovativo")
                                {$btn="btn-danger";}
                                  else
                                 {$btn="btn-success";}


                     ?>
                                <tr>
                                    <td><h3><?php echo $row['entrada_id'];?></h3></td>
                                    <td><?php echo $row['crente_nome'];?></td>
                                    <td><?php echo $row['igreja_nome'];?></td>
                                    <td><?php echo $row['tipo_entrada_fk'];?></td>
                                    <td><?php echo $row['tipo_origem_fk'];?></td>
                                    <td><?php echo number_format($row['valor_total'],2)." Mt";?></td>
                                    <td><?php echo $row['descricao'];?></td>
                                    <td><?php echo $row['data_entrada'];?></td>
                                    <td><?php echo $row['projecto_nome'];?></td>
                                    <td><span class="btn  btn-block <?php echo $btn;?>"><?php echo $row['estado_bk'];?></span></td>
                                    <td>
                                      <a href="editar.php/<?php echo $row['comprovativo'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-eye" style="color:yellow"></i> </a></td>

                                    <td>
                                      <a href="editar.php?id=<?php echo $row['comprovativo'];?>" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fas fa-edit" style="color:blue"></i> </a></td>
                                      </td>
                                    <td>
                                      <a href="apagar_registo.php?id=<?php echo $row['entrada_id'];?>" onclick='return confirm_alert(this);' data-toggle="tooltip" data-placement="left" title="Apagar"><i class="fas fa-trash-alt" style="color:red"></i>  </a>
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
