<?php
require_once '../models/usuario.php';
require_once 'config.php'; // Conexão com o banco

class UsuarioController {

    // Método para registrar novo usuário
    public function registrarUsuario() {
        if (isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuario = new Usuario($nome, $email, $senha);
            if ($usuario->salvar($conn)) {
                echo "Usuário registrado com sucesso!";
            } else {
                echo "Erro ao registrar o usuário.";
            }
        }
    }

    // Método para realizar login
    public function loginUsuario() {
        if (isset($_POST['email'], $_POST['senha'])) {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuario = Usuario::buscarPorEmail($conn, $email);
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                echo "Login realizado com sucesso!";
            } else {
                echo "Email ou senha incorretos.";
            }
        }
    }
}
?>
