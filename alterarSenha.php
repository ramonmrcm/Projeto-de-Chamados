<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

// Conecta ao banco de dados (substitua com suas próprias credenciais)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chamadosmake";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para atualizar a senha
function atualizarSenha($novaSenha, $usuarioID, $conn)
{
    $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $hashSenha = password_hash($novaSenha, PASSWORD_DEFAULT); // Hash da nova senha
    $stmt->bind_param("si", $hashSenha, $usuarioID);

    return $stmt->execute();
}

// Se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novaSenha = $_POST["nova_senha"];

    if (atualizarSenha($novaSenha, $_SESSION["admin_logged_in"], $conn)) {
        $mensagem = "Senha atualizada com sucesso!";
    } else {
        $erro = "Erro ao atualizar a senha. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="formataProcessarChamado.css">
</head>
<body>

    <h1>Alterar Senha</h1>

    <?php
    if (isset($mensagem)) {
        echo '<p style="color: green;">' . $mensagem . '</p>';
    }

    if (isset($erro)) {
        echo '<p style="color: red;">' . $erro . '</p>';
    }
    ?>

    <form action="" method="post">
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>

        <button type="submit">Alterar Senha</button>
    </form>

    <a href="chamados.php">Voltar para os Chamados</a>
    <a href="logout.php">Logout</a>

</body>
</html>
