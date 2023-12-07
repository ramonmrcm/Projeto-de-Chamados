<?php
session_start();

if (!isset($_SESSION["admin_logged_in"]) || !$_SESSION["admin_logged_in"]) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chamadosmake";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$chamadosPorPagina = 5;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $chamadosPorPagina;

$query = "SELECT id, nome, sala, assunto, descricao, DATE_FORMAT(data_envio, '%Y-%m-%d %H:%i:%s') AS data_envio_formatada 
          FROM chamados ORDER BY id DESC LIMIT $chamadosPorPagina OFFSET $offset";

$result = $conn->query($query);

$totalChamadosQuery = "SELECT COUNT(*) as total FROM chamados";
$totalChamadosResult = $conn->query($totalChamadosQuery);
$totalChamados = $totalChamadosResult->fetch_assoc()['total'];
$totalPaginas = ceil($totalChamados / $chamadosPorPagina);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamados Enviados</title>
    <link rel="stylesheet" href="formataProcessarChamado.css">
    <link rel="stylesheet" href="formataChamados.css">
</head>
<body>

    <div id="sidebar">
        <a href="alterarSenha.php" class="button">Alterar Senha</a>
        <a href="logout.php" class="button">Logout</a>
    </div>

    <div id="content">

        <h1>Chamados Solicitados</h1>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>ID: " . $row["id"] . "<br>";
                echo "Nome: " . $row["nome"] . "<br>";
                echo "Sala: " . $row["sala"] . "<br>";
                echo "Assunto: " . $row["assunto"] . "<br>";
                echo "Descrição: " . $row["descricao"] . "<br>";
                echo "Data e Hora de Envio: " . $row["data_envio_formatada"] . "<br></p>";
            }
        } else {
            echo "Nenhum chamado encontrado.";
        }

        echo "<ul class='pagination'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo "<li><a href='chamados.php?pagina=$i'>$i</a></li>";
        }
        echo "</ul>";

        $conn->close();
        ?>

    </div>

</body>
</html>
