<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../../database/conexao.php";

header('Content-Type: application/json');

$retorna = ['status' => false, 'msg' => ''];

// Coleta os dados
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$senha_pura = $_POST['verificarsenha'] ?? '';

// Validação
if (empty($nome) || empty($email) || empty($cpf) || empty($senha_pura)) {
    $retorna['msg'] = "Por favor, preencha todos os campos obrigatórios.";
    echo json_encode($retorna);
    exit;
}

// Verifica se o e-mail ou CPF já possui cadastro definitivo
$sql = $pdo->prepare("
    SELECT id
    FROM usuarios
    WHERE email = ? OR cpf = ?
    LIMIT 1
");

$sql->execute([
    $email,
    $cpf
]);

if ($sql->fetch(PDO::FETCH_ASSOC)) {
    $retorna['msg'] = "Este e-mail ou CPF já possui cadastro.";
    echo json_encode($retorna);
    exit;
}

// Gera o hash da senha utilizando BCRYPT
$senha_hash = password_hash($senha_pura, PASSWORD_BCRYPT);

// Gera token de 4 dígitos
$token = str_pad(
    random_int(0, 9999),
    4,
    '0',
    STR_PAD_LEFT
);

// Token válido por 30 minutos
$expira_em = date('Y-m-d H:i:s', time() + (30 * 60));

try {

    // Apaga cadastro pendente anterior com o mesmo e-mail ou CPF
    $sql = $pdo->prepare("
        DELETE FROM cadastros_pendentes
        WHERE email = ? OR cpf = ?
    ");

    $sql->execute([
        $email,
        $cpf
    ]);

    // Cria o novo cadastro pendente
    $sql = $pdo->prepare("
        INSERT INTO cadastros_pendentes
        (
            nome,
            email,
            senha_hash,
            telefone,
            cpf,
            token,
            expira_em
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $sql->execute([
        $nome,
        $email,
        $senha_hash,
        $telefone,
        $cpf,
        $token,
        $expira_em
    ]);

    // Guarda somente o e-mail na sessão
    $_SESSION['user_email'] = $email;

    /*
    Aqui você envia o $token por e-mail.
    */

    $retorna = [
        'status' => true,
        'msg' => 'Cadastro realizado. Enviamos um código para seu e-mail.',
        'redirect' => 'confirmar-email.php'
    ];

} catch (PDOException $e) {

    $retorna['msg'] = "Erro ao realizar o cadastro.";

}

echo json_encode($retorna);
exit;

?>