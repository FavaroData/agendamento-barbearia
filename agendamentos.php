<?php
// SELECT: lista os agendamentos do usuário logado
include "verifica_login.php";
include "conexao.php";

$idUsuario = $_SESSION["usuario_id"];

$stmt = $conn->prepare("
    SELECT a.idAgendamento, ag.data, h.hora, ub.nome AS barbeiro, s.nome AS servico, s.preco
    FROM agendamento a
    JOIN horario  h  ON h.idHorario  = a.idHorario
    JOIN agenda   ag ON ag.idAgenda  = h.idAgenda
    JOIN barbeiro b  ON b.idBarbeiro = ag.idBarbeiro
    JOIN usuario  ub ON ub.idUsuario = b.idUsuario
    JOIN servicos s  ON s.id         = a.idServico
    WHERE a.idUsuario = ?
    ORDER BY ag.data, h.hora
");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$agendamentos = $stmt->get_result();

// Mensagens de resultado vindas do cancelar.php e do atualizar.php
$mensagens = [
    "cancelado"  => "Agendamento cancelado com sucesso.",
    "atualizado" => "Agendamento atualizado com sucesso.",
    "erro"       => "Não foi possível concluir a operação. Tente novamente."
];
$msg = isset($_GET["msg"]) && isset($mensagens[$_GET["msg"]]) ? $_GET["msg"] : "";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="script/menu.js" defer></script>
    <title>Meus agendamentos | Barbearia Antônios</title>
</head>

<body>
    <header id="menu"></header>

    <main>
        <h1>Meus agendamentos</h1>

        <?php if ($msg !== "") { ?>
            <p class="<?= $msg === "erro" ? "erro" : "sucesso" ?>"><?= $mensagens[$msg] ?></p>
        <?php } ?>

        <?php if ($agendamentos->num_rows === 0) { ?>
            <p>Você ainda não tem agendamentos.</p>
        <?php } else { ?>
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Barbeiro</th>
                        <th>Serviço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($a = $agendamentos->fetch_assoc()) { ?>
                        <tr>
                            <td><?= date("d/m/Y", strtotime($a["data"])) ?></td>
                            <td><?= substr($a["hora"], 0, 5) ?></td>
                            <td><?= htmlspecialchars($a["barbeiro"]) ?></td>
                            <td><?= htmlspecialchars($a["servico"]) ?> (R$ <?= number_format($a["preco"], 2, ",", ".") ?>)</td>
                            <td class="tabela-acoes">
                                <a href="formAction.php?id=<?= $a["idAgendamento"] ?>">Ver</a>
                                <a href="editar.php?id=<?= $a["idAgendamento"] ?>">Editar</a>
                                <form action="cancelar.php" method="POST" onsubmit="return confirm('Cancelar este agendamento?')">
                                    <input type="hidden" name="id" value="<?= $a["idAgendamento"] ?>">
                                    <button type="submit" class="link-cancelar">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>

        <p><a href="form.php" class="btn">Novo agendamento</a></p>
    </main>
    <footer id="rodape"></footer>
    <script src="script/rodape.js"></script>
</body>

</html>
