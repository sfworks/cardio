  <?php

//require_once('session.php');
require_once('dbconnect.php');

  //$_GET['term']="Malaria";
  $term = $_GET['term']; // User's input

  $sql = "SELECT `crente_id`, `crente_nome`,  `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome, p.ada_provincia_nome FROM `crente`  c
  inner join igreja i on i.igreja_id = c.igreja_fk
  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
  WHERE 
 ada_provincia_id = $term or
 crente_nome like '%".$term."%'
   order by cargo_fk,crente_nome";
 $query = mysqli_query($db, "$sql");
//  $result = $db->query($sql);
 $suggestions = array();
$rowCount = $query->num_rows;
if($rowCount > 0){

  
while($row = $query->fetch_assoc())
 {
      $suggestion = array(      
        "crente_nome" => $row['crente_nome'],    
        "crente_id" => $row['crente_id'],  
        "cargo_fk" => $row['cargo_fk'],    
        "ministerio_fk" => $row['ministerio_fk'] ,  
     
       
    );

    $suggestions[] = $suggestion;

  }

}
  

  // Return suggestions as JSON
  echo json_encode($suggestions);
  $db->close();
  ?>
  
