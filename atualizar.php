<?php
// UPDATE: salva as alterações de um agendamento do usuário logado
include "verifica_login.php";
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: agendamentos.php");
    exit;
}

$idAgendamento = $_POST["id"];
$idUsuario     = $_SESSION["usuario_id"];
$idServico     = $_POST["servico"];
$observacoes   = $_POST["observacoes"];
$novoHorario   = $_POST["horario"];   // vazio = manter o horário atual

$conn->begin_transaction();

try {
    // 1. Busca o horário atual (e confere se o agendamento é do usuário)
    $stmt = $conn->prepare("SELECT idHorario FROM agendamento WHERE idAgendamento = ? AND idUsuario = ?");
    $stmt->bind_param("ii", $idAgendamento, $idUsuario);
    $stmt->execute();
    $agendamento = $stmt->get_result()->fetch_assoc();

    if (!$agendamento) {
        $conn->rollback();
        header("Location: agendamentos.php?msg=erro");
        exit;
    }

    $idHorario = $agendamento["idHorario"];

    // 2. Se escolheu um horário novo: ocupa o novo e libera o antigo
    if ($novoHorario !== "" && $novoHorario != $idHorario) {
        $stmt = $conn->prepare("UPDATE horario SET disponivel = FALSE WHERE idHorario = ? AND disponivel = TRUE");
        $stmt->bind_param("i", $novoHorario);
        $stmt->execute();

        if ($stmt->affected_rows !== 1) {   // alguém pegou o horário antes
            $conn->rollback();
            header("Location: agendamentos.php?msg=erro");
            exit;
        }

        $stmt = $conn->prepare("UPDATE horario SET disponivel = TRUE WHERE idHorario = ?");
        $stmt->bind_param("i", $idHorario);
        $stmt->execute();

        $idHorario = $novoHorario;
    }

    // 3. Atualiza o agendamento
    $stmt = $conn->prepare("UPDATE agendamento SET idServico = ?, observacoes = ?, idHorario = ? WHERE idAgendamento = ? AND idUsuario = ?");
    $stmt->bind_param("isiii", $idServico, $observacoes, $idHorario, $idAgendamento, $idUsuario);
    $stmt->execute();

    $conn->commit();
    header("Location: agendamentos.php?msg=atualizado");
    exit;
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    header("Location: agendamentos.php?msg=erro");
    exit;
}
