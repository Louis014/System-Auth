<?php
require_once '../../database/conexao.php';
?>
<!-- Verificação de conexão com o banco de dados -->
<?php if ($_SESSION["conexao_bd"] == 1): ?>


<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light"
    data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/velzon/html/saas/auth-signup-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:37 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Cadastre-se | System Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="../assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- sweet alert -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css" rel="stylesheet">



</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position" id="auth-particles">
            <div class="bg-overlay" style="background-color: #08204e;"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <!-- end row -->
                <br>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-10">
                        <div class="card mt-4" style="box-shadow: 2px 5px 15px rgba(0, 0, 0, 0.500);">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-black">Cadastre-se</h5>
                                    <p class="text-muted">Preencha os campos abaixo para realizar o seu cadastro</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form class="needs-validation  row g-6" novalidate method="POST" action="script.php"
                                        class="cont-form" id="cont-form">

                                        <div class="col-lg-6">

                                            <div class="mb-3">
                                                <label for="username" class="form-label">Nome Completo <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="username" name="nome"
                                                    placeholder="Insira seu nome" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira seu nome completo!
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="useremail" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="useremail" name="email"
                                                    placeholder="Insira seu email" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira seu email!
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="username" class="form-label">Telefone <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" id="telefone"
                                                    placeholder="(DDD) 99999-9999" maxlength="15" minlength="15"
                                                    name="telefone" onkeyup="handlePhone(event)"
                                                    required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira seu telefone!
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-6">

                                            <div class="mb-3">
                                                <label for="cpf" class="form-label">CPF <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="cpf" name="cpf"
                                                    placeholder="000.000.000-00" required 
                                                    maxlength="14" minlength="14" onkeyup="handleCpf(event)">
                                                <div class="invalid-feedback" id="cpf-feedback">
                                                    Por favor, insira um CPF válido!
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Senha <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        onpaste="return false" placeholder="Insira sua senha"
                                                        id="password-input" aria-describedby="passwordInput"
                                                        name="verificarsenha"
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="password-addon"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                    <div class="invalid-feedback">
                                                        Por favor, insira sua senha!
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                <h5 class="fs-13">Sua senha deve conter:</h5>
                                                <p id="pass-length" class="invalid fs-12 mb-2">Mínimo de <b>8
                                                        caracteres</b></p>
                                                <p id="pass-upper" class="invalid fs-12 mb-2">Pelo menos <b>uma letra
                                                        maiúscula</b></p>
                                                <p id="pass-number" class="invalid fs-12 mb-0">Pelo menos <b>um
                                                        número</b> (0-9)</p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="confirm-password-input">Confirme sua
                                                    Senha <span class="text-danger">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        onpaste="return false"
                                                        placeholder="Insira novamente a sua senha"
                                                        id="confirm-password-input" aria-describedby="passwordInput"
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                        name="confsenha" required
                                                        onkeyup="checkPasswordMatch()">
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="password-addon-confirm"><i
                                                            class="ri-eye-fill align-middle"></i></button>

                                                    <div id="password-match-feedback" class="invalid-feedback"
                                                        style="display: none;">
                                                        As senhas não coincidem!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-success w-100" type="submit" id="confirmacao-btn">Cadastrar</button>
                                </div>
                                </form>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Já tem conta? <a href="../"
                                class="fw-semibold text-primary text-decoration-underline"> Entrar </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy;
                            <script>document.write(new Date().getFullYear())</script> System Auth. Feito por Luis Filipe <a href="https://github.com/Louis014" target="_blank"><i class="bx bl-bx bxl-github"></i></a> <a href="https://instagram.com/luis._filip" target="_blank"><i class="bx bl-bx bxl-instagram-alt"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="../assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="../assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="../assets/js/pages/particles.app.js"></script>
    <!-- validation init -->
    <script src="../assets/js/pages/form-validation.init.js"></script>
    <!-- password create init -->
    <script src="../assets/js/pages/passowrd-create.init.js"></script>

    <script>
    const handlePhone = (event) => {
        let input = event.target;
        let oldLength = input.value.length;
        let cursorPosition = input.selectionStart;

        let value = input.value;
        value = value.replace(/\D/g, '');

        // 2. Limita a 11 dígitos
        if (value.length > 11) {
            value = value.substring(0, 11);
        }

        // ... [Passo 3: Aplicação da Máscara (código omitido para brevidade, mas deve ser o mesmo)] ...
        let newValue = '';

        if (value.length > 0) {
            newValue = '(' + value.substring(0, 2);
        }
        if (value.length > 2) {
            newValue += ') ' + value.substring(2, 7);
        }
        if (value.length > 7) {
            newValue += '-' + value.substring(7, 11);
        }

        input.value = newValue;

        // ... [Passo 5: Restauração da Posição do Cursor (código omitido para brevidade, mas deve ser o mesmo)] ...
        let newLength = input.value.length;
        let lengthDifference = newLength - oldLength;
        let newCursorPosition = cursorPosition + lengthDifference;

        if (newCursorPosition === 5 && lengthDifference > 0) {
            newCursorPosition++;
        }
        if (newCursorPosition === 10 && lengthDifference > 0) {
            newCursorPosition++;
        }
        if (lengthDifference < 0) {
            newCursorPosition = cursorPosition + lengthDifference;
            if (newCursorPosition === 4 || newCursorPosition === 9) {
                newCursorPosition--;
            }
        }
        input.selectionEnd = newCursorPosition;

        // NOVO: Validação Visual Imediata
        // Verifica se o campo tem exatamente 11 dígitos (15 caracteres com a máscara)
        if (value.length < 11 && value.length > 0) {
            // Adiciona classe para indicar erro (se estiver incompleto)
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
        } else if (value.length === 11) {
            // Adiciona classe para indicar sucesso (se estiver completo)
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
        } else {
            // Limpa as classes se o campo estiver vazio
            input.classList.remove('is-invalid');
            input.classList.remove('is-valid');
        }
    }
    </script>
    <script>
    // Função para verificar se as senhas coincidem
    function checkPasswordMatch() {
        // 1. Obtém os elementos
        const password = document.getElementById('password-input');
        const confirmPassword = document.getElementById('confirm-password-input');
        const feedbackDiv = document.getElementById('password-match-feedback');

        // 2. Limpa quaisquer classes de validação Bootstrap
        confirmPassword.classList.remove('is-valid', 'is-invalid');
        feedbackDiv.style.display = 'none';

        // 3. Verifica apenas se o campo de confirmação não está vazio
        if (confirmPassword.value.length > 0) {

            // 4. Compara as senhas
            if (password.value === confirmPassword.value) {
                // Senhas COINCIDEM
                confirmPassword.classList.add('is-valid');
                confirmPassword.setCustomValidity(''); // Limpa a mensagem de erro de validação

            } else {
                // Senhas NÃO COINCIDEM
                confirmPassword.classList.add('is-invalid');
                feedbackDiv.style.display = 'block'; // Mostra a mensagem de erro
                confirmPassword.setCustomValidity(
                'As senhas não coincidem'); // Define uma mensagem de erro de validação (necessário para o submit)
            }
        } else {
            // Garante que a mensagem de erro de "coincidência" esteja oculta se o campo estiver vazio
            confirmPassword.setCustomValidity('');
        }
    }
    </script>

    <script>
    /**
     * Função principal para aplicar a máscara, gerenciar o cursor e chamar a validação.
     */
    const handleCpf = (event) => {
        let input = event.target;
        let oldLength = input.value.length;
        let cursorPosition = input.selectionStart;

        let value = input.value;

        // 1. Remove TUDO que não for dígito. (Crucial para apagar)
        let rawCpf = value.replace(/\D/g, '');

        // 2. Limita a 11 dígitos
        if (rawCpf.length > 11) {
            rawCpf = rawCpf.substring(0, 11);
        }

        // 3. Aplica a máscara (000.000.000-00)
        let newValue = rawCpf;

        if (rawCpf.length > 3) {
            newValue = rawCpf.substring(0, 3) + '.' + rawCpf.substring(3);
        }
        if (rawCpf.length > 6) {
            newValue = newValue.substring(0, 7) + '.' + newValue.substring(7);
        }
        if (rawCpf.length > 9) {
            newValue = newValue.substring(0, 11) + '-' + newValue.substring(11);
        }

        // 4. Atribui o novo valor formatado
        input.value = newValue;

        // 5. Chamada da Validação Lógica e Feedback Visual
        const isValid = validateCpf(rawCpf);

        if (rawCpf.length === 11) {
            if (isValid) {
                // CPF VÁLIDO e COMPLETO
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
                document.getElementById('cpf-feedback').innerText = 'CPF válido.';
                input.setCustomValidity('');
            } else {
                // CPF INVÁLIDO (números não batem)
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                document.getElementById('cpf-feedback').innerText = 'CPF inválido. Verifique os números.';
                input.setCustomValidity('CPF inválido');
            }
        } else if (rawCpf.length > 0) {
            // CPF INCOMPLETO
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            document.getElementById('cpf-feedback').innerText = 'O CPF deve ter 11 dígitos.';
            input.setCustomValidity('O CPF deve ter 11 dígitos.');
        } else {
            // Campo VAZIO
            input.classList.remove('is-invalid', 'is-valid');
            document.getElementById('cpf-feedback').innerText = 'Por favor, insira seu CPF!';
            input.setCustomValidity(''); // Permite o submit se o campo for required e estiver vazio
        }

        // 6. Restaura a Posição do Cursor (Melhoria de UX)
        let newLength = input.value.length;
        let lengthDifference = newLength - oldLength;
        let newCursorPosition = cursorPosition + lengthDifference;

        // Ajusta o cursor para passar pelos pontos e hífen
        if (lengthDifference > 0) {
            if (newCursorPosition === 4 || newCursorPosition === 8) {
                newCursorPosition++;
            }
            if (newCursorPosition === 12) {
                newCursorPosition++;
            }
        } else if (lengthDifference < 0) {
            // Ajusta ao apagar
            if (cursorPosition === 5 || cursorPosition === 9) {
                newCursorPosition--;
            }
        }
        input.selectionEnd = newCursorPosition;
    }

    /**
     * Função de Validação Lógica do CPF (Algoritmo oficial brasileiro).
     */
    function validateCpf(cpf) {
        // Verifica se tem 11 dígitos e se são todos iguais (inválido)
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
            return false;
        }

        let soma;
        let resto;

        // Valida 1º dígito verificador
        soma = 0;
        for (let i = 1; i <= 9; i++) {
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.substring(9, 10))) return false;

        // Valida 2º dígito verificador
        soma = 0;
        for (let i = 1; i <= 10; i++) {
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.substring(10, 11))) return false;

        return true;
    }
    </script>

    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js
"></script>
    <script src="cadastrar.js"></script>
</body>




</html>

<?php else:
    header("Location: ../error/");
    exit;
    endif;
    ?>