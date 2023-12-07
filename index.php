<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Chamado </title>
    <link rel="stylesheet" href="formataFormulario.css">
</head>
<body>

    <h1>Formulário de Chamado</h1>

    <form action="processarChamado.php" method="post">
        <!-- Campo Nome -->
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <!-- Campo Sala -->
        <label for="sala">Sala:</label>
        <input type="text" id="sala" name="sala" required>

        <!-- Campo Assunto -->
        <label for="assunto">Assunto:</label>
        <input type="text" id="assunto" name="assunto" required>

        <!-- Campo Descrição -->
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>

        <!-- Campo Data e Hora (Campo Oculto) -->
        <input type="hidden" name="data_envio" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <!-- Contêiner do Botão -->
        <div class="botao-container">
            <!-- Botão de Enviar -->
            <button type="submit">Enviar</button>
        </div>
    </form>


</body>
</html>



