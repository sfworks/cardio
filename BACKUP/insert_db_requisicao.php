<?php
require_once('session.php');
require_once('dbconnect.php');

//get post variables

$titulo=$_POST['input_titulo'];
$projecto_fk=$_POST['input_projecto'];
$valor=$_POST['input_valor'];
$moeda=$_POST['sele_moeda'];
//$get_data=$_POST['input_data'];

//$data_aux = strtotime($get_data);
//$data= date('Y-m-d', $data_aux);
$descricao=$_POST['input_descricao'];

//get 



$insert="INSERT INTO `requisicao`( `requisicao_titulo`,descricao, `valor`, `moeda`, `projecto_fk`, `requisitou`, obs) 
VALUES ('".$titulo."','".$descricao."','".$valor."','".$moeda."','".$projecto_fk."','".$user_id."','')";

          if ($db->query($insert)===TRUE)
            {
              $_SESSION['requisicao_id'] = $db->insert_id;
              $_SESSION['msg_success'] = "O Seu registo foi efectuado com sucesso. queira acrescentar os devidos itens desta requisição";
            //  header('location: requisicao_add_itens.php');
               header('location: requisicao_registar.php');
            }else
              {
                $_SESSION['msg_error'] = "Erro ao tentar efectuar o seu registo. Contacte o administrador do sistema para mais detalhes ".$db->error;
                header('location: requisicao_registar.php');
              }

?>
