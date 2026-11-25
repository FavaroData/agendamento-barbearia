<?php
include "verifica_login.php";
include "conexao.php";

$servicos = $conn->query("SELECT id, nome, preco FROM servicos");
$barbeiros = $conn->query("SELECT b.idBarbeiro, u.nome FROM barbeiro b JOIN usuario u ON u.idUsuario = b.idUsuario");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2a1a12">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">

    <script src="script/menu.js" defer></script>
    <script src="script/form.js" defer></script>

    <title>Agendamento | Barbearia Antônios</title>
    <meta name="description" content="Agende seu horário na Barbearia Antônios. Escolha seu serviço, barbeiro, data e horário.">
</head>

<body>
    <header id="menu">
    </header>

    <main>
        <div id="agendamento" class="agendamento">
            <h1>Agende seu horário</h1>
            <p class="introducao">
                Escolha seu serviço, barbeiro e horário para ter uma experiência
                tranquila na Barbearia Antônios.
            </p>

            <?php if (isset($_GET["erro"])) { ?>
                <p class="erro">Não foi possível agendar: esse horário acabou de ser ocupado ou houve um problema. Escolha outro horário e tente novamente.</p>
            <?php } ?>

            <form id="agendamentoForm" action="salvar.php" method="POST">

                <p>Serviço Desejado</p>

                <?php while ($s = $servicos->fetch_assoc()) { ?>
                    <input type="radio" name="servico" id="servico<?= $s["id"] ?>" value="<?= $s["id"] ?>" required>
                    <label for="servico<?= $s["id"] ?>"><?= $s["nome"] ?> (R$ <?= number_format($s["preco"], 2, ",", ".") ?>)</label>
                <?php } ?>

                <p>
                    <label for="agendamentoBarbeiro">Barbeiro</label>
                </p>
                <select name="barbeiro" id="agendamentoBarbeiro" class="input required" required>
                    <option value="">Escolha seu barbeiro</option>
                    <?php while ($b = $barbeiros->fetch_assoc()) { ?>
                        <option value="<?= $b["idBarbeiro"] ?>"><?= $b["nome"] ?></option>
                    <?php } ?>
                </select>

                <p>
                    <label for="agendamentoObservacoes">Observações</label>
                </p>
                <textarea name="observacoes" id="agendamentoObservacoes" rows="4" cols="50"
                    placeholder="Digite suas observações aqui..."></textarea>

                <p>
                    <label for="agendamentoData">Data do Agendamento</label>
                </p>
                <select name="data" id="agendamentoData" class="input required" required>
                    <option value="">Selecione uma data</option>
                </select>

                <p>
                    <label for="agendamentoHorario">Horário Desejado</label>
                </p>
                <select name="horario" id="agendamentoHorario" class="input required" required>
                    <option value="">Selecione um horário</option>
                </select>

                <button type="submit">Agendar horário</button>
            </form>
        </div>
    </main>
    <footer id="rodape"></footer>
    <script src="script/rodape.js"></script>
</body>

</html>