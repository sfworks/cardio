<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '.\vendor/autoload.php';


// Coletar dados
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$instituicao = $_POST['instituicao'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$categoria = $_POST['categoria'];
$esp_esp = $_POST['especialidade_especialista'] ?? '';
$esp_res = $_POST['especialidade_residente'] ?? '';

// Determinar valor
switch ($categoria) {
    case 'Médico Especialista':
        $valor = '1000MT';
        break;
    case 'Médico Residente':
    case 'Médico Generalista':
        $valor = '500MT';
        break;
    default:
        $valor = '250MT';
}

// Enviar e-mail
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.icor.co.mz';
    $mail->SMTPAuth = true;
    $mail->Username = 'jose.zindoga@icor.co.mz';
    $mail->Password = '!Zin2603';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('jose.zindoga@icor.co.mz', 'Reunião Cardiologia');
    $mail->addAddress($email, $nome);

    $mail->isHTML(true);
    $mail->Subject = 'Confirmação de Registo - Reunião Cardiologia';

    $conteudo = "
      <p>Prezado(a) <strong>$nome</strong>,</p>
      <p>O seu registo foi recebido com sucesso.</p>
      <p><strong>Categoria Profissional:</strong> $categoria</p>
      <p><strong>Valor da Inscrição:</strong> $valor_pagar</p>
      <p>Para efetuar o pagamento, use as seguintes vias:</p>
      <ul>
        <li>M-Pesa: 84XXXXXXX</li>
        <li>Conta Bancária: BIM – 000000000000</li>
      </ul>
      <p>Obrigado pela sua inscrição!</p>
    ";

    $mail->Body = $conteudo;

    $mail->send();
    echo "<p>Inscrição enviada com sucesso! Verifique seu e-mail.</p>";
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
