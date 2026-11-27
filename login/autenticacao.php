<?php

function usuarioAutenticado(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION["usuario_id"]);
}
