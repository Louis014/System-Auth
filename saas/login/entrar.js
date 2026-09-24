const form_entrar = document.querySelector("#cont-form");

if (form_entrar) {
  form_entrar.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(form_entrar);

    const email = dadosForm.get("email");
    const senha = dadosForm.get("senha");

    if (!email || !senha) {
      Swal.fire({
        text: "Preencha todos os campos obrigatórios.",
        icon: "warning",
        confirmButtonColor: "#e74c3c",
        confirmButtonText: "Fechar",
      });
      return;
    }

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
        body: dadosForm,
      });

      const dados = await resposta.json();
      if (dados.status === true) {
        Swal.fire({
          title: "Bem-vindo ao sistema!",
          icon: "success",
          confirmButtonColor: "#28a745",
          confirmButtonText: "OK",
          allowOutsideClick: false,
        }).then(async () => {
          // Ao clicar OK, mata a sessão no servidor e não redireciona
          try {
            await fetch("logout.php", { method: "POST" });
          } catch (error) {
            console.error("Erro ao encerrar sessão:", error);
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
