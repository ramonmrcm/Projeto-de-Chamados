<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_digitado = $_POST["usuario"];
    $senha_digitada = $_POST["senha"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chamadosmake";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $query = "SELECT id FROM usuarios WHERE nome_usuario = ? AND senha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usuario_digitado, $senha_digitada);
    $stmt->execute();
    $stmt->store_result();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_digitado = $_POST["usuario"];
    $senha_digitada = $_POST["senha"];

    $query = "SELECT id, senha FROM usuarios WHERE nome_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usuario_digitado);
    $stmt->execute();
    $stmt->bind_result($usuario_id, $senha_hash);

    if ($stmt->fetch() && password_verify($senha_digitada, $senha_hash)) {
        $_SESSION["admin_logged_in"] = $usuario_id;
        header("Location: chamados.php");
        exit();
    } else {
        $erro_login = "Usuário ou senha incorretos.";
    }

    $stmt->close();
    $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="formataProcessarChamado.css">
</head>
<body>

    <h1>Login Administrador</h1>

    <form action="" method="post">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Login</button>
    </form>

    <?php
    if (isset($erro_login)) {
        echo '<p style="color: red;">' . $erro_login . '</p>';
    }
    ?>

  

</body>
</html>
