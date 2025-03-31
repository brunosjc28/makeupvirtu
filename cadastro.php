<?php
require 'enviar_email.php';
require 'conexao.php'; // Arquivo que conecta ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    // Verificar se o e-mail já está cadastrado
    $verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica->execute([$email]);
    
    if ($verifica->rowCount() > 0) {
        echo "E-mail já cadastrado!";
    } else {
        // Inserir usuário no banco, mas com status '0' (inativo)
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, ativo) VALUES (?, ?, ?, 0)");
        if ($stmt->execute([$nome, $email, $senha])) {
            // Enviar e-mail de confirmação
            $status = enviarEmailConfirmacao($email, $nome);
            
            if ($status == 202) {
                echo "Cadastro realizado! Verifique seu e-mail para confirmar a conta.";
            } else {
                echo "Erro ao enviar o e-mail de confirmação.";
            }
        } else {
            echo "Erro ao cadastrar!";
        }
    }
}
?>
