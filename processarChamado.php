<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamado processado!</title>
    <link rel="stylesheet" href="formataProcessarChamado.css">
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $sala = $_POST["sala"];
    $assunto = $_POST["assunto"];
    $descricao = $_POST["descricao"];

    // Obtém a data e hora atual
    $dataEnvio = date('Y-m-d H:i:s');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chamadosmake";

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Prepara a instrução SQL
    $sql = "INSERT INTO chamados (nome, sala, assunto, descricao, data_envio) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Verifica se a preparação da instrução foi bem-sucedida
    if ($stmt) {
        // Liga os parâmetros
        $stmt->bind_param("sssss", $nome, $sala, $assunto, $descricao, $dataEnvio);

        // Executa a instrução
        if ($stmt->execute()) {
            echo '<h1 class="mensagem-sucesso">Chamado enviado com Sucesso!</h1>';
        } else {
            echo "Erro ao inserir dados: " . $stmt->error;
        }

        // Fecha a instrução preparada
        $stmt->close();
    } else {
        echo "Erro na preparação da instrução: " . $conn->error;
    }

    // Fecha a conexão
    $conn->close();
}
?>

<!-- Botão de Voltar -->
<div class="botao-container">
    <a href="index.php" class="botao-voltar">Voltar para o Formulário de Chamados</a>
</div>

</body>
</html>
