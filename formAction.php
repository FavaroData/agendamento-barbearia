<?php
include "verifica_login.php";
include "conexao.php";

// SELECT: busca o agendamento pelo id, só se for do usuário logado
$idAgendamento = isset($_GET["id"]) ? $_GET["id"] : 0;
$idUsuario = $_SESSION["usuario_id"];

$stmt = $conn->prepare("
    SELECT u.nome, u.email, u.telefone, ag.data, h.hora,
           ub.nome AS barbeiro, s.nome AS servico, s.preco, a.observacoes
    FROM agendamento a
    JOIN usuario  u  ON u.idUsuario  = a.idUsuario
    JOIN horario  h  ON h.idHorario  = a.idHorario
    JOIN agenda   ag ON ag.idAgenda  = h.idAgenda
    JOIN barbeiro b  ON b.idBarbeiro = ag.idBarbeiro
    JOIN usuario  ub ON ub.idUsuario = b.idUsuario
    JOIN servicos s  ON s.id         = a.idServico
    WHERE a.idAgendamento = ? AND a.idUsuario = ?
");
$stmt->bind_param("ii", $idAgendamento, $idUsuario);
$stmt->execute();
$ag = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Comprovante de agendamento da Barbearia Antônios. Consulte os dados do seu atendimento.">
    <meta name="theme-color" content="#f5f0e6">

    <title>Agendamento confirmado | Barbearia Antônios</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/formAction.css">
</head>

<body>
    <!-- script de menu ficando dentro do header dá possibilidade dele ser tratado no css depois, depois só tem que jogar pras outras páginas -->
    <header id="menu">
        <script src="script/menu.js" defer></script>
    </header>

    <main id="conteudo-principal">
        <?php if ($ag) { ?>
        <h1 id="titulo">Agendamento confirmado</h1>

        <!-- Comprovante -->
        <section class="comprovante" id="comprovante" aria-labelledby="titulo">
            <p><strong>Nome:</strong> <span><?= htmlspecialchars($ag["nome"]) ?></span></p>
            <p><strong>Telefone:</strong> <span><?= htmlspecialchars($ag["telefone"]) ?></span></p>
            <p><strong>E-mail:</strong> <span><?= htmlspecialchars($ag["email"]) ?></span></p>
            <p><strong>Data:</strong> <span><?= date("d/m/Y", strtotime($ag["data"])) ?></span></p>
            <p><strong>Horário:</strong> <span><?= substr($ag["hora"], 0, 5) ?></span></p>
            <p><strong>Barbeiro:</strong> <span><?= htmlspecialchars($ag["barbeiro"]) ?></span></p>
            <p><strong>Serviço:</strong> <span><?= htmlspecialchars($ag["servico"]) ?> (R$ <?= number_format($ag["preco"], 2, ",", ".") ?>)</span></p>
            <?php if ($ag["observacoes"] !== "") { ?>
                <p><strong>Observações:</strong> <span><?= htmlspecialchars($ag["observacoes"]) ?></span></p>
            <?php } ?>
        </section>
        <?php } else { ?>
        <h1 id="titulo">Nenhum agendamento encontrado</h1>
        <?php } ?>

        <!-- Ações do comprovante -->
        <nav class="acoes" aria-label="Ações do comprovante">
            <?php if ($ag) { ?>
            <button type="button" class="btn" onclick="window.print()">Imprimir comprovante</button>
            <?php } ?>

            <a href="form.php" class="btn">
                Novo agendamento
            </a>
        </nav>
    </main>

    <footer id="rodape"></footer>
    <script src="script/rodape.js"></script>
</body>

</html>
