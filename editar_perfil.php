<?php
require_once('session.php');
require_once('dbconnect.php');

if (!isset($_SESSION['cardio_userid'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['cardio_userid'];

    // Obter os dados do POST
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $instituicao = $_POST['instituicao'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Atualizar na base de dados
    $stmt = $db->prepare("
        UPDATE registo
        SET nome = ?, idade = ?, instituicao = ?, telefone = ?, email = ?
        WHERE registo_id = ?
    ");

    if ($stmt === false) {
        $_SESSION['msg_update'] = "Erro na preparação do statement: " . $db->error;
        header('Location: perfil.php');
        exit;
    }

    $stmt->bind_param(
        'sssssi',
        $nome,
        $idade,
        $instituicao,
        $telefone,
        $email,
        $user_id
    );

    if ($stmt->execute()) {
        $_SESSION['msg_update'] = "<div class='alert alert-success'>Perfil atualizado com sucesso.</div>";
    } else {
        $_SESSION['msg_update'] = "<div class='alert alert-danger'>Erro ao atualizar o perfil: " . $stmt->error . "</div>";
    }

    $stmt->close();
    header('Location: perfil.php');
    exit;
} else {
    header('Location: perfil.php');
    exit;
}
?>
