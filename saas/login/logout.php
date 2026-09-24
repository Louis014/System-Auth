<?php
// Inicia a sessão (se ainda não estiver ativa) para poder destruí-la
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis de sessão
$_SESSION = [];

// Se o PHP estiver usando cookies de sessão, apaga o cookie também
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroi a sessão de fato
session_destroy();

header('Content-Type: application/json');
echo json_encode(['status' => true, 'msg' => 'Sessão encerrada.']);
exit;