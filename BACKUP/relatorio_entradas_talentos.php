<?php
require_once('session.php');
require_once('dbconnect.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Processa os dados do formulário
  $data_inicial = $_POST["data_inicial"];
  $data_final = $_POST["data_final"];
  $tipo_agrupamento = $_POST["tipo_agrupamento"]; // Pode ser igreja, província, etc.

  // Constrói a consulta SQL com base nos critérios de filtro
  $sql = "SELECT $tipo_agrupamento,  i.igreja_nome, sum(valor_total) AS total_entradas FROM entradas
  inner join igreja i on i.igreja_id = entradas.$tipo_agrupamento
  inner join ada_provincia p on p.ada_provincia_id = entradas.provincia_fk
 
   WHERE data_entrada BETWEEN '$data_inicial' AND '$data_final' 
    GROUP BY $tipo_agrupamento ORDER BY total_entradas DESC";

  $resultados = mysqli_query($db, "$sql");
   

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


  <h2>Relatório de Entradas</h2>
    <!-- Formulário de Filtro -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row">
      <div class="col">
      <label for="data_inicial">Data Inicial:</label>
        <input type="date" class="form-control" name="data_inicial" required>

      </div>
      <div class="col">
      <label for="data_final">Data Final:</label>
        <input type="date" class="form-control" name="data_final" required>

      </div>
      <div class="col">
      <label for="tipo_agrupamento">Agrupar Por:</label>
        <select  class="form-select" name="tipo_agrupamento" required>
            <option value="igreja_fk">Igreja</option>
            <option value="provincia_fk">Província</option>
            <option value="ada_regiao_id">Região</option>
            <!-- Adicione outras opções de agrupamento conforme necessário -->
        </select>
      </div>
      <br>
    </div>
    <br>
    <div class="modal-footer">
    <button type="reset" class="btn btn-primary" name="cancel">Cancelar</button>
    <button type="submit" class="btn btn-success" name="submit">Gerar Relatório</button>


    </div>
        
       
       
        
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
    <h2>Classificacao Geral por Igrejas:</h2>
    <?php

    if ($resultados->num_rows > 0) {
        // Exibe uma tabela para os resultados
        echo "<table class='table table-sm table-sripe '>";
        echo "<tr><th>#</th><th>Igreja</th><th>Total de Entradas</th></tr>";
$total=$count=0;
        while ($row = $resultados->fetch_assoc()) {
          $count++;
            echo "<tr>";
            echo "<td>" . $count . "º</td>";
            echo "<td>" . $row['igreja_nome'] . "</td>";
            echo "<td>" .number_format($row['total_entradas'],2,",",".")  . "Mt</td>";
            echo "</tr>";
            $total +=$row['total_entradas'];
        }
        echo "</table>";
    } else {
        // Se não houver resultados, exibe uma mensagem indicando isso
        echo "Nenhum resultado encontrado.";
    }

    echo "<h3>Total: ".number_format($total,2,",",".")." Mt</h3>";
    ?>
<?php } ?>



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

</body>

</html>
