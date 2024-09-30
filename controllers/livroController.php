<?php
// Inclui o modelo de livro
include_once '../models/livro.php';
include_once '../config.php';

// Inicializa a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

$livro = new Livro($db);

// Verifica a ação a ser tomada (adicionar, emprestar, devolver)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        $livro->titulo = $_POST['titulo'];
        $livro->autor = $_POST['autor'];
        $livro->isbn = $_POST['isbn'];
        $livro->numero_copias = $_POST['numero_copias'];
        if ($livro->adicionarLivro()) {
            header("Location: ../views/livros.php?msg=Livro adicionado com sucesso!");
        } else {
            echo "Erro ao adicionar o livro.";
        }
    }

    if (isset($_POST['emprestar'])) {
        $livro->id = $_POST['id'];
        if ($livro->emprestarLivro()) {
            header("Location: ../views/livros.php?msg=Livro emprestado com sucesso!");
        } else {
            echo "Não há cópias disponíveis.";
        }
    }

    if (isset($_POST['devolver'])) {
        $livro->id = $_POST['id'];
        if ($livro->devolverLivro()) {
            header("Location: ../views/livros.php?msg=Livro devolvido com sucesso!");
        } else {
            echo "Erro ao devolver o livro.";
        }
    }
}
?>
