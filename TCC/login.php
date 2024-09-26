<?php
// Inicia uma sessão para armazenar informações do usuário durante a navegação.
session_start();

// Verifica se o formulário de login foi enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecta ao banco de dados MySQL.
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_db";

    // Cria uma nova conexão com o banco de dados.
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se houve algum erro ao conectar com o banco de dados.
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Obtém o nome de usuário e a senha enviados pelo formulário e aplica funções para evitar SQL injection.
    $user = $conn->real_escape_string($_POST["username"]);
    $pass = $conn->real_escape_string($_POST["password"]);

    // Consulta SQL para buscar o usuário e senha fornecidos.
    $sql = "SELECT id, nome FROM usuarios WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    // Verifica se a consulta retornou exatamente um resultado (login bem-sucedido).
    if ($result->num_rows == 1) {
        // Armazena os dados do usuário na sessão.
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_name"] = $row["nome"];

        // Redireciona o usuário para a página principal (index.php).
        header("Location: index.php");
        exit(); // Encerra o script para garantir que o restante do código não seja executado.
    } else {
        // Define uma mensagem de erro caso o login falhe.
        $error_message = "Nome de usuário ou senha incorretos.";
    }

    // Fecha a conexão com o banco de dados.
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-CommerceX</title>
    <!-- Inclui o arquivo CSS para estilizar a página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <!-- Título da página de login -->
        <h2>Login</h2>
        
        <!-- Formulário de login -->
        <form method="POST" action="">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <!-- Botão de enviar para submeter o formulário -->
            <button type="submit">Entrar</button>
        </form>

        <?php
        // Exibe a mensagem de erro, se existir.
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
