<?php
// Inicia a sessão para armazenar informações do usuário e mensagens de feedback.
session_start();

// Verifica se o formulário de registro foi enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados MySQL.
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce_db";

    // Cria uma nova conexão com o banco de dados.
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se houve erro na conexão.
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Recebe os dados enviados pelo formulário e aplica funções de segurança para evitar SQL injection.
    $user = $conn->real_escape_string($_POST["username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $pass = $conn->real_escape_string($_POST["password"]);
    $confirm_pass = $conn->real_escape_string($_POST["confirm_password"]);

    // Verifica se a senha e a confirmação de senha correspondem.
    if ($pass === $confirm_pass) {
        // Verifica se o nome de usuário ou e-mail já está cadastrado no banco de dados.
        $check_user_sql = "SELECT id FROM usuarios WHERE username = '$user' OR email = '$email'";
        $result = $conn->query($check_user_sql);

        // Se o usuário ou e-mail já existe, define uma mensagem de erro.
        if ($result->num_rows > 0) {
            $error_message = "Nome de usuário ou e-mail já cadastrado.";
        } else {
            // Insere os dados do novo usuário no banco de dados.
            $sql = "INSERT INTO usuarios (username, email, password) VALUES ('$user', '$email', '$pass')";
            
            // Verifica se a inserção foi bem-sucedida e define uma mensagem de sucesso ou erro.
            if ($conn->query($sql) === TRUE) {
                $success_message = "Registro bem-sucedido! Você já pode fazer login.";
            } else {
                $error_message = "Erro ao registrar: " . $conn->error;
            }
        }
    } else {
        // Define uma mensagem de erro caso as senhas não correspondam.
        $error_message = "As senhas não correspondem.";
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
    <title>Registro - E-CommerceX</title>
    <!-- Link para o arquivo CSS para estilizar a página -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="register-container">
        <!-- Título da página de registro -->
        <h2>Registro</h2>
        
        <!-- Formulário de registro -->
        <form method="POST" action="">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirmar Senha:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <!-- Botão de enviar para submeter o formulário de registro -->
            <button type="submit">Registrar</button>
        </form>

        <?php
        // Exibe mensagem de erro ou sucesso, se houver.
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        } elseif (isset($success_message)) {
            echo "<p class='success-message'>$success_message</p>";
        }
        ?>
    </div>
</body>
</html>
