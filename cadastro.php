<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = $_POST["senha"];

    // verifica se o email já foi cadastrado
    $stmt = $conn->prepare("SELECT idUsuario FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $erro = "Este e-mail já está cadastrado.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuario (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $telefone, $senhaHash);
        $stmt->execute();
        header("location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <header id="menu"></header>
    <script src="script/menu.js"></script>

    <main>
        <div class="agendamento">
            <h1>Criar conta</h1>

            <?php if (isset($erro)) echo "<p class=\"erro\">$erro</p>"; ?>

            <form method="POST">
                <p><label for="cadastroNome">Nome Completo</label></p>
                <input type="text" name="nome" id="cadastroNome" class="input"
                    placeholder="Antonio Junior" autocomplete="name"
                    minlength="3" required>

                <p><label for="cadastroTelefone">Telefone</label></p>
                <input type="tel" name="telefone" id="cadastroTelefone" class="input"
                    placeholder="41999999999" autocomplete="tel"
                    pattern="\d{11}" maxlength="11"
                    title="Digite 11 números: DDD + celular" required>

                <p><label for="cadastroEmail">Email</label></p>
                <input type="email" name="email" id="cadastroEmail" class="input"
                    placeholder="seuemail@email.com" autocomplete="email" required>

                <p><label for="cadastroSenha">Senha</label></p>
                <input type="password" name="senha" id="cadastroSenha" class="input"
                    autocomplete="new-password" minlength="6"
                    title="Mínimo de 6 caracteres" required>
                <button type="submit">Cadastrar</button>
            </form>

            <p>Já tem conta? <a href="login.php">Entrar</a></p>
        </div>
    </main>
    <footer id="rodape"></footer>
    <script src="script/rodape.js"></script>
</body>

</html>