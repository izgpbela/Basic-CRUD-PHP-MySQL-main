<?php
include '../controllers/livroController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
</head>
<body>
    <h1>Gerenciamento de Livros</h1>

    <!-- Formulário para adicionar livro -->
    <form action="../controllers/livroController.php" method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        <input type="number" name="num_copias" placeholder="Número de cópias" required>
        <button type="submit" name="adicionar">Adicionar Livro</button>
    </form>

    <h2>Lista de Livros</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>ISBN</th>
            <th>Cópias Disponíveis</th>
            <th>Ações</th>
        </tr>
        <?php
        $stmt = $livro->listarLivros();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['titulo']}</td>";
            echo "<td>{$row['autor']}</td>";
            echo "<td>{$row['isbn']}</td>";
            echo "<td>{$row['num_copias']}</td>";
            echo "<td>";
            echo "<form action='../controllers/livroController.php' method='POST'>";
            echo "<input type='hidden' name='id' value='{$row['id']}'>";
            echo "<button type='submit' name='emprestar'>Emprestar</button>";
            echo "<button type='submit' name='devolver'>Devolver</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
