<?php
require_once('session.php');
require_once('dbconnect.php');

//get post variables

$centro_nome=$_POST['centro_nome'];
$cidade=$_POST['cidade_sel'];
$regiao_selecionada=$_POST['regiao_selecionada'];

$procurar_responsavel=$_POST['procurar_responsavel'];
$responsavel_selecionado=$_POST['procurar_responsavel'];


$data= date('Y-m-d');


//die('Igreja: '.$igreja_nome.', Provincia: '.$provincia_selecionada.', Autonomia: '.$autonomia_sel.', Responsave: '.$responsavel_selecionado); 

// $query=$db->query("SELECT igreja_fk FROM `crente` WHERE crente_id =$crente_fk");
// while($row = $query->fetch_assoc()){
//   $igreja_fk=$row['igreja_fk'];
// }
//die($centro_nome.' | '.$regiao_selecionada.' | '. $responsavel_selecionado);
try {
  //code...

$insert="INSERT INTO `ada_provincia`(`ada_provincia_nome`, `ada_regiao_fk`, `pastor_fk`)
VALUES ('".$centro_nome."','".$regiao_selecionada."','".$responsavel_selecionado."')";

          if ($db->query($insert)===TRUE)
            {


              $_SESSION['msg_success'] = "O Seu registo foi efectuado com sucesso.";


              header('location: centro_registar.php');


            }else
              {
                $_SESSION['msg_error'] = "Erro ao tentar efectuar o seu registo. Contacte o administrador do sistema para mais detalhes ".$data.' '.$db->error;
                header('location: centro_registar.php');
              }

            } catch (\Throwable $th) {
              throw $th;
            }

?>
