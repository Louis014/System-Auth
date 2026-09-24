const form_entrar = document.querySelector("#cont-form");

if (form_entrar) {
  form_entrar.addEventListener("submit", async (e) => {
    e.preventDefault();

    // ✅ CORREÇÃO: Criar um objeto FormData a partir do formulário
    const dadosForm = new FormData(form_entrar);

    Swal.fire({
      title: "Processando...",
      text: "Aguarde enquanto processamos sua solicitação.",
      icon: "info",
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const resposta = await fetch("script.php", {
        method: "POST",
        body: dadosForm, // Agora 'dadosForm' está definido!
      });

      const dados = await resposta.json();

      if (dados.status === true) {
            // ⭐ NOVO CÓDIGO PARA SUCESSO E REDIRECIONAMENTO COM TIMER
          Swal.fire({
            text: "Email confirmado com sucesso! Agurde para ser redirecionado(a) para o login.", // Usando uma mensagem fixa de sucesso para o pop-up
            icon: "success",
             title: "Sucesso!",
             showConfirmButton: false, // Remove o botão de confirmação
             timer: 4000, // Define o tempo de exibição em milissegundos (4 segundos)
          }).then((result) => {
                // Esta função é chamada quando o timer termina (ou o pop-up é fechado)
                if (result.dismiss === Swal.DismissReason.timer || result.isConfirmed) {
                    // O SweetAlert2 usa 'result.dismiss === Swal.DismissReason.timer' quando o timer acaba
                    // O 'result.isConfirmed' é caso você queira permitir o clique
                    window.location.href = "../login/"; 
                }
             });

      } else {
        Swal.fire({
          text: dados.msg,
          icon: "error",
          confirmButtonColor: "#e74c3c",
          confirmButtonText: "Fechar",
        });
      }
    } catch (error) {
      Swal.fire({
        text: "Algo deu errado ao processar sua solicitação. Por favor, tente novamente em alguns instantes.",
        icon: "error",
        confirmButtonColor: "#e74c3c",
        confirmButtonText: "Fechar",
      });
    }
  });
}

const btnReenviar = document.getElementById('btnReenviar');

if (btnReenviar) {

    btnReenviar.addEventListener('click', async function (e) {

        e.preventDefault();

        const botao = this;

        botao.disabled = true;

        Swal.fire({
            title: 'Enviando novo código...',
            text: 'Aguarde enquanto geramos um novo token.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {

            const resposta = await fetch('reenviar-token.php', {
                method: 'POST'
            });

            const dados = await resposta.json();

            if (dados.status === true) {

                Swal.fire({
                    icon: 'success',
                    title: 'Novo código enviado!',
                    text: 'Verifique seu e-mail para continuar.',
                    confirmButtonText: 'OK'
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Não foi possível reenviar',
                    text: dados.msg,
                    confirmButtonText: 'Fechar'
                });
            }

        } catch (erro) {

            console.error(erro);

            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Não foi possível processar o reenvio. Tente novamente.',
                confirmButtonText: 'Fechar'
            });

        } finally {

            botao.disabled = false;

        }

    });

}
