<?php
require_once('session.php');
require_once('dbconnect.php');

//get post variables

$igreja_nome=$_POST['igreja_nome'];
$provincia=$_POST['provincia'];
$provincia_selecionada=$_POST['provincia_selecionada'];
$autonomia_sel=$_POST['autonomia_sel'];
$procurar_responsavel=$_POST['procurar_responsavel'];
$responsavel_selecionado=$_POST['procurar_responsavel'];


$data= date('Y-m-d', $data_aux);


//die('Igreja: '.$igreja_nome.', Provincia: '.$provincia_selecionada.', Autonomia: '.$autonomia_sel.', Responsave: '.$responsavel_selecionado); 

// $query=$db->query("SELECT igreja_fk FROM `crente` WHERE crente_id =$crente_fk");
// while($row = $query->fetch_assoc()){
//   $igreja_fk=$row['igreja_fk'];
// }


$insert="INSERT INTO `igreja`(`igreja_nome`, `ada_provincia_fk`, `ada_autonomia_fk`, `pastor_local`)
VALUES ('".$igreja_nome."','".$provincia_selecionada."','".$autonomia_sel."','".$responsavel_selecionado."')";

          if ($db->query($insert)===TRUE)
            {


              $_SESSION['msg_success'] = "O Seu registo foi efectuado com sucesso.";


              header('location: igreja_registar.php');


            }else
              {
                $_SESSION['msg_error'] = "Erro ao tentar efectuar o seu registo. Contacte o administrador do sistema para mais detalhes ".$data.' '.$db->error;
                header('location: igreja_registar.php');
              }

?>
