-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2021 at 08:05 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

USE Biblioteca;  -- Adicione esta linha para selecionar o banco de dados

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `Biblioteca`
-- --------------------------------------------------------

-- Table structure for table `livros`
CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    num_copias INT NOT NULL  -- Esta é a coluna que você deve usar
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `livros`
INSERT INTO `livros` (`titulo`, `autor`, `isbn`, `num_copias`) VALUES
('O Senhor dos Anéis', 'J.R.R. Tolkien', '9781234567890', 5),
('Dom Quixote', 'Miguel de Cervantes', '9781234567891', 3),
('O Hobbit', 'J.R.R. Tolkien', '9781234567892', 2);

-- Indexes for dumped tables
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn_unique` (`isbn`);

-- AUTO_INCREMENT for dumped tables
ALTER TABLE `livros`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Table structure for table `usuarios`
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `usuarios`
INSERT INTO `usuarios` (`nome`, `email`, `senha`) VALUES
('João Silva', 'joao.silva@email.com', 'senha123'),
('Maria Santos', 'maria.santos@email.com', 'senha456'),
('Pedro Oliveira', 'pedro.oliveira@email.com', 'senha789');

-- --------------------------------------------------------
-- Table structure for table `emprestimos`
CREATE TABLE IF NOT EXISTS emprestimos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_livro INT NOT NULL,
    id_usuario INT NOT NULL,
    data_emprestimo DATE NOT NULL,
    data_devolucao DATE DEFAULT NULL,
    CONSTRAINT fk_livro FOREIGN KEY (id_livro) REFERENCES livros(id),
    CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `emprestimos`
INSERT INTO `emprestimos` (`id_livro`, `id_usuario`, `data_emprestimo`, `data_devolucao`) VALUES
(1, 1, '2024-09-01', NULL),
(2, 2, '2024-09-05', '2024-09-15'),
(3, 3, '2024-09-07', NULL);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;S