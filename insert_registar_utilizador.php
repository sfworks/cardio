<?php
require_once('dbconnect.php'); // $db é sua conexão MySQLi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];
    $perfil = 'Participante';

    if ($password !== $confirmar_password) {
        die("Erro: as senhas não coincidem.");
    }

    // Verificar se já existe um utilizador com este email
    $stmt_check = $db->prepare("SELECT utilizador_id FROM utilizador WHERE username = ?");
    if (!$stmt_check) {
        die("Erro ao preparar verificação: " . $db->error);
    }

    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
       
        $msg= $_SESSION['msg_insert']= '<div class="alert alert-success" role="alert">  Erro: O utilizador "'.$email.'" já existe! Tente novamente ou contacte a administracao do evento para suporte </div>';
        $stmt_check->close();
        $db->close();
       
         header('Location: login.php?nome="'.$nome.'"&email="'.$email.'"&msg="'.$msg.'"');
          exit();
    }
    $stmt_check->close();

    // Criptografar a senha
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Inserir novo utilizador
    $stmt = $db->prepare("INSERT INTO utilizador (utilizador_nome, username, password, perfil) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro ao preparar inserção: " . $db->error);
    }

    $stmt->bind_param("ssss", $nome, $email, $password, $perfil);

    if ($stmt->execute()) {
     

 

     // Verificar se já existe um utilizador com este email
$stmt_check = $db->prepare("SELECT utilizador_id, utilizador_nome, perfil FROM utilizador WHERE username = ?");
if (!$stmt_check) {
    die("Erro ao preparar verificação: " . $db->error);
}

$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    $stmt_check->bind_result($utilizador_id, $utilizador_nome, $perfil);
    $stmt_check->fetch();

    // Iniciar sessão se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

      $msg= $_SESSION['msg_insert']= '<div class="alert alert-success" role="alert">  Conta  de utilizador criada. | Preencha os formulario abaixo para registar para evento </div>';


    $_SESSION['cardio_userid'] = $utilizador_id;
    $_SESSION['cardio_usernome'] = $utilizador_nome;
    $_SESSION['cardio_userperfil'] = $perfil;
}
$stmt_check->close();




       header('Location: participante_registar.php?nome=' . urlencode($nome) . '&email=' . urlencode($email) . '&msg=' . urlencode($msg));

    } else {
      //  echo die("Erro ao criar conta: " . $stmt->error);
         $_SESSION['msg_insert']= '<div class="alert alert-danger" role="alert">  Erro ao criar conta! "' . $stmt->error.'"</div>';
    }

    $stmt->close();
    $db->close();
}
?>
