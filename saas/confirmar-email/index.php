<?php session_start();
$email_para_exibir = $_SESSION['user_email'] ?? '';
if (empty($email_para_exibir)) {
    session_destroy();
    header("Location: ../");
    exit;
} ?>

<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light"
    data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/velzon/html/saas/auth-twostep-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:38 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Confirme seu Email | System Auth</title>
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

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <br><br>
                        <div class="card mt-4 " style="box-shadow: 2px 5px 15px rgba(0, 0, 0, 0.500);">

                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                            <i class="ri-mail-line" style="color: #08204e;"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 mt-4">
                                    <div class="text-muted text-center mb-4 mx-lg-3">
                                        <h4 class="">Verifique seu Email!</h4>
                                        <p>Insira o código de 4 digitos enviados para <span
                                                class="fw-semibold"><?= htmlspecialchars($email_para_exibir) ?></span>
                                        </p>
                                    </div>

                                    <form autocomplete="off" method="post" id="cont-form" action="script.php">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                                    <input name="input1"
                                                        style="background-color: rgba(59, 59, 59, 0.30);" type="text"
                                                        class="form-control form-control-lg border-light text-center"
                                                        onkeyup="moveToNext(1, event)" maxLength="1" id="digit1-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                                    <input name="input2"
                                                        style="background-color: rgba(59, 59, 59, 0.30);" type="text"
                                                        class="form-control form-control-lg border-light text-center"
                                                        onkeyup="moveToNext(2, event)" maxLength="1" id="digit2-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                                    <input name="input3"
                                                        style="background-color: rgba(59, 59, 59, 0.30);" type="text"
                                                        class="form-control form-control-lg border-light text-center"
                                                        onkeyup="moveToNext(3, event)" maxLength="1" id="digit3-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                                    <input name="input4"
                                                        style="background-color: rgba(59, 59, 59, 0.30);" type="text"
                                                        class="form-control form-control-lg border-light text-center"
                                                        onkeyup="moveToNext(4, event)" maxLength="1" id="digit4-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-success w-100">Confirmar</button>
                                        </div>
                                    </form><!-- end form -->

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Não recebeu o código? <button type="button"
                                    class="btn btn-link fw-semibold text-primary text-decoration-underline p-0"
                                    id="btnReenviar">
                                    Reenviar código
                                </button> </p>
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
                                </script> System Auth. Feito Luis Filipe.
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
    <!-- two-step-verification js -->
    <script src="../assets/js/pages/two-step-verification.init.js"></script>

    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js
"></script>

    <script src="sweetAlert.js"></script>
</body>


<!-- Mirrored from themesbrand.com/velzon/html/saas/auth-twostep-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:38 GMT -->

</html>