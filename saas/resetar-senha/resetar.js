const form_reset = document.querySelector("#reset-form");

        if (form_reset) {
            form_reset.addEventListener("submit", async (e) => {
                // 1. IMPEDE a submissão tradicional para usar o AJAX/Fetch
                e.preventDefault();

                // 2. Cria o pop-up de Loading do SweetAlert
                Swal.fire({
                    title: "Enviando email...",
                    text: "Aguarde enquanto processamos sua solicitação e enviamos o email de redefinição.",
                    icon: "info",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Exibe o spinner de carregamento
                    },
                });

                // 3. Captura os dados do formulário
                const dadosForm = new FormData(form_reset);

                try {
                    // 4. Envia os dados para o script PHP
                    const resposta = await fetch(form_reset.action, {
                        method: "POST",
                        body: dadosForm,
                    });

                    // 5. Espera a resposta JSON do PHP
                    const dados = await resposta.json();
                    
                    Swal.close(); // Fecha o SweetAlert de Loading
                    
                    if (dados.status === true) {
                        // Sucesso: Mostra a mensagem e redireciona
                        Swal.fire({
                            title: "Sucesso!",
                            text: dados.msg,
                            icon: "success",
                            confirmButtonColor: "#28a745",
                        }).then(() => {
                            window.location.href = dados.redirect;
                        });
                    } else {
                        // Erro: Mostra a mensagem de erro
                        Swal.fire({
                            title: "Erro!",
                            text: dados.msg,
                            icon: "error",
                            confirmButtonColor: "#e74c3c",
                        });
                    }
                } catch (error) {
                    // Erro de rede ou JSON inválido
                    Swal.fire({
                        title: "Erro de Conexão!",
                        text: "Algo deu errado ao processar sua solicitação. Por favor, tente novamente.",
                        icon: "error",
                        confirmButtonColor: "#e74c3c",
                    });
                }
            });
        }