<?php
require 'conexao.php'; // Arquivo que conecta ao banco de dados

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    
    // Atualizar o status do usuário para ativo (1)
    $stmt = $conn->prepare("UPDATE usuarios SET ativo = 1 WHERE email = ?");
    if ($stmt->execute([$email])) {
        echo "Conta ativada com sucesso! Agora você pode fazer login.";
    } else {
        echo "Erro ao ativar a conta!";
    }
} else {
    echo "Link inválido!";
}
?>
