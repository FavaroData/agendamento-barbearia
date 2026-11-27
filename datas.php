<?php
// Devolve, em JSON, as datas em que o barbeiro escolhido atende
include __DIR__ . "/login/verifica_login.php";
include "conexao.php";

$idBarbeiro = isset($_GET["barbeiro"]) ? $_GET["barbeiro"] : 0;

$stmt = $conn->prepare("SELECT idAgenda, data FROM agenda WHERE idBarbeiro = ? AND disponivel = TRUE ORDER BY data");
$stmt->bind_param("i", $idBarbeiro);
$stmt->execute();
$resultado = $stmt->get_result();

$datas = [];
while ($linha = $resultado->fetch_assoc()) {
    $datas[] = $linha;
}

header("Content-Type: application/json");
echo json_encode($datas);
