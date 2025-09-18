<?php

session_start();
 ob_start();
  $_SESSION["timeout"] = time();
    if(time() - $_SESSION["timeout"] > 100)
    {
     unset($_SESSION["timeout"]);
    }


include 'dbconnect.php';

$msg="";


// inicializa variaveis de login


	  $username = $_POST['username'];
	  $password = $_POST['password'];
	



	try{



            $sql = "SELECT utilizador_id, utilizador_nome, perfil,  username, password from utilizador
			
		
                 WHERE username ='$username' AND password ='$password'";
              $query = mysqli_query($db, "$sql");
              $result = $db->query($sql);

              while ($row = mysqli_fetch_array($query))

            if (!empty($row['username']))
            {
						$userN= $row['username'];
						$userP= $row['password'];
						$user_id= $row['utilizador_id'];
						$user_nome= $row['utilizador_nome'];
						$user_perfil= $row['perfil'];
						

//echo $user_provincia_nome;
}


} catch(Exception $e)
		   {
		   echo $e->getMessage();
		   }

	 if($username === $userN && $password === $userP)
	  {

		$_SESSION['login'] = true;

	// Cria sessao do perfil e User ID e nome do utilizador
						$_SESSION['cardio_userid'] = $user_id;
						$_SESSION['cardio_usernome'] = $user_nome;
						$_SESSION['cardio_userperfil'] = $user_perfil;
					

            header("location: participante_registar.php?");
       }else
         {
         echo "<script>alert('A conta não é válida, tente novamente')</script>";
         $_SESSION['msg_erro'] ="Erro de credenciais! Tente novamente ";
   		  header("LOCATION:login.php?");
         }







?>
