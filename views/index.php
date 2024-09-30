<?php
include('../config.php');

// Verificar conexão
if (!$db) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Adicionar livro
if (isset($_POST['adicionar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $copias = $_POST['copias'];

    // Inserir no banco de dados
    $query = "INSERT INTO livros (titulo, autor, isbn, num_copias) VALUES ('$titulo', '$autor', '$isbn', '$copias')";
    if (mysqli_query($db, $query)) {
        echo "Livro adicionado com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($db);
    }
}

// Listar livros
$query = "SELECT * FROM livros";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Adicionar Livro</h3>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="copias" class="form-label">Número de Cópias</label>
            <input type="number" name="num_copias" class="form-control" required> <!-- Mudado de 'copias' para 'num_copias' -->
        </div>
        <button type="submit" name="adicionar" class="btn btn-primary">Adicionar Livro</button>
    </form>

    <h3 class="mt-5">Lista de Livros</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Número de Cópias</th> <!-- Mudado de 'Cópias Disponíveis' para 'Número de Cópias' -->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($livro = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                    <td><?php echo htmlspecialchars($livro['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($livro['num_copias']); ?></td> <!-- Mudado de 'copias_disponiveis' para 'num_copias' -->
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="isbn" value="<?php echo $livro['isbn']; ?>">
                            <button type="submit" name="emprestar" class="btn btn-warning">Emprestar</button>
                            <button type="submit" name="devolver" class="btn btn-success">Devolver</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Código para emprestar e devolver livros -->
<?php

if (isset($_POST['emprestar'])) {
    $isbn = $_POST['isbn'];
    $query = "SELECT * FROM livros WHERE isbn='$isbn'";
    $livroResult = mysqli_query($db, $query);
    $livroData = mysqli_fetch_assoc($livroResult);

    // Verifique se o livro existe e há cópias disponíveis
    if ($livroData && $livroData['num_copias'] > 0) {
        // Atualiza o banco de dados
        $novaQuantidade = $livroData['num_copias'] - 1; // Reduz 1 cópia
        $updateQuery = "UPDATE livros SET num_copias='$novaQuantidade' WHERE isbn='$isbn'";
        mysqli_query($db, $updateQuery);
        echo "Livro emprestado com sucesso!";
    } else {
        echo "Desculpe, não há cópias disponíveis.";
    }
} // Esta chave fecha corretamente o if para 'emprestar'

if (isset($_POST['devolver'])) {
    $isbn = $_POST['isbn'];
    $query = "SELECT * FROM livros WHERE isbn='$isbn'";
    $livroResult = mysqli_query($db, $query);
    $livroData = mysqli_fetch_assoc($livroResult);

    // Verifique se o livro existe
    if ($livroData) {
        // Atualiza o banco de dados
        $novaQuantidade = $livroData['num_copias'] + 1; // Aumenta 1 cópia
        $updateQuery = "UPDATE livros SET num_copias='$novaQuantidade' WHERE isbn='$isbn'";
        mysqli_query($db, $updateQuery);
        echo "Livro devolvido com sucesso!";
    } else {
        echo "Livro não encontrado.";
    }
}

?>
</body>
</html>

