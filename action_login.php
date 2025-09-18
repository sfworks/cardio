<?php
session_start();
require_once('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username']; // The form uses 'username' for the email field
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['msg_erro'] = "Por favor, preencha todos os campos.";
        header("LOCATION: login.php");
        exit;
    }

    $stmt = $db->prepare("SELECT registo_id, nome, password, unique_id FROM registo WHERE email = ?");
    if ($stmt === false) {
        // Handle error, maybe log it
        $_SESSION['msg_erro'] = "Erro no sistema, por favor tente mais tarde.";
        header("LOCATION: login.php");
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, start a new session
        session_regenerate_id();
        $_SESSION['login'] = true;
        $_SESSION['cardio_userid'] = $user['registo_id'];
        $_SESSION['cardio_user_name'] = $user['nome'];
        $_SESSION['cardio_user_unique_id'] = $user['unique_id'];

        header("location: dashboard.php");
        exit;
    } else {
        // Invalid credentials
        $_SESSION['msg_erro'] = "Credenciais inválidas. Tente novamente.";
        header("LOCATION: login.php");
        exit;
    }

    $stmt->close();
} else {
    // Not a POST request
    header("LOCATION: login.php");
    exit;
}
?>
