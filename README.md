# Basic-CRUD-PHP-MySQL
Here is a web view running on localhost.

![vid2](https://user-images.githubusercontent.com/66185022/105703821-c6a63f00-5f48-11eb-81d2-eee4b805243b.gif)

How to run this project?
1. Install XAMPP on your laptop then turn on Apache and MySQL.
2. Download or clone this repository and move the folder to C:/xampp/htdocs.
3. Now, write localhost/phpmyadmin into your browser, after that import the database.
4. Finally, access the web at localhost/belajar-crud/index.php in your browser.


Sobre os Controllers
usuario.php define a estrutura de um usuário e interage diretamente com o banco de dados.
usuarioController.php manipula as operações de registro e login.
usuarios.php exibe as interfaces de formulário para o registro e login de usuários.
Essas classes e arquivos se comunicam entre si, com o controlador recebendo as entradas de usuarios.php, o modelo Usuario manipulando as operações no banco de dados, e o controlador gerenciando a lógica de aplicação.



Tabela emprestimos:

id: ID único para cada registro de empréstimo.
id_livro: Relaciona o livro emprestado (chave estrangeira que referencia o id da tabela livros).
id_usuario: Relaciona o usuário que fez o empréstimo (chave estrangeira que referencia o id da tabela usuarios).
data_emprestimo: Data em que o livro foi emprestado.
data_devolucao: Data de devolução do livro (pode ser NULL se o livro ainda não foi devolvido).
Chaves estrangeiras:

fk_livro: Garante que o ID do livro exista na tabela livros.
fk_usuario: Garante que o ID do usuário exista na tabela usuarios.
Exemplos de inserções:

Foram inseridos três registros de empréstimos, sendo que dois ainda não foram devolvidos (data_devolucao = NULL), e um foi devolvido.
