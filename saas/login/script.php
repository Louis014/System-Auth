<?php
// 1. OBRIGATÓRIO: Iniciar a sessão no topo do arquivo.
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require "../../database/conexao.php";

$email_input = trim($_POST['email'] ?? '');
// ATENÇÃO: Se o input se chama 'pass' no HTML, o correto é: $senha_input = $_POST['pass'] ?? '';
// Se você mudou para 'senha' no HTML, mantenha 'senha' aqui:
$senha_input = $_POST['senha'] ?? ''; 
$retorna = []; // Inicializa a variável de retorno

$sql = "SELECT senha_hash, ativo FROM usuarios WHERE email = :email"; 

$stmt = $pdo->prepare($sql);
    
// Liga o parâmetro (parameter binding)
$stmt->execute(['email' => $email_input]);
    
// Obtém o resultado
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


// 4. VERIFICAÇÃO DA AUTENTICAÇÃO
    
// A. Verifica se o usuário existe
if ($usuario) {
    
    // B. VERIFICAÇÃO SEGURA DA SENHA
    if (password_verify($senha_input, $usuario['senha_hash'])) {
        
        // C. Verifica se a conta está ativa
        if ($usuario['ativo'] == 1) {
            // SUCESSO!
            
            // 5. REGISTRAR SESSÃO E CONSTRUIR RESPOSTA JSON
            $_SESSION['logado'] = true;
            
            // 6. ENVIAR RESPOSTA E SAIR (OBRIGATÓRIO EM SUCESSO AJAX)
            $retorna = [
                'status' => true,
                'msg' => "Login realizado com sucesso!", // Mensagem opcional de sucesso
            ];
            
        } else {
            // Usuário inativo
            $retorna = ['status' => false, 'msg' => "Sua conta está desativada!."];
        }
        
    } else {
        // Falha na senha
        $retorna = ['status' => false, 'msg' => "E-mail ou senha incorretos."];
    }
    
} else {
    // Usuário não encontrado
    $retorna = ['status' => false, 'msg' => "E-mail ou senha incorretos."];
}

// Resposta de Falha:
// Se o script chegou aqui, significa que $retorna contém uma mensagem de falha (inativo, senha errada, usuário não existe).

header('Content-Type: application/json');
echo json_encode($retorna);
exit();

// REMOVA O SEGUNDO BLOCO PHP DUPLICADO ABAIXO!
// Você não precisa de mais nada aqui.
?>