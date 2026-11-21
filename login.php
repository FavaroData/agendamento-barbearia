<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, nome, senha_hash FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();
    if ($usuario && password_verify($senha, $usuario["senha_hash"])) {
        session_regenerate_id(true);
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nome"] = $usuario["nome"];
        header("location: index.html");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <header id="menu"></header>
    <script src="script/menu.js"></script>

    <main>
        <div class=" agendamento">
            <h1>Entrar</h1>

            <?php if (isset($erro)) echo "<p>$erro</p>"; ?>

            <form method="POST" class="agendamento">
                <p><label for="loginEmail">Email</label></p>
                <input type="email" name="email" id="loginEmail" class="input"
                    placeholder="seuemail@email.com" autocomplete="email" required>

                <p><label for="loginSenha">Senha</label></p>
                <input type="password" name="senha" id="loginSenha" class="input"
                    autocomplete="current-password" required>

                <button type="submit">Entrar</button>
            </form>

            <p>Não tem conta? <a href="cadastro.php">Criar conta</a></p>
    </main>
</body>

</html>