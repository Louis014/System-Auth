<!-- Conecão com o arquivo do banco de dados-->
<?php
require_once '../../database/conexao.php';
?>
<!-- Verificação de conexão com o banco de dados -->
<?php if ($_SESSION["conexao_bd"] == 1): ?>
    <!-- Conexão bem-sucedida, continue com o restante do código -->

    <!doctype html>
    <html lang="pt-br" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light"
        data-sidebar-image="none" data-preloader="disable">


    <!-- Mirrored from themesbrand.com/velzon/html/saas/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:36 GMT -->

    <head>

        <meta charset="utf-8" />
        <title>Login | System Auth</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="System Auth" name="description" />
        <meta content="Luis Filipe" name="author" />
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
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <br><br>
                            <div class="card mt-4" style="box-shadow: 2px 5px 15px rgba(0, 0, 0, 0.500);">
                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5 class="text-black">System Auth <img class="mb-1" src="../assets/images/logo_png.png" alt="" width="15"></h5>
                                        <p class="text-muted">Sistema de login e cadastro</p>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <form action="script.php" method="post" class="cont-form" id="cont-form">

                                            <div class="mb-3">
                                                <label for="username" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Insira seu email">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Senha</label>
                                                <div class="position-relative auth-pass-inputgroup mb-1">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        placeholder="*******" id="password-input" name="senha">
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="password-addon"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                                <div class="float-end mb-3">
                                                    <a href="../resetar-senha/" class="text-muted">Esqueceu sua senha?</a>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Entrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->

                            <div class="mt-4 text-center">
                                <p class="mb-0">Não tem conta? <a href="../cadastrar-se/"
                                        class="fw-semibold text-primary text-decoration-underline"> Cadastre-se </a> </p>
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
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> System Auth. Feito por Luis Filipe <a href="https://github.com/Louis014" target="_blank"><i class="bx bl-bx bxl-github"></i></a> <a href="https://instagram.com/luis._filip" target="_blank"><i class="bx bl-bx bxl-instagram-alt"></i></a>
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
        <!-- password-addon init -->
        <script src="../assets/js/pages/password-addon.init.js"></script>
        <!-- sweet alert -->
        <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js
"></script>

        <script src="entrar.js"></script>
    </body>


    <!-- Mirrored from themesbrand.com/velzon/html/saas/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:37 GMT -->

    </html>

<?php else:
    header("Location: ../error/");
    exit;
endif;
?>