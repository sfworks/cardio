<?php
require_once('session.php');
require_once('dbconnect.php');

//get post variables

$crente=$_POST['sele_crente'];
$crente_fk=$_POST['crente_selected'];
$projecto_fk=$_POST['input_projecto'];
$regiao_fk=$_POST['input_regiao'];
$provincia_fk=$_POST['input_provincia'];
$entrada_tipo=$_POST['input_tipo_entrada'];
$entrada_origem=$_POST['input_origem_entrada'];
$valor=$_POST['input_valor'];
$moeda=$_POST['input_moeda'];
$get_data=$_POST['input_data'];

$data_aux = strtotime($get_data);
$data= date('Y-m-d', $data_aux);
$descricao=$_POST['input_descricao'];

//get igreja from selected

$query=$db->query("SELECT igreja_fk FROM `crente` WHERE crente_id =$crente_fk");
while($row = $query->fetch_assoc()){
  $igreja_fk=$row['igreja_fk'];
}

$insert="INSERT INTO `entradas`(`crente_fk`, `igreja_fk`, `provincia_fk`, `tipo_entrada_fk`, `tipo_origem_fk`, `valor_total`, `pruduto_qtd_unidade`,descricao,  `data_entrada`,  `projecto_fk`,  `registou`)
VALUES ('".$crente_fk."','".$igreja_fk."','".$provincia_fk."','".$entrada_tipo."','".$entrada_origem."','".$valor."','".$moeda."','".$descricao."','".$data."','".$projecto_fk."','".$user_id."')";

          if ($db->query($insert)===TRUE)
            {


              $_SESSION['msg_success'] = "O Seu registo foi efectuado com sucesso.";


              header('location: entrada_registar.php');


            }else
              {
                $_SESSION['msg_error'] = "Erro ao tentar efectuar o seu registo. Contacte o administrador do sistema para mais detalhes ".$data.' '.$db->error;
                header('location: entrada_registar.php');
              }

?>
