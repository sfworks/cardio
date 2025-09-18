  <?php

require_once('session.php');
require_once('dbconnect.php');

  // Get the user input from the auto-suggest input field

  //$_GET['term']="Malaria";
  $term = utf8_decode($_GET['term']); // User's input
  
if($user_perfil == 'Administrator')
 {  
  $sql = "SELECT `igreja_id`, `igreja_nome`, ada_provincia.ada_provincia_nome, `ada_provincia_fk`, autonomia.autonomia_nome, `ada_autonomia_fk`, `pastor_local` FROM `igreja` 
  right JOIN ada_provincia on ada_provincia.ada_provincia_id =  igreja.ada_provincia_fk
  right join autonomia on autonomia.autonomia_id = igreja.ada_autonomia_fk
  WHERE 

   igreja_nome LIKE '%".$term."%' or ada_provincia_nome LIKE '%".$term."%'
   order by ada_provincia_nome, igreja_nome";
  
 }else {  
  $sql = "SELECT `igreja_id`, `igreja_nome`, ada_provincia.ada_provincia_nome, `ada_provincia_fk`, autonomia.autonomia_nome, `ada_autonomia_fk`, `pastor_local` FROM `igreja` 
  right JOIN ada_provincia on ada_provincia.ada_provincia_id =  igreja.ada_provincia_fk
  right join autonomia on autonomia.autonomia_id = igreja.ada_autonomia_fk
  WHERE 
  ada_provincia_fk =$user_provincia_id and
   (igreja_nome LIKE '%".$term."%' or ada_provincia_nome LIKE '%".$term."%')
   order by ada_provincia_nome, igreja_nome";
 }
 $query = mysqli_query($db, "$sql");
//  $result = $db->query($sql);
 $suggestions = array();
$rowCount = $query->num_rows;
if($rowCount > 0){

  
while($row = $query->fetch_assoc())
 {
      // Add your desired column as a suggestion

      $suggestion = array(
        "igreja" => ($row['igreja_nome']),    // Displayed suggestion text
        "igreja_id" => $row['igreja_id'],    // ID code
        "ada_provincia_nome" => ($row['ada_provincia_nome']),    // Displayed suggestion text
        "ada_provincia_id" => $row['ada_provincia_fk'] ,   // ID code
        "igreja_id" => $row['igreja_id'],    // ID code
        "autonomia_nome" => ($row['autonomia_nome']),    // Displayed suggestion text
        "ada_autonomia_fk" => $row['ada_autonomia_fk'] ,   // ID code
       
    );

    $suggestions[] = $suggestion;

  }

}
  

  // Return suggestions as JSON
  echo json_encode($suggestions);
  $db->close();
  ?>
  
