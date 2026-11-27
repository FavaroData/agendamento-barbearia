<?php
// Devolve, em JSON, os horários livres de um dia da agenda
include __DIR__ . "/login/verifica_login.php";
include "conexao.php";

$idAgenda = isset($_GET["agenda"]) ? $_GET["agenda"] : 0;

$stmt = $conn->prepare("SELECT idHorario, TIME_FORMAT(hora, '%H:%i') AS hora FROM horario WHERE idAgenda = ? AND disponivel = TRUE ORDER BY hora");
$stmt->bind_param("i", $idAgenda);
$stmt->execute();
$resultado = $stmt->get_result();

$horarios = [];
while ($linha = $resultado->fetch_assoc()) {
    $horarios[] = $linha;
}

header("Content-Type: application/json");
echo json_encode($horarios);
