<?php
require_once('dbconnect.php');

// Verifique se o parâmetro 'provincia_id' foi recebido via POST
if(isset($_POST['ada_regiao_id'])) {
    // Recupere o ID da província do parâmetro POST
    $ada_regiao_id = $_POST['ada_regiao_id'];

    // Prepare a consulta SQL para selecionar as autonomias da província fornecida
    $sql = "SELECT `moz_provincia` FROM `moz_provincia`   
    inner join ada_regiao r on r.moz_provincia_fk = moz_provincia.moz_provincia
                WHERE ada_regiao_id = $ada_regiao_id
            ORDER BY moz_provincia";

    // Execute a consulta SQL
    $query = mysqli_query($db, $sql);

    // Inicialize um array para armazenar as sugestões de autonomia
   // $suggestions = array();
  
    // Verifique se há resultados da consulta
    if($query) {
        // Itere sobre os resultados e adicione-os ao array de sugestões
        while($row = mysqli_fetch_assoc($query)) {
          $options .= '<option value="' . $row['moz_provincia'] . '">' . $row['moz_provincia'] .'</option>';
        }

        // Retorna as opções como resposta
        echo $options;
    } else {
        // Se não houver resultados, exiba uma mensagem de erro
        echo '<option value="1">Nenhuma autonomia encontrada</option>';
    }

    

    // Retorne as sugestões como JSON
   // echo json_encode($suggestions);
} else {
    // Se o parâmetro 'provincia_id' não foi recebido, retorne um array vazio
    echo '<option value="">Erro: Selecione a Cidade</option>';
}

// Feche a conexão com o banco de dados
$db->close();
?>
