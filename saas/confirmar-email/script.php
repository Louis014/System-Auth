<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../../database/conexao.php";
require "../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

header('Content-Type: application/json; charset=UTF-8');

$retorna = [
    'status' => false,
    'msg' => ''
];

$email = $_SESSION['user_email'] ?? '';

if (empty($email)) {
    $retorna['msg'] = "Sessão expirada. Realize o cadastro novamente.";
    echo json_encode($retorna);
    exit;
}

$d1 = $_POST['input1'] ?? '';
$d2 = $_POST['input2'] ?? '';
$d3 = $_POST['input3'] ?? '';
$d4 = $_POST['input4'] ?? '';

$token_completo = $d1 . $d2 . $d3 . $d4;

if (!preg_match('/^\d{4}$/', $token_completo)) {
    $retorna['msg'] = "Digite um código válido.";
    echo json_encode($retorna);
    exit;
}

/*
|--------------------------------------------------------------------------
| Busca cadastro pendente
|--------------------------------------------------------------------------
*/

$sql = $pdo->prepare("
    SELECT *
    FROM cadastros_pendentes
    WHERE email = ?
    LIMIT 1
");

$sql->execute([$email]);

$cadastro = $sql->fetch(PDO::FETCH_ASSOC);

if (!$cadastro) {
    $retorna['msg'] = "Cadastro pendente não encontrado.";
    echo json_encode($retorna);
    exit;
}

/*
|--------------------------------------------------------------------------
| Verifica expiração
|--------------------------------------------------------------------------
*/

if (strtotime($cadastro['expira_em']) < time()) {
    $retorna['msg'] = "O código expirou. Solicite um novo código.";
    echo json_encode($retorna);
    exit;
}

/*
|--------------------------------------------------------------------------
| Verifica token
|--------------------------------------------------------------------------
*/

if ($token_completo !== $cadastro['token']) {
    $retorna['msg'] = "Código incorreto.";
    echo json_encode($retorna);
    exit;
}

/*
|--------------------------------------------------------------------------
| Verifica se o usuário já existe
|--------------------------------------------------------------------------
*/

$sql = $pdo->prepare("
    SELECT id
    FROM usuarios
    WHERE email = ?
    LIMIT 1
");

$sql->execute([$cadastro['email']]);

if ($sql->fetch(PDO::FETCH_ASSOC)) {
    $retorna['msg'] = "Este e-mail já possui cadastro.";
    echo json_encode($retorna);
    exit;
}

/*
|--------------------------------------------------------------------------
| Cria usuário definitivo
|--------------------------------------------------------------------------
*/

$sql = $pdo->prepare("
    INSERT INTO usuarios
    (
        nome,
        email,
        senha_hash,
        telefone,
        cpf
    )
    VALUES (?, ?, ?, ?, ?)
");

$sql->execute([
    $cadastro['nome'],
    $cadastro['email'],
    $cadastro['senha_hash'],
    $cadastro['telefone'],
    $cadastro['cpf']
]);

/*
|--------------------------------------------------------------------------
| Envia e-mail de boas-vindas
|--------------------------------------------------------------------------
*/

$nome_completo = $cadastro['nome'];
$primeiro_nome = htmlspecialchars(
    explode(" ", $nome_completo)[0] ?? 'Cliente'
);

$htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao System Auth</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">

<div style="font-family: Arial, sans-serif;">

    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        style="background-color: transparent; margin: 0;"
    >
        <tr>
            <td></td>

            <td
                width="600"
                style="
                    max-width: 600px;
                    margin: 0 auto;
                "
            >

                <div
                    style="
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    "
                >

                    <table
                        width="100%"
                        cellpadding="0"
                        cellspacing="0"
                        style="
                            border-radius: 7px;
                            background-color: #ffffff;
                        "
                    >

                        <tr>

                            <td
                                style="
                                    color: #495057;
                                    padding: 30px;
                                    box-shadow: 0 3px 15px rgba(30,32,37,.06);
                                    border-radius: 7px;
                                "
                            >

                                <!-- Logo / Nome -->

                                <div
                                    style="
                                        text-align: center;
                                        margin-bottom: 25px;
                                    "
                                >

                                    <h1
                                        style="
                                            font-size: 28px;
                                            margin: 0;
                                            color: #08204e;
                                        "
                                    >
                                        System Auth
                                    </h1>

                                </div>

                                <!-- Título -->

                                <div
                                    style="
                                        text-align: center;
                                        margin-bottom: 10px;
                                    "
                                >

                                    <h4
                                        style="
                                            font-weight: 500;
                                            font-size: 20px;
                                            margin: 0;
                                        "
                                    >
                                        Cadastro confirmado! 🎉
                                    </h4>

                                </div>

                                <!-- Mensagem -->

                                <div
                                    style="
                                        color: #878a99;
                                        font-size: 15px;
                                        text-align: center;
                                        padding-bottom: 26px;
                                    "
                                >

                                    <p>
                                        Bem-vindo(a), {$primeiro_nome}! 👋
                                    </p>

                                    <p>
                                        Seu e-mail foi confirmado com sucesso
                                        e sua conta no <strong>System Auth</strong>
                                        já está ativa.
                                    </p>

                                    <p>
                                        Agora você já pode acessar sua conta
                                        utilizando seus dados de login.
                                    </p>

                                    <p>
                                        Obrigado por fazer parte do
                                        <strong>System Auth</strong>!
                                    </p>

                                </div>

                                <!-- Rodapé -->

                                <div
                                    style="
                                        color: #878a99;
                                        text-align: center;
                                        font-size: 14px;
                                    "
                                >

                                    <p style="margin-bottom: 10px;">
                                        Atenciosamente,
                                    </p>

                                    <p style="margin-bottom: 10px;">
                                        <strong>Equipe System Auth</strong>
                                    </p>

                                </div>

                            </td>

                        </tr>

                    </table>

                    <!-- Suporte -->

                    <div
                        style="
                            text-align: center;
                            margin: 25px auto 0;
                        "
                    >

                        <h4
                            style="
                                font-weight: 500;
                                font-size: 16px;
                                margin-bottom: 5px;
                            "
                        >
                            Precisa de ajuda?
                        </h4>

                        <p
                            style="
                                color: #878a99;
                                margin: 0;
                            "
                        >
                            Entre em contato com nosso suporte.
                        </p>

                        <p
                            style="
                                font-size: 12px;
                                color: #98a6ad;
                                margin: 15px 0 0;
                            "
                        >
                            &copy; 2026 System Auth.
                        </p>

                    </div>

                </div>

            </td>

        </tr>
    </table>

</div>

</body>
</html>
HTML;

$altBody = "Bem-vindo(a), {$nome_completo}!

Seu e-mail foi confirmado com sucesso e sua conta no System Auth já está ativa.

Agora você já pode acessar sua conta utilizando seus dados de login.

Obrigado por fazer parte do System Auth!

Atenciosamente,
Equipe System Auth";

try {

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = (int) $_ENV['SMTP_PORT'];

    $mail->CharSet = 'UTF-8';

    $mail->setLanguage(
        'pt',
        '../../vendor/phpmailer/phpmailer/language/'
    );

    $mail->setFrom(
        $_ENV['SMTP_FROM_EMAIL'],
        $_ENV['SMTP_FROM_NAME']
    );

    $mail->addAddress(
        $cadastro['email'],
        $nome_completo
    );

    $mail->isHTML(true);

    $mail->Subject = 'Bem-vindo ao System Auth! 🎉';

    $mail->Body = $htmlBody;

    $mail->AltBody = $altBody;

    $mail->send();

} catch (Exception $e) {

    // O cadastro já foi confirmado.
    // Apenas registramos o erro do e-mail.

    error_log(
        "Erro ao enviar e-mail de boas-vindas: " .
        $mail->ErrorInfo
    );
}

/*
|--------------------------------------------------------------------------
| Remove cadastro pendente
|--------------------------------------------------------------------------
*/

$sql = $pdo->prepare("
    DELETE FROM cadastros_pendentes
    WHERE id = ?
");

$sql->execute([$cadastro['id']]);

/*
|--------------------------------------------------------------------------
| Limpa sessão temporária
|--------------------------------------------------------------------------
*/

unset($_SESSION['user_email']);

/*
|--------------------------------------------------------------------------
| Resposta
|--------------------------------------------------------------------------
*/

$retorna = [
    'status' => true,
    'msg' => 'E-mail confirmado com sucesso!',
    'redirect' => '../login/'
];

echo json_encode($retorna);
exit;
?>