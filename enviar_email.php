<?php
require 'vendor/autoload.php'; // Certifique-se de que o Composer instalou o SendGrid

use SendGrid\Mail\Mail;

function enviarEmailConfirmacao($emailDestino, $nomeUsuario) {
    $email = new Mail();
    $email->setFrom("seuemail@seudominio.com", "Nome da Loja"); // Altere para seu e-mail de envio
    $email->setSubject("Confirme seu Cadastro");
    $email->addTo($emailDestino, $nomeUsuario);
    $email->addContent(
        "text/html",
        "Olá $nomeUsuario, <br><br>
        Obrigado por se cadastrar em nossa loja! Para ativar sua conta, clique no link abaixo:<br><br>
        <a href='http://seudominio.com/confirmar.php?email=$emailDestino'>Confirmar Cadastro</a>"
    );

    $sendgrid = new \SendGrid("SUA_API_KEY_AQUI"); // Substitua pela API Key gerada no SendGrid
    try {
        $response = $sendgrid->send($email);
        return $response->statusCode();
    } catch (Exception $e) {
        return 'Erro: ' . $e->getMessage();
    }
}
?>
