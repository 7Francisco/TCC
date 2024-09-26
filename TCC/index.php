<?php
// Inicia uma sessão para manter o usuário logado.
session_start();

// Verifica se o usuário está logado, caso contrário, redireciona para a página de login.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit(); // Encerra o script para garantir que o restante do código não seja executado.
}

// Conexão com o banco de dados MySQL.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

// Cria uma nova conexão com o banco de dados.
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve algum erro na conexão com o banco de dados.
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para selecionar todos os produtos da tabela 'produtos'.
$sql = "SELECT nome, preco, imagem FROM produtos";
$result = $conn->query($sql); // Executa a consulta e armazena o resultado em $result.
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-CommerceX - Loja Virtual</title>
    <!-- Inclui o arquivo CSS para estilizar a página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <!-- Logo da empresa -->
        <img src="images/Logo.png" alt="Logo da Empresa" class="logo">
        <!-- Exibe uma mensagem de boas-vindas com o nome do usuário logado -->
        <h1>Bem-vindo, <?php echo $_SESSION["user_name"]; ?>!</h1>
        <!-- Link para o logout -->
        <a href="logout.php">Logout</a>
    </header>

    <!-- Menu de navegação -->
    <nav>
        <ul>
            <li><a href="#">Início</a></li>
            <li><a href="#">Produtos</a></li>
            <li><a href="#">Carrinho</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
    </nav>

    <!-- Seção de produtos -->
    <section class="produtos">
        <h2>Nossos Produtos</h2>
        <div class="produtos-lista">
            <?php
            // Verifica se a consulta retornou algum resultado.
            if ($result->num_rows > 0) {
                // Loop através de todos os produtos retornados pela consulta.
                while ($row = $result->fetch_assoc()) {
                    // Exibe cada produto em um bloco com imagem, nome e preço.
                    echo '<div class="produto">';
                    echo '<img src="images/' . $row["imagem"] . '" alt="' . $row["nome"] . '">';
                    echo '<h3>' . $row["nome"] . '</h3>';
                    echo '<p>R$ ' . number_format($row["preco"], 2, ',', '.') . '</p>';
                    echo '</div>';
                }
            } else {
                // Caso não haja produtos, exibe uma mensagem informativa.
                echo '<p>Nenhum produto encontrado.</p>';
            }
            ?>
        </div>
    </section>

    <!-- Rodapé do site -->
    <footer>
        <p>&copy; 2024 E-CommerceX. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados.
$conn->close();
?>
