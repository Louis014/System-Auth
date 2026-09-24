<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

try {
    require "../../database/conexao.php";
    require "../../vendor/autoload.php";

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
} catch (Throwable $e) {
    $retorna['msg'] = 'Erro ao carregar o sistema: ' . $e->getMessage();
    echo json_encode($retorna);
    exit;
}

try {
    // Verifica se existe cadastro definitivo
    $sql = $pdo->prepare("
        SELECT id
        FROM usuarios
        WHERE email = ?
        LIMIT 1
    ");
    $sql->execute([$email]);

    if ($sql->fetch(PDO::FETCH_ASSOC)) {
        $retorna['msg'] = "Este e-mail já possui cadastro.";
        echo json_encode($retorna);
        exit;
    }

    // Busca o cadastro pendente
    $sql = $pdo->prepare("
        SELECT nome, email
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

    $nome_completo = $cadastro['nome'];
    $primeiro_nome = htmlspecialchars(
        explode(" ", $nome_completo)[0] ?? 'Cliente'
    );

    // Gera novo token de 4 dígitos
    $novo_token = str_pad(
        (string) random_int(0, 9999),
        4,
        '0',
        STR_PAD_LEFT
    );

    // Nova validade de 30 minutos
    $nova_expiracao = date(
        'Y-m-d H:i:s',
        time() + (30 * 60)
    );

    // Atualiza o token existente no banco de dados
    $sql = $pdo->prepare("
        UPDATE cadastros_pendentes
        SET token = ?, expira_em = ?
        WHERE email = ?
    ");
    $sql->execute([
        $novo_token,
        $nova_expiracao,
        $email
    ]);

    // Template HTML do e-mail
    $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Email</title>
</head>
<body style="font-family: 'Roboto', sans-serif; background-color: #f7f7f7; padding: 20px;">
<div class="col-12" style="font-family: 'Roboto', sans-serif;">
    <table class="body-wrap" style="box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
        <tr>
            <td></td>
            <td class="container" width="600" style="box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">
                <div class="content" style="box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                        <tr>
                            <td class="content-wrap" style="box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); border-radius: 7px; background-color: #fff;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="font-size: 14px; padding: 0 0 20px;">
                                            <div style="text-align: center; margin-bottom: 15px;">
                                                <h1 style="font-size: 28px; margin: 0; color: #08204e;">
                                                    System Auth
                                                </h1>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 24px; padding: 0 0 10px; text-align: center;">
                                            <h4 style="font-weight: 500; font-size: 20px; margin: 0;">
                                                Seu novo código de confirmação!
                                            </h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #878a99; font-size: 15px; padding: 0 0 26px; text-align: center;">
                                            Olá {$primeiro_nome}! 👋
                                            <p style="margin-bottom: 13px;">
                                                Você solicitou o reenvio do código de confirmação. Use o novo código abaixo para concluir seu cadastro:
                                            </p>
                                            <div style="text-align: center;">
                                                <h1 style="font-size: 36px; color: #333333; margin: 15px 0;">
                                                    {$novo_token}
                                                </h1>
                                                <p style="margin-bottom: 13px;">
                                                    Esse código é válido por 30 minutos.
                                                </p>
                                                <p style="margin-bottom: 13px;">
                                                    Se você não solicitou este código, pode ignorar esta mensagem com segurança.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #878a99; text-align: center; font-size: 14px; padding-top: 5px;">
                                            <p style="margin-bottom: 10px;">
                                                Atenciosamente,
                                            </p>
                                            <p style="margin-bottom: 10px;">
                                                <strong>System Auth</strong>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center; margin: 25px auto 0;">
                        <p style="font-size: 12px; color: #98a6ad; margin: 15px 0 0;">
                            &copy; System Auth.
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

    $altBody = "
Olá {$primeiro_nome},

Você solicitou o reenvio do código de confirmação:

{$novo_token}

Esse código é válido por 30 minutos.

Se você não solicitou este código, pode ignorar esta mensagem.

Atenciosamente,
System Auth
";

    // Envia novo e-mail com PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = $_ENV['SMTP_PORT'];
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('pt', '../../vendor/phpmailer/phpmailer/language/');

    $mail->setFrom(
        $_ENV['SMTP_FROM_EMAIL'],
        $_ENV['SMTP_FROM_NAME']
    );

    $mail->addAddress(
        $email,
        $nome_completo
    );

    $mail->isHTML(true);
    $mail->Subject = 'Confirmação de Cadastro System Auth | Novo Código: ' . $novo_token;
    $mail->Body = $htmlBody;
    $mail->AltBody = $altBody;

    $mail->send();

    $retorna = [
        'status' => true,
        'msg' => 'Um novo código foi enviado para seu e-mail.'
    ];

} catch (Exception $e) {
    $retorna['msg'] = "Falha ao enviar e-mail. Motivo: {$mail->ErrorInfo}";
} catch (Throwable $e) {
    $retorna['msg'] = "Erro interno: " . $e->getMessage();
}

echo json_encode($retorna);
exit;
