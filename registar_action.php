<?php
require_once('session.php');
require_once('dbconnect.php');

// Obter os dados do POST
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$instituicao = $_POST['instituicao'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$categoria = $_POST['categoria'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Verificar se as senhas coincidem
if ($password !== $confirm_password) {
    $_SESSION['msg_insert'] = "<div class='alert alert-danger'>As senhas não coincidem.</div>";
    header('Location: participante_registar.php');
    exit;
}

// Verificar especialidade se aplicável
$especialidade_especialista = isset($_POST['especialidade_especialista']) ? $_POST['especialidade_especialista'] : '';
$especialidade_residente = isset($_POST['especialidade_residente']) ? $_POST['especialidade_residente'] : '';

// Valores adicionais
if ($categoria === 'Médico Especialista') {
    $valor_pagar = 1000.00;
} elseif ($categoria === 'Médico Residente' || $categoria === 'Médico Generalista') {
    $valor_pagar = 500.00;
} else {
    $valor_pagar = 250.00;
}

$data_pagamento = NULL;
$estado = 'Pendente';

// Gerar ID único
$unique_id = uniqid('user_', true);

// Hash da senha
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Processar upload do comprovativo
$comprovativo_path = '';
if (isset($_FILES['comprovativo']) && $_FILES['comprovativo']['error'] == 0) {
    $ficheiro = $_FILES['comprovativo'];
    $nome_original = basename($ficheiro['name']);
    $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));

    $permitidas = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
    if (in_array($extensao, $permitidas)) {
        $hoje = new DateTime();
        $dir_base = 'comprovativo';
        $dir_ano = $dir_base . '/' . $hoje->format('Y');
        $dir_mes = $dir_ano . '/' . $hoje->format('m');
        $dir_dia = $dir_mes . '/' . $hoje->format('d');

        if (!is_dir($dir_dia)) {
            mkdir($dir_dia, 0777, true);
        }

        $novo_nome = uniqid('comp_') . '.' . $extensao;
        $caminho_completo = $dir_dia . '/' . $novo_nome;

        if (move_uploaded_file($ficheiro['tmp_name'], $caminho_completo)) {
            $comprovativo_path = $caminho_completo;
        } else {
            $_SESSION['msg_insert'] = "<div class='alert alert-danger'>Erro ao mover o ficheiro.</div>";
            header('Location: participante_registar.php');
            exit;
        }
    } else {
        $_SESSION['msg_insert'] = "<div class='alert alert-danger'>Extensão de ficheiro não permitida.</div>";
        header('Location: participante_registar.php');
        exit;
    }
} else {
    $_SESSION['msg_insert'] = "<div class='alert alert-danger'>Erro no upload do comprovativo.</div>";
    header('Location: participante_registar.php');
    exit;
}

// Inserir na base de dados
$stmt = $db->prepare("
    INSERT INTO registo (
        nome, idade, instituicao, telefone, email, categoria,
        especialidade_especialista, especialidade_residente,
        valor_pagar, data_registo, estado, comprovativo, password, unique_id
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)
");

if ($stmt === false) {
    $_SESSION['msg_insert'] = "Erro na preparação do statement: " . $db->error;
    header('location: participante_registar.php');
    exit;
}

$stmt->bind_param(
    'ssssssssdssss',
    $nome,
    $idade,
    $instituicao,
    $telefone,
    $email,
    $categoria,
    $especialidade_especialista,
    $especialidade_residente,
    $valor_pagar,
    $estado,
    $comprovativo_path,
    $hashed_password,
    $unique_id
);

if ($stmt->execute()) {
    $_SESSION['msg_participante'] = '
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; margin: 30px 0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
          <tr>
            <td style="padding: 30px;">
              <p style="font-size: 16px; color: #333333;">
                Agradecemos o registo da sua inscrição na <strong>Primeira Reunião Científica de Saúde Cardiovascular</strong>, a decorrer nos dias <strong>07 e 08 de Novembro de 2025</strong>.
              </p>
              <p style="font-size: 16px; color: #333333;">
                Temos o prazer de confirmar o registo dos seus dados com sucesso.
              </p>
            </td>
          </tr>
        </table>';

    // Iniciar sessão de utilizador
    $_SESSION['cardio_userid'] = $db->insert_id;
    $_SESSION['cardio_user_unique_id'] = $unique_id;
    $_SESSION['cardio_user_name'] = $nome;

    require('email_registo.php');
    header('Location: dashboard.php');
    exit;
} else {
    $_SESSION['msg_insert'] = "Erro ao tentar efectuar o seu registo: " . $stmt->error;
    header('Location: participante_registar.php');
    exit;
}

$stmt->close();
?>
