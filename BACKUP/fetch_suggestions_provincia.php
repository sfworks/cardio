  <?php

//require_once('session.php');
require_once('dbconnect.php');

  //$_GET['term']="Malaria";
  $term = utf8_decode($_GET['term']); // User's input

  $sql = "SELECT  ada_provincia_nome, `ada_provincia_id`, r.ada_regiao_nome as regiao, r.ada_regiao_id as regiao_id FROM `ada_provincia` 
  inner join ada_regiao r on r.ada_regiao_id =ada_provincia.ada_regiao_fk

  WHERE 
 ada_provincia_nome LIKE '%".$term."%' or  ada_regiao_nome LIKE '%".$term."%'
   order by regiao, ada_provincia_nome";
 $query = mysqli_query($db, "$sql");

 $suggestions = array();
$rowCount = $query->num_rows;
if($rowCount > 0){

  
while($row = $query->fetch_assoc())
 {
      $suggestion = array(      
        "ada_provincia_nome" => $row['ada_provincia_nome'],    
        "ada_provincia_id" => $row['ada_provincia_id'],  
        "regiao" => $row['regiao'],    
        "regiao_id" => $row['regiao_id'] ,  
     
       
    );

    $suggestions[] = $suggestion;

  }

}
  

  // Return suggestions as JSON
  echo json_encode($suggestions);
  $db->close();
  ?>
  
