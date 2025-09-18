<?php
session_start();
 ob_start();
  $_SESSION["timeout"] = time();
    if(time() - $_SESSION["timeout"] > 100)
    {
     unset($_SESSION["timeout"]);
    }


if(isset($_SESSION['cardio_userid']))
{
$user_id=$_SESSION['cardio_userid'];
$user_nome =$_SESSION['cardio_usernome'];
$user_perfil =$_SESSION['cardio_userperfil'];



}else {
  // code...
  header("LOCATION:login.php?");
}
?>
