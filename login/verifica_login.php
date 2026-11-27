<?php

require_once __DIR__ . "/autenticacao.php";

if (!usuarioAutenticado()) {
    header("Location: login/login.php");
    exit;
}
