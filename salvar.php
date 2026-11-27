<?php
// INSERT: grava um novo agendamento para o usuário logado
include __DIR__ . "/login/verifica_login.php";
include "conexao.php";

// Só aceita envio pelo formulário
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form.php");
    exit;
}

$idUsuario   = $_SESSION["usuario_id"];   // quem está logado
$idServico   = $_POST["servico"];
$idHorario   = $_POST["horario"];
$observacoes = $_POST["observacoes"];

// Transaction: ou as duas operações acontecem, ou nenhuma acontece
$conn->begin_transaction();

try {
    // 1. Ocupa o horário, mas só se ele ainda estiver livre
    $stmt = $conn->prepare("UPDATE horario SET disponivel = FALSE WHERE idHorario = ? AND disponivel = TRUE");
    $stmt->bind_param("i", $idHorario);
    $stmt->execute();

    // Se nenhuma linha mudou, alguém ocupou esse horário antes
    if ($stmt->affected_rows !== 1) {
        $conn->rollback();
        header("Location: form.php?erro=1");
        exit;
    }

    // 2. Grava o agendamento
    $stmt = $conn->prepare("INSERT INTO agendamento (idUsuario, idHorario, idServico, observacoes) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $idUsuario, $idHorario, $idServico, $observacoes);
    $stmt->execute();

    $idAgendamento = $conn->insert_id;   // id gerado pelo AUTO_INCREMENT

    $conn->commit();
    header("Location: formAction.php?id=" . $idAgendamento);
    exit;
} catch (mysqli_sql_exception $e) {
    // Qualquer erro desfaz tudo
    $conn->rollback();
    header("Location: form.php?erro=1");
    exit;
}
