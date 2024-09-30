<?php
class Livro {
    private $conn;
    private $table_name = "livros";

    public $id;
    public $titulo;
    public $autor;
    public $isbn;
    public $numero_copias;

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para adicionar um livro ao banco de dados
    public function adicionarLivro() {
        $query = "INSERT INTO " . $this->table_name . " (titulo, autor, isbn, numero_copias) VALUES (:titulo, :autor, :isbn, :numero_copias)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':autor', $this->autor);
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':numero_copias', $this->numero_copias);

        return $stmt->execute();
    }

    // Método para emprestar um livro
    public function emprestarLivro() {
        if ($this->verificarDisponibilidade()) {
            $query = "UPDATE " . $this->table_name . " SET numero_copias = numero_copias - 1 WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    // Método para devolver um livro
    public function devolverLivro() {
        $query = "UPDATE " . $this->table_name . " SET numero_copias = numero_copias + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Verificar a disponibilidade de cópias
    public function verificarDisponibilidade() {
        $query = "SELECT numero_copias FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $
