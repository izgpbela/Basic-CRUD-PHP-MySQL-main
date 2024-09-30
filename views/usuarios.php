<?php
session_start();
require_once '../controllers/usuarioController.php';

// Verificar se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    echo "Bem-vindo, usuário!";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuarioController = new UsuarioController();

        if (isset($_POST['action']) && $_POST['action'] === 'register') {
            // Ação de registro
            $usuarioController->registrarUsuario();
        } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
            // Ação de login
            $usuarioController->loginUsuario();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários</title>
</head>
<body>

<h2>Registro de Usuário</h2>
<form method="POST" action="usuarios.php">
    <input type="hidden" name="action" value="register">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>
    <br>
    <button type="submit">Registrar</button>
</form>

<h2>Login de Usuário</h2>
<form method="POST" action="usuarios.php">
    <input type="hidden" name="action" value="login">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>
    <br>
    <button type="submit">Login</button>
</form>

</body>
</html>
