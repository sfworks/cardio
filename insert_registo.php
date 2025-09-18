<?php
require_once('session.php');
require_once('dbconnect.php');

$msg_success = '';
$msg_error = '';

// Obter os dados do POST
$nome       = $_POST['nome'];
$idade      = $_POST['idade'];
$instituicao= $_POST['instituicao'];
$telefone   = $_POST['telefone'];
$email      = $_POST['email'];
$categoria  = $_POST['categoria'];

// Verificar especialidade se aplicável
$especialidade_especialista = isset($_POST['especialidade_especialista']) ? $_POST['especialidade_especialista'] : '';
$especialidade_residente    = isset($_POST['especialidade_residente']) ? $_POST['especialidade_residente'] : '';

// Valores adicionais
if($categoria==='Médico Especialista')
{
    $valor_pagar   = 1000.00; // definir conforme regras da aplicação
}elseif($categoria==='Médico Residente' || $categoria==='Médico Generalista')
{
$valor_pagar   = 500.00; // definir conforme regras da aplicação
}else
{
$valor_pagar   = 250.00; // definir conforme regras da aplicação
}


$data_pagamento = NULL; // NULL até pagamento ocorrer
//$user_id       = $_SESSION['cardio_userid'] ?? null; // assegurar que está logado
$estado        = 'Pendente'; // default

// Inserir na base de dados
$stmt = $db->prepare("
    INSERT INTO registo (
        nome, idade, instituicao, telefone, email, categoria,
        especialidade_especialista, especialidade_residente,
        valor_pagar, valor_pago, data_pagamento, data_registo, user_id, estado
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)
");

if ($stmt === false) {
    $_SESSION['msg_error'] = "Erro na preparação do statement: " . $db->error;
    header('location: entrada_registar.php');
    exit;
}

// Bind de parâmetros
$stmt->bind_param(
    'ssssssssddsds',
    $nome,
    $idade,
    $instituicao,
    $telefone,
    $email,
    $categoria,
    $especialidade_especialista,
    $especialidade_residente,
    $valor_pagar,
    $valor_pago,
    $data_pagamento,
    $user_id,
    $estado
);

// Executar
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
                Temos o prazer de confirmar o registo dos seus dados com sucesso. Para concluir a sua inscrição, solicitamos a realização do pagamento da taxa de participação no valor de <strong><?= $valor_pagar ?> MT</strong>.
              </p>

             

              <p style="font-size: 16px; color: #333333;">
                Após o pagamento, anexe o comprovativo na plataforma de inscrição, ou envie por email para <a href="mailto:secretariado@reuniaocardiologia.co.mz">secretariado@reuniaocardiologia.co.mz</a> ou via WhatsApp para <strong>+258 828 751 280</strong>.
              </p>

              <p style="font-size: 16px; color: #333333;">
                Sua inscrição será confirmada assim que o pagamento for verificado, e logo após você receberá as orientações logísticas do evento.
              </p>

            </td>
          </tr>
        </table>';
    
    require('email_registo.php');
} else {
    $_SESSION['msg_participante'] = "Erro ao tentar efectuar o seu registo: " . $stmt->error;
}

$stmt->close();

//require('mail_registo.php');
header('Location: participante_registar.php');
exit;
?>
