<?php
require_once('dbconnect.php'); // conexão com $db
session_start();

// Verificar se o ID foi passado e é numérico
if (isset($_GET['registo_id']) && is_numeric($_GET['registo_id'])) {
    $registo_id = (int) $_GET['registo_id'];

    try {
        // Preparar e executar a exclusão
        $stmt = $db->prepare("DELETE FROM registo WHERE registo_id = ?");
        $stmt->bind_param("i", $registo_id);

        if ($stmt->execute()) {
            $_SESSION['msg_participante'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                                Registo removido com Sucesso  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>   
                                            </div>";
        } else {
            $_SESSION['msg_participante'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                                Erro ao remover o participante.  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>   
                                            </div>";

        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['msg_participante'] = "Erro: " . $e->getMessage();
        "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                                Erro: ".$e->getMessage()."  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>   
                                            </div>";
    }
} else {
    $_SESSION['msg_participante'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                               ID inválido.  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>   
                                            </div>";
}

// Redirecionar de volta à página de entrada
header("Location: participante_registar.php");
exit();
?>
