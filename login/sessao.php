<?php

require_once __DIR__ . "/autenticacao.php";

header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store");

echo json_encode(["autenticado" => usuarioAutenticado()]);
