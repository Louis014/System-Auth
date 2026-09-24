<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {

    require "../../database/conexao.php";
    require "../../vendor/autoload.php";

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

} catch (Throwable $e) {

    echo json_encode([
        'status' => false,
        'msg' => 'Erro ao carregar o sistema: ' . $e->getMessage()
    ]);

    exit;
}

$retorna = [
    'status' => false,
    'msg' => 'Erro desconhecido ao tentar enviar o e-mail.'
];
// ==========================================
// DADOS DA SESSÃO
// ==========================================

$email = $_SESSION['user_email'] ?? null;

if (!$email) {

    $retorna['msg'] = 'Sessão de usuário não encontrada.';

    echo json_encode($retorna);
    exit;
}

// ==========================================
// BUSCA O CADASTRO PENDENTE NO BANCO
// ==========================================

$sql = $pdo->prepare("
    SELECT nome, email, token, expira_em
    FROM cadastros_pendentes
    WHERE email = ?
    LIMIT 1
");

$sql->execute([
    $email
]);

$cadastro = $sql->fetch(PDO::FETCH_ASSOC);

if (!$cadastro) {

    $retorna['msg'] = 'Cadastro pendente não encontrado.';

    echo json_encode($retorna);
    exit;
}

// ==========================================
// DADOS DO CADASTRO
// ==========================================

$email = $cadastro['email'];
$nome_completo = $cadastro['nome'];
$token = $cadastro['token'];

$primeiro_nome = htmlspecialchars(
    explode(" ", $nome_completo)[0] ?? 'Cliente'
);

// ==========================================
// TEMPLATE DO E-MAIL
// ==========================================

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

    <table
        class="body-wrap"
        style="box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;"
    >

        <tr>

            <td></td>

            <td
                class="container"
                width="600"
                style="box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            >

                <div
                    class="content"
                    style="box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;"
                >

                    <table
                        class="main"
                        width="100%"
                        cellpadding="0"
                        cellspacing="0"
                        style="box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
                    >

                        <tr>

                            <td
                                class="content-wrap"
                                style="box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); border-radius: 7px; background-color: #fff;"
                            >

                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                >

                                    <tr>

                                        <td
                                            style="font-size: 14px; padding: 0 0 20px;"
                                        >

                                            <div
                                                style="text-align: center; margin-bottom: 15px;"
                                            >

                                                <h1
                                                    style="font-size: 28px; margin: 0; color: #08204e;"
                                                >
                                                    System Auth
                                                </h1>

                                            </div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td
                                            style="font-size: 24px; padding: 0 0 10px; text-align: center;"
                                        >

                                            <h4
                                                style="font-weight: 500; font-size: 20px; margin: 0;"
                                            >
                                                Confirme seu email!
                                            </h4>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td
                                            style="color: #878a99; font-size: 15px; padding: 0 0 26px; text-align: center;"
                                        >

                                            Olá {$primeiro_nome}! 👋

                                            <p style="margin-bottom: 13px;">

                                                Para confirmar seu e-mail e concluir seu cadastro, use o código abaixo.

                                            </p>

                                            <div style="text-align: center;">

                                                <h1
                                                    style="font-size: 36px; color: #333333; margin: 15px 0;"
                                                >
                                                    {$token}
                                                </h1>

                                                <p style="margin-bottom: 13px;">

                                                    Esse código é válido por 30 minutos.

                                                </p>

                                                <p style="margin-bottom: 13px;">

                                                    Se você não solicitou este código, pode ignorar esta mensagem.

                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td
                                            style="color: #878a99; text-align: center; font-size: 14px; padding-top: 5px;"
                                        >

                                            <p style="margin-bottom: 10px;">
                                                Atenciosamente,
                                            </p>

                                            <p style="margin-bottom: 10px;">
                                                System Auth
                                            </p>

                                        </td>

                                    </tr>

                                </table>

                            </td>

                        </tr>

                    </table>

                    <div
                        style="text-align: center; margin: 25px auto 0;"
                    >

                        <p
                            style="font-size: 12px; color: #98a6ad; margin: 15px 0 0;"
                        >

                            &copy;

                            <script>
                                document.write(new Date().getFullYear())
                            </script>

                            System Auth. Feito por Luis Filipe <a href="https://github.com/Louis014" target="_blank"><i class="bx bl-bx bxl-github"></i></a> <a href="https://instagram.com/luis._filip" target="_blank"><i class="bx bl-bx bxl-instagram-alt"></i></a>

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

// ==========================================
// CORPO ALTERNATIVO
// ==========================================

$altBody = "
Olá {$primeiro_nome},

Para confirmar seu e-mail e concluir seu cadastro, use o código abaixo:

{$token}

Esse código é válido por 30 minutos.

Se você não solicitou este código, pode ignorar esta mensagem.

Atenciosamente,
System Auth
";

// ==========================================
// PHPMailer
// ==========================================

$mail = new PHPMailer(true);

try {

    // SMTP

    $mail->isSMTP();

    $mail->Host = $_ENV['SMTP_HOST'];

    $mail->SMTPAuth = true;

    $mail->Username = $_ENV['SMTP_USERNAME'];

    $mail->Password = $_ENV['SMTP_PASSWORD'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    $mail->Port = $_ENV['SMTP_PORT'];

    $mail->CharSet = 'UTF-8';

    $mail->setLanguage(
        'pt',
        '../../vendor/phpmailer/phpmailer/language/'
    );

    // ==========================================
    // REMETENTE E DESTINATÁRIO
    // ==========================================

    $mail->setFrom(
    $_ENV['SMTP_FROM_EMAIL'],
    $_ENV['SMTP_FROM_NAME']
);

    $mail->addAddress(
        $email,
        $nome_completo
    );

    // ==========================================
    // CONTEÚDO
    // ==========================================

    $mail->isHTML(true);

    $mail->Subject =
        'Confirmação de Cadastro System Auth | Seu Código: ' . $token;

    $mail->Body = $htmlBody;

    $mail->AltBody = $altBody;

    // ==========================================
    // ENVIA
    // ==========================================

    $mail->send();

    $retorna = [
        'status' => true,
        'msg' => 'E-mail de confirmação enviado com sucesso!'
    ];

} catch (Exception $e) {

    $retorna['msg'] =
        "Falha ao enviar e-mail. Motivo: {$mail->ErrorInfo}";

}

echo json_encode($retorna);
exit;

?>
