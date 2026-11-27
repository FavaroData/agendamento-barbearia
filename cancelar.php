<?php
// DELETE: cancela um agendamento do usuário logado e libera o horário
include __DIR__ . "/login/verifica_login.php";
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: agendamentos.php");
    exit;
}

$idAgendamento = $_POST["id"];
$idUsuario = $_SESSION["usuario_id"];

$conn->begin_transaction();

try {
    // 1. Descobre qual horário o agendamento ocupa (e confere se é do usuário)
    $stmt = $conn->prepare("SELECT idHorario FROM agendamento WHERE idAgendamento = ? AND idUsuario = ?");
    $stmt->bind_param("ii", $idAgendamento, $idUsuario);
    $stmt->execute();
    $agendamento = $stmt->get_result()->fetch_assoc();

    if (!$agendamento) {
        $conn->rollback();
        header("Location: agendamentos.php?msg=erro");
        exit;
    }

    // 2. Apaga o agendamento (com WHERE duplo: só o escolhido, e só se for do usuário)
    $stmt = $conn->prepare("DELETE FROM agendamento WHERE idAgendamento = ? AND idUsuario = ?");
    $stmt->bind_param("ii", $idAgendamento, $idUsuario);
    $stmt->execute();

    // 3. Libera o horário para outras pessoas
    $stmt = $conn->prepare("UPDATE horario SET disponivel = TRUE WHERE idHorario = ?");
    $stmt->bind_param("i", $agendamento["idHorario"]);
    $stmt->execute();

    $conn->commit();
    header("Location: agendamentos.php?msg=cancelado");
    exit;
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    header("Location: agendamentos.php?msg=erro");
    exit;
}
