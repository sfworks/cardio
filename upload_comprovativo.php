<?php
session_start(); // Necessário para usar $_SESSION

require_once('dbconnect.php'); // conexão MySQLi, ex: $db = new mysqli(...);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_registo = $_POST['registo_id'] ?? null;
    $valor_pago = $_POST['valor_pago'] ?? 0.00;

    if (!isset($_FILES['comprovativo']) || empty($id_registo)) {
        die("Erro: Dados incompletos. ID: ".$id_registo);
    }

    $ficheiro = $_FILES['comprovativo'];
    $nome_original = basename($ficheiro['name']);
    $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));

    // Verifica se extensão é permitida
    $permitidas = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
    if (!in_array($extensao, $permitidas)) {
        die("Erro: Extensão de ficheiro não permitida.");
    }

    // Geração do diretório com base na data atual
    $hoje = new DateTime();
    $dir_base = 'Comprovativo';
    $dir_ano  = $dir_base . '/' . $hoje->format('Y');
    $dir_mes  = $dir_ano . '/' . $hoje->format('m');
    $dir_dia  = $dir_mes . '/' . $hoje->format('d');

    // Criação recursiva do diretório
    if (!is_dir($dir_dia)) {
        mkdir($dir_dia, 0777, true);
    }

    // Caminho final e nome do ficheiro (único)
    $novo_nome = uniqid('comp_') . '.' . $extensao;
    $caminho_completo = $dir_dia . '/' . $novo_nome;

    // Move o ficheiro para o diretório criado
    if (move_uploaded_file($ficheiro['tmp_name'], $caminho_completo)) {
        $caminho_para_bd = $caminho_completo; // Usar caminho relativo

        // Atualiza a tabela `registo`
       $stmt = $db->prepare("
                            UPDATE registo 
                            SET comprovativo = ?, valor_pago = ?, data_pagamento = NOW() 
                            WHERE registo_id = ?
                        ");
                        if ($stmt) {
                            $stmt->bind_param("sdi", $caminho_para_bd, $valor_pago, $id_registo);
            if ($stmt->execute()) {
                $_SESSION['msg_participante'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Ficheiro carregado e registo atualizado com sucesso.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            } else {
                $_SESSION['msg_participante'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Erro ao atualizar o registo: " . $stmt->error . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            $stmt->close();
        } else {
            $_SESSION['msg_participante'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Erro ao preparar a query: " . $db->error . "
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        $_SESSION['msg_participante'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Erro ao mover o ficheiro.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }

    header("Location: participante_registar.php"); // Redirecionar de volta à página
    exit();
}
?>
