  <?php

//require_once('session.php');
require_once('dbconnect.php');


  //$provincia_id = $_POST['provincia_id']; // User's input
  //$crente_proc = $_POST['crente_proc']; // User's input

  if(isset($_POST['crente_proc']))
  {
    $crente_proc= $_POST['crente_proc'];
  }
  else {
    $crente_proc= $_GET['crente_proc'];
  }

  if(isset($_POST['provincia_id']))
  {
    $provincia_id= $_POST['provincia_id'];
  }
  else {
    $provincia_id= $_GET['provincia_id'];
  }

  $sql = "SELECT `crente_id`, `crente_nome`,  `cargo_fk`, `ministerio_fk`, `igreja_fk`, i.igreja_nome, p.ada_provincia_nome FROM `crente`  c
  inner join igreja i on i.igreja_id = c.igreja_fk
  inner join ada_provincia p on p.ada_provincia_id = i.ada_provincia_fk
  WHERE 
 ada_provincia_id = $provincia_id and
 (crente_nome like '%".$crente_proc."%' or
 cargo_fk like '%".$crente_proc."%')

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
        "igreja" => $row['igreja_nome'] ,  
     
       
    );

    $suggestions[] = $suggestion;

  }

}
  

  // Return suggestions as JSON
  echo json_encode($suggestions);
  $db->close();
  ?>
  
