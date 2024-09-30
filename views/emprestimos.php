<?php
// Incluir a conexão com o banco de dados
require_once '../config.php';

// Função para listar os empréstimos
function listarEmprestimos($conn) {
    $sql = "SELECT e.id, l.titulo, u.nome, e.data_emprestimo, e.data_devolucao
            FROM emprestimos e
            INNER JOIN livros l ON e.id_livro = l.id
            INNER JOIN usuarios u ON e.id_usuario = u.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Livro</th>
                    <th>Usuário</th>
                    <th>Data de Empréstimo</th>
                    <th>Data de Devolução</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['titulo']}</td>
                    <td>{$row['nome']}</td>
                    <td>{$row['data_emprestimo']}</td>
                    <td>" . ($row['data_devolucao'] ?? 'Ainda não devolvido') . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum empréstimo encontrado.";
    }
}

// Função para registrar um novo empréstimo
function registrarEmprestimo($conn, $idLivro, $idUsuario) {
    $sql = "INSERT INTO emprestimos (id_livro, id_usuario, data_emprestimo) VALUES (?, ?, CURDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idLivro, $idUsuario);
    if ($stmt->execute()) {
        // Reduzir o número de cópias disponíveis do livro
        $updateLivro = "UPDATE livros SET num_copias = num_copias - 1 WHERE id = ?";
        $stmtLivro = $conn->prepare($updateLivro);
        $stmtLivro->bind_param("i", $idLivro);
        $stmtLivro->execute();
        echo "Empréstimo registrado com sucesso.";
    } else {
        echo "Erro ao registrar o empréstimo: " . $conn->error;
    }
    $stmt->close();
}

// Função para registrar a devolução de um livro
function registrarDevolucao($conn, $idEmprestimo) {
    $sql = "UPDATE emprestimos SET data_devolucao = CURDATE() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEmprestimo);
    if ($stmt->execute()) {
        // Aumentar o número de cópias disponíveis do livro
        $queryLivro = "SELECT id_livro FROM emprestimos WHERE id = ?";
        $stmtLivro = $conn->prepare($queryLivro);
        $stmtLivro->bind_param("i", $idEmprestimo);
        $stmtLivro->execute();
        $stmtLivro->bind_result($idLivro);
        $stmtLivro->fetch();

        $updateLivro = "UPDATE livros SET num_copias = num_copias + 1 WHERE id = ?";
        $stmtUpdate = $conn->prepare($updateLivro);
        $stmtUpdate->bind_param("i", $idLivro);
        $stmtUpdate->execute();

        echo "Devolução registrada com sucesso.";
    } else {
        echo "Erro ao registrar a devolução: " . $conn->error;
    }
    $stmt->close();
}

// Verificar se o formulário de novo empréstimo foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['novo_emprestimo'])) {
        $idLivro = $_POST['id_livro'];
        $idUsuario = $_POST['id_usuario'];
        registrarEmprestimo($conn, $idLivro, $idUsuario);
    } elseif (isset($_POST['registrar_devolucao'])) {
        $idEmprestimo = $_POST['id_emprestimo'];
        registrarDevolucao($conn, $idEmprestimo);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciamento de Empréstimos</title>
</head>
<body>
    <h1>Empréstimos de Livros</h1>

    <!-- Formulário para registrar um novo empréstimo -->
    <h2>Registrar Novo Empréstimo</h2>
    <form method="POST" action="emprestimos.php">
        <label for="id_livro">ID do Livro:</label>
        <input type="number" name="id_livro" required>
        <br>
        <label for="id_usuario">ID do Usuário:</label>
  
