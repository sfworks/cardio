  <?php

//require_once('session.php');
require_once('dbconnect.php');

  //$_GET['term']="Malaria";
  $term = utf8_decode($_GET['term']); // User's input

  $sql = "SELECT `ada_regiao_id`, `ada_regiao_nome`, `moz_provincia_fk` FROM `ada_regiao` 
  WHERE 
  ada_regiao_nome LIKE '%".$term."%' or  moz_provincia_fk LIKE '%".$term."%'
   order by moz_provincia_fk, ada_regiao_nome";
 $query = mysqli_query($db, "$sql");

 $suggestions = array();
$rowCount = $query->num_rows;
if($rowCount > 0){

  
while($row = $query->fetch_assoc())
 {
      $suggestion = array(      
        "ada_regiao_id" => $row['ada_regiao_id'],    
        "ada_regiao_nome" => $row['ada_regiao_nome'],  
        "moz_provincia_fk" => $row['moz_provincia_fk'],    
      
     
       
    );

    $suggestions[] = $suggestion;

  }

}
  

  // Return suggestions as JSON
  echo json_encode($suggestions);
  $db->close();
  ?>
  
