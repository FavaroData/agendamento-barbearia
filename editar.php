<?php
// Formulário de edição, já preenchido com os dados do agendamento
include "verifica_login.php";
include "conexao.php";

$idAgendamento = isset($_GET["id"]) ? $_GET["id"] : 0;
$idUsuario = $_SESSION["usuario_id"];

// Busca o agendamento (só se for do usuário logado)
$stmt = $conn->prepare("
    SELECT a.idAgendamento, a.idServico, a.observacoes, ag.data, h.hora, ub.nome AS barbeiro
    FROM agendamento a
    JOIN horario  h  ON h.idHorario  = a.idHorario
    JOIN agenda   ag ON ag.idAgenda  = h.idAgenda
    JOIN barbeiro b  ON b.idBarbeiro = ag.idBarbeiro
    JOIN usuario  ub ON ub.idUsuario = b.idUsuario
    WHERE a.idAgendamento = ? AND a.idUsuario = ?
");
$stmt->bind_param("ii", $idAgendamento, $idUsuario);
$stmt->execute();
$ag = $stmt->get_result()->fetch_assoc();

if (!$ag) {
    header("Location: agendamentos.php?msg=erro");
    exit;
}

$servicos = $conn->query("SELECT id, nome, preco FROM servicos");
$barbeiros = $conn->query("SELECT b.idBarbeiro, u.nome FROM barbeiro b JOIN usuario u ON u.idUsuario = b.idUsuario");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="script/menu.js" defer></script>
    <script src="script/form.js" defer></script>
    <title>Editar agendamento | Barbearia Antônios</title>
</head>

<body>
    <header id="menu"></header>

    <main>
        <div class="agendamento">
            <h1>Editar agendamento</h1>
            <p>
                Horário atual: <strong><?= date("d/m/Y", strtotime($ag["data"])) ?> às <?= substr($ag["hora"], 0, 5) ?></strong>
                com <strong><?= htmlspecialchars($ag["barbeiro"]) ?></strong>
            </p>

            <form action="atualizar.php" method="POST">
                <input type="hidden" name="id" value="<?= $ag["idAgendamento"] ?>">

                <p>Serviço</p>
                <?php while ($s = $servicos->fetch_assoc()) { ?>
                    <input type="radio" name="servico" id="servico<?= $s["id"] ?>" value="<?= $s["id"] ?>"
                        <?= $s["id"] == $ag["idServico"] ? "checked" : "" ?> required>
                    <label for="servico<?= $s["id"] ?>"><?= $s["nome"] ?> (R$ <?= number_format($s["preco"], 2, ",", ".") ?>)</label>
                <?php } ?>

                <p><label for="agendamentoObservacoes">Observações</label></p>
                <textarea name="observacoes" id="agendamentoObservacoes" rows="4" cols="50"><?= htmlspecialchars($ag["observacoes"]) ?></textarea>

                <h2>Trocar horário (opcional)</h2>
                <p>Deixe em branco para manter o horário atual.</p>

                <p><label for="agendamentoBarbeiro">Barbeiro</label></p>
                <select name="barbeiro" id="agendamentoBarbeiro" class="input">
                    <option value="">Manter o atual</option>
                    <?php while ($b = $barbeiros->fetch_assoc()) { ?>
                        <option value="<?= $b["idBarbeiro"] ?>"><?= $b["nome"] ?></option>
                    <?php } ?>
                </select>

                <p><label for="agendamentoData">Nova data</label></p>
                <select name="data" id="agendamentoData" class="input">
                    <option value="">Selecione uma data</option>
                </select>

                <p><label for="agendamentoHorario">Novo horário</label></p>
                <select name="horario" id="agendamentoHorario" class="input">
                    <option value="">Selecione um horário</option>
                </select>

                <button type="submit">Salvar alterações</button>
            </form>

            <p><a href="agendamentos.php">Voltar para meus agendamentos</a></p>
        </div>
    </main>
    <footer id="rodape"></footer>
    <script src="script/rodape.js"></script>
</body>

</html>
