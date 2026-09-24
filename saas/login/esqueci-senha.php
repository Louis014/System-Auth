<?php

ob_start();

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

$email = $_POST['email'] ?? null;

if (!$email) {
    $retorna = [
        'status' => false,
        'msg' => 'Email não fornecido.'
    ];

    echo json_encode($retorna);
    exit;
}

$_SESSION['user_email'] = $email;

/*
|--------------------------------------------------------------------------
| Busca usuário
|--------------------------------------------------------------------------
*/

$sql = $pdo->prepare("
    SELECT nome, email, cpf
    FROM usuarios
    WHERE email = ?
    LIMIT 1
");

try {

    $sql->execute([$email]);

    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {

        $retorna = [
            'status' => false,
            'msg' => "Usuário com este email não foi encontrado."
        ];

        echo json_encode($retorna);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Dados do usuário
    |--------------------------------------------------------------------------
    */

    $nome_completo = $usuario['nome'];
    $email_usuario = $usuario['email'];
    $cpf = $usuario['cpf'];

    $primeiro_nome = htmlspecialchars(
        explode(" ", $nome_completo)[0] ?? 'Cliente'
    );

    /*
    |--------------------------------------------------------------------------
    | Gera senha temporária
    |--------------------------------------------------------------------------
    */

    $apenas_numeros_cpf = preg_replace('/[^0-9]/', '', $cpf);

    $oito_primeiros_digitos = substr(
        $apenas_numeros_cpf,
        0,
        8
    );

    $nova_senha_pura = '@Fox' . $oito_primeiros_digitos;

    /*
    |--------------------------------------------------------------------------
    | Cria hash da nova senha
    |--------------------------------------------------------------------------
    */

    $nova_senha_hash = password_hash(
        $nova_senha_pura,
        PASSWORD_BCRYPT
    );

    /*
    |--------------------------------------------------------------------------
    | Atualiza senha no banco
    |--------------------------------------------------------------------------
    */

    $sql = $pdo->prepare("
        UPDATE usuarios
        SET senha_hash = ?
        WHERE email = ?
    ");

    $sql->execute([
        $nova_senha_hash,
        $email_usuario
    ]);

    /*
    |--------------------------------------------------------------------------
    | Template do email
    |--------------------------------------------------------------------------
    */

    $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Senha Redefinida</title>
</head>

<body style="
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    padding: 20px;
">

<div style="
    width: 100%;
">

    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        style="
            background-color: transparent;
            margin: 0;
        "
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

                <div style="
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                ">

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

                            <td style="
                                color: #495057;
                                padding: 30px;
                                box-shadow: 0 3px 15px rgba(30,32,37,.06);
                                border-radius: 7px;
                            ">

                                <!-- Logo -->

                                <div style="
                                    text-align: center;
                                    margin-bottom: 25px;
                                ">

                                    <h1 style="
                                        font-size: 28px;
                                        margin: 0;
                                        color: #08204e;
                                    ">
                                        System Auth
                                    </h1>

                                </div>


                                <!-- Título -->

                                <div style="
                                    text-align: center;
                                    margin-bottom: 20px;
                                ">

                                    <h4 style="
                                        font-weight: 500;
                                        font-size: 20px;
                                        margin: 0;
                                    ">
                                        Senha redefinida com sucesso 🔐
                                    </h4>

                                </div>


                                <!-- Mensagem -->

                                <div style="
                                    color: #878a99;
                                    font-size: 15px;
                                    text-align: center;
                                    padding-bottom: 20px;
                                ">

                                    <p>
                                        Olá, {$primeiro_nome}! 👋
                                    </p>

                                    <p>
                                        Sua senha foi redefinida com sucesso.
                                    </p>

                                    <p>
                                        Utilize a senha temporária abaixo
                                        para acessar sua conta:
                                    </p>

                                </div>


                                <!-- Senha -->

                                <div style="
                                    text-align: center;
                                    margin: 20px 0 30px;
                                ">

                                    <div style="
                                        display: inline-block;
                                        background-color: #f1f1f1;
                                        border: 1px solid #dddddd;
                                        border-radius: 6px;
                                        padding: 15px 30px;
                                    ">

                                        <strong style="
                                            font-size: 22px;
                                            color: #08204e;
                                            letter-spacing: 1px;
                                        ">
                                            {$nova_senha_pura}
                                        </strong>

                                    </div>

                                </div>


                                <!-- Botão -->

                                <div style="
                                    text-align: center;
                                    padding-bottom: 25px;
                                ">

                                    <a
                                        href="{{LINK_LOGIN}}"
                                        style="
                                            box-sizing: border-box;
                                            color: #ffffff;
                                            text-decoration: none;
                                            font-size: 14px;
                                            font-weight: 500;
                                            background-color: #08204e;
                                            border-radius: 5px;
                                            padding: 10px 18px;
                                            display: inline-block;
                                        "
                                    >
                                        Acessar Minha Conta
                                    </a>

                                </div>


                                <!-- Próximos passos -->

                                <div style="
                                    color: #878a99;
                                    font-size: 14px;
                                ">

                                    <h5 style="
                                        margin-bottom: 10px;
                                        font-size: 15px;
                                        color: #08204e;
                                    ">
                                        🚨 Próxima etapa: altere sua senha
                                    </h5>

                                    <p>
                                        Por segurança, recomendamos que você
                                        altere essa senha temporária após
                                        acessar sua conta.
                                    </p>

                                    <ol style="
                                        padding-left: 20px;
                                    ">

                                        <li style="margin-bottom: 8px;">
                                            Faça login utilizando a senha
                                            temporária.
                                        </li>

                                        <li style="margin-bottom: 8px;">
                                            Acesse <strong>Meu Perfil</strong>.
                                        </li>

                                        <li style="margin-bottom: 8px;">
                                            Selecione
                                            <strong>Alterar Senha</strong>.
                                        </li>

                                        <li>
                                            Informe a senha temporária como
                                            senha atual e defina uma nova senha.
                                        </li>

                                    </ol>

                                </div>


                                <!-- Rodapé -->

                                <div style="
                                    color: #878a99;
                                    text-align: center;
                                    margin-top: 30px;
                                ">

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

                    <div style="
                        text-align: center;
                        margin: 25px auto 0;
                    ">

                        <h4 style="
                            font-weight: 500;
                            font-size: 16px;
                            margin-bottom: 5px;
                        ">
                            Precisa de ajuda?
                        </h4>

                        <p style="
                            color: #878a99;
                            margin: 0;
                        ">
                            Entre em contato com nosso suporte.
                        </p>

                        <p style="
                            font-size: 12px;
                            color: #98a6ad;
                            margin: 15px 0 0;
                        ">
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


    /*
    |--------------------------------------------------------------------------
    | Texto alternativo
    |--------------------------------------------------------------------------
    */

    $altBody = "
Olá, {$nome_completo}!

Sua senha foi redefinida com sucesso.

Sua nova senha temporária é:

{$nova_senha_pura}

Acesse sua conta utilizando essa senha e altere-a posteriormente em Meu Perfil > Alterar Senha.

Atenciosamente,
Equipe System Auth
";


    /*
    |--------------------------------------------------------------------------
    | Envio do email
    |--------------------------------------------------------------------------
    */

    $mail = new PHPMailer(true);

    try {

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
            $email_usuario,
            $nome_completo
        );

        $mail->isHTML(true);

        $mail->Subject = 'Senha redefinida | System Auth';

        $mail->Body = $htmlBody;

        $mail->AltBody = $altBody;

        $mail->send();

    } catch (Exception $e) {

        error_log(
            'Erro ao enviar email de senha resetada: ' .
            $mail->ErrorInfo
        );

        $retorna = [
            'status' => false,
            'msg' => 'A senha foi atualizada, mas não foi possível enviar o email. Entre em contato com o suporte.'
        ];

        echo json_encode($retorna);
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Sucesso
    |--------------------------------------------------------------------------
    */

    $retorna = [
        'status' => true,
        'msg' => 'Sua senha foi redefinida! Verifique seu email para consultar a nova senha.',
        'redirect' => '../../saas/senha-resetada/'
    ];

} catch (PDOException $e) {

    $retorna = [
        'status' => false,
        'msg' => 'Erro ao processar a redefinição da senha.'
    ];
}

echo json_encode($retorna);

exit;
?>