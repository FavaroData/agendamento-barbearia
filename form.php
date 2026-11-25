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

            <form id="agendamentoForm" action="formAction.php" method="GET">
                <p>
                    <label for="agendamentoNome">Nome Completo</label>
                </p>
                <input type="text" name="nome" id="agendamentoNome" class="input required"
                    oninput="validarNome()" placeholder="Antonio Junior"
                    autocomplete="name" required>
                <span class="span-required">Digite o nome completo</span>
                <span class="span-required-null">Campo vazio, preencha com um nome válido!</span>

                <p>
                    <label for="agendamentoTelefone">Telefone</label>
                </p>
                <input type="text" name="telefone" id="agendamentoTelefone" class="input required"
                    oninput="validarTelefone()" placeholder="41999999999"
                    pattern="(\(\d{2}\)\s?)?\d{4,5}-?\d{4}"
                    autocomplete="tel" required>
                <span class="span-required">Digite um número de telefone válido</span>
                <span class="span-required-null">Campo vazio, preencha com um telefone válido!</span>

                <p>
                    <label for="agendamentoEmail">Email</label>
                </p>
                <input type="email" name="email" id="agendamentoEmail" class="input required"
                    oninput="validarEmail()" placeholder="seuemail@email.com"
                    autocomplete="email" required>
                <span class="span-required">Digite um email válido</span>
                <span class="span-required-null">Campo vazio, preencha com um email válido!</span>

                <p>Serviço Desejado</p>

                <?php while ($s = $servicos->fetch_assoc()) { ?>
                    <input type="radio" name="servico" id="servico<?= $s["id"] ?>" value="<?= $s["id"] ?>" required>
                    <label for="servico<?= $s["id"] ?>"><?= $s["nome"] ?> (R$ <?= number_format($s["preco"], 2, ",", ".") ?>)</label>
                <?php } ?>

                <span class="span-required"> </span> <!-- Span para evitar o erro no for de leitura das classes span no form.js-->
                <span class="span-required-null">Campo vazio, selecione uma opção!</span>

                <p>
                    <label for="agendamentoBarbeiro">Barbeiro</label>
                </p>
                <select name="barbeiro" id="agendamentoBarbeiro" class="input required" required>
                    <option value="">Escolha seu barbeiro</option>
                    <?php while ($b = $barbeiros->fetch_assoc()) { ?>
                        <option value="<?= $b["idBarbeiro"] ?>"><?= $b["nome"] ?></option>
                    <?php } ?>
                </select>
                <span class="span-required"> </span> 
                <span class="span-required-null">Campo vazio, escolha um barbeiro!</span>

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
                <span class="span-required-null">Campo vazio, selecione uma data!</span>

                <p>
                    <label for="agendamentoHorario">Horário Desejado</label>
                </p>
                <select name="horario" id="agendamentoHorario" class="input required" required>
                    <option value="">Selecione um horário</option>
                </select>
                <span class="span-required"> </span>
                <span class="span-required-null">Campo vazio, preencha com um horário para agendamento!</span>

                <button type="submit">Agendar horário</button>
            </form>
        </div>
    </main>
    <footer id="rodape"></footer>
    <script src="script/rodape.js"></script>
</body>

</html>