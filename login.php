<?php
require 'conexao.php'; // Arquivo que conecta ao banco de dados
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Pode ser o e-mail ou o nome de usuário
    $senha = $_POST['senha'];

    // Verificar se o usuário existe e está ativo
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM usuarios WHERE (email = ? OR nome = ?) AND ativo = 1");
    $stmt->execute([$login, $login]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        echo "Login bem-sucedido!";
    } else {
        echo "Usuário ou senha incorretos, ou conta ainda não ativada!";
    }
}
?>
