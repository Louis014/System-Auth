// Função que configura a submissão do formulário via AJAX
const setupFormSubmission = () => {
    // Seleciona o elemento do formulário pelo ID (definido no index.php)
    const form = document.querySelector("#cont-form"); 
    // Seleciona o botão de submit (usado para adicionar o listener)
    const submitButton = document.querySelector("#confirmacao-btn");

    if (!form || !submitButton) {
        // Se os elementos não forem encontrados, a função para
        return;
    }

    // Adiciona o listener de clique ao botão de submissão
    submitButton.addEventListener("click", async (e) => {
        // 1. Previne o envio padrão do formulário (evita a recarga de página e o erro de JSON)
        e.preventDefault();

        // 2. Executa a validação HTML5
        if (!form.checkValidity()) {
            // Adiciona a classe para exibir o feedback visual do Bootstrap
            form.classList.add('was-validated');
            return; // Interrompe se o formulário for inválido
        }

        const formData = new FormData(form);
        
        // 3. MOSTRA O SPINNER DE PROCESSAMENTO - ETAPA 1
        Swal.fire({
            title: "Processando Cadastro...",
            text: "Validando seus dados e preparando a sessão.",
            icon: "info",
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        try {
            // --- ETAPA 1: PROCESSAR DADOS E SALVAR NA SESSÃO (script.php) ---
            const regUrl = form.getAttribute('action') || 'script.php'; 
            let respostaReg = await fetch(regUrl, {
                method: "POST",
                body: formData, 
            });

            if (!respostaReg.ok) {
                 throw new Error(`Erro HTTP na Etapa 1: ${respostaReg.status}`);
            }

            const dadosReg = await respostaReg.json();

            // Verifica se a primeira etapa falhou (ex: campos obrigatórios)
            if (dadosReg.status !== true) {
                throw new Error(dadosReg.msg || "Erro na Etapa 1: Dados inválidos.");
            }
            
            // Sucesso na Etapa 1, altera o carregamento para a Etapa 2 (Envio de Email)
            Swal.update({
                title: "Enviando E-mail...",
                text: "Dados processados. Agora estamos enviando o código de confirmação. Aguarde."
            });

            // --- ETAPA 2: ENVIAR O E-MAIL (confirmar-email.php) ---
            // O endpoint confirmar-email.php usa as variáveis salvas na sessão pelo script.php
            const emailUrl = 'confirmar-email.php'; 
            let respostaEmail = await fetch(emailUrl, {
                method: "POST",
                // Não precisa de corpo, pois pega dados da sessão
            });
            
            if (!respostaEmail.ok) {
                 throw new Error(`Erro HTTP na Etapa 2: ${respostaEmail.status}`);
            }

            const dadosEmail = await respostaEmail.json();
            
            if (dadosEmail.status === true) {
                // SUCESSO FINAL: E-mail enviado. Redireciona.
                Swal.fire({
                    title: "E-mail Enviado!",
                    text: dadosEmail.msg,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => {
                    // Redireciona *somente se o e-mail foi enviado com sucesso*
                    window.location.href = '../confirmar-email/'; 
                });
            } else {
                // FALHA na Etapa 2 (Ex: PHPMailer não conseguiu enviar)
                throw new Error(dadosEmail.msg || "Erro na Etapa 2: Falha no envio do e-mail.");
            }

        } catch (error) {
            // TRATAMENTO DE ERRO GERAL (HTTP, JSON parse, ou throw personalizado)
            // Fecha o SweetAlert de carregamento e mostra a mensagem de erro
            const errorMsg = typeof error === 'string' ? error : (error.message || "Erro desconhecido. Verifique sua conexão e tente novamente.");

            Swal.fire({
                title: "Erro!",
                text: errorMsg,
                icon: "error",
                confirmButtonColor: "#e74c3c",
                confirmButtonText: "Fechar",
            });
            form.classList.remove('was-validated'); 
        }
    });
};

// Inicializa o manipulador de submissão ao carregar a janela
window.addEventListener('load', setupFormSubmission);
