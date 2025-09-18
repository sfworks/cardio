<?php
// Garante que as variáveis estejam disponíveis dentro do mail_text_html.php
ob_start();
include('mail_text_html.php'); // Este arquivo deve usar as variáveis $nome e $valor_pagar
$mensagem_html = ob_get_clean();


$to = $email;
$subject = "Confirmação de Registo – Reunião Científica de Saúde Cardiovascular";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

// Email do remetente
$headers .= "From: Reunião Cardiovascular <secretariado@reuniaocardiologia.co.mz>" . "\r\n";

// Opcional: cópia oculta (para organização)
$headers .= "Bcc: jose.zindoga@reuniaocardiologia.co.mz\r\n";

// Enviar
$mail_enviado = mail($to, $subject, $mensagem_html, $headers);

if ($mail_enviado) {
    echo "Email enviado com sucesso!";
} else {
    echo "Erro ao enviar o e-mail.";
}


?>