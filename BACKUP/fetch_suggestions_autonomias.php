<?php
require_once('dbconnect.php');

// Verifique se o parâmetro 'provincia_id' foi recebido via POST
if(isset($_POST['provincia_id'])) {
    // Recupere o ID da província do parâmetro POST
    $provincia_id = $_POST['provincia_id'];

    // Prepare a consulta SQL para selecionar as autonomias da província fornecida
    $sql = "SELECT a.autonomia_nome, a.autonomia_id, r.ada_regiao_nome as regiao, r.ada_regiao_id as regiao_id 
            FROM autonomia a
            INNER JOIN ada_provincia p ON p.ada_provincia_id = a.provincia_fk
            INNER JOIN ada_regiao r ON r.ada_regiao_id = p.ada_regiao_fk
            WHERE p.ada_provincia_id = $provincia_id
            ORDER BY a.autonomia_nome";

    // Execute a consulta SQL
    $query = mysqli_query($db, $sql);

    // Inicialize um array para armazenar as sugestões de autonomia
   // $suggestions = array();
   $options='<option value="1">-- Não Aplicável--</option>';
    // Verifique se há resultados da consulta
    if($query) {
        // Itere sobre os resultados e adicione-os ao array de sugestões
        while($row = mysqli_fetch_assoc($query)) {
          $options .= '<option value="' . $row['autonomia_id'] . '">' . $row['autonomia_nome'] .'</option>';
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
    echo '<option value="">Erro: Selecione a Província</option>';
}

// Feche a conexão com o banco de dados
$db->close();
?>
