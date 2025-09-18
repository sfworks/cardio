<?php
require_once('session.php');
require_once('dbconnect.php');

//get post variables

$nome=$_POST['input_nome'];
$sexo=$_POST['sele_sexo'];
$email=$_POST['input_email'];
$telefone=$_POST['input_telefone'];
$cargo=$_POST['sel_cargo'];
$ministerio=$_POST['sel_ministerio'];
$igreja_fk=$_POST['id_igreja'];


$insert="INSERT INTO `crente`(`crente_nome`, `sexo_fk`, `email`, `telefone`, `cargo_fk`, `ministerio_fk`, `igreja_fk`)
          VALUES ('".$nome."','".$sexo."','".$email."','".$telefone."','".$cargo."','".$ministerio."','".$igreja_fk."')";

          if ($db->query($insert)===TRUE)
            {
          //    echo "teste";

              $_SESSION['msg_success'] = "Registou o crente <b>$nome</b> com sucesso.";

              //create QRcode
              header('location: crente_registar.php');


            }else
              {
                $_SESSION['msg_error'] = "Erro ao tentar efectuar o seu registo. Contacte o administrador do sistema para mais detalhes ".$db->error;
                header('location: crente_registar.php');
              }

?>
