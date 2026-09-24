<?php
require_once '../../database/conexao.php';
?>
<?php if ($_SESSION["conexao_bd"] == 0):?>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/velzon/html/saas/auth-500.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:39 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Erro | CONAD</title>
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
     <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">

        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden p-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 text-center">
                        <div class="error-500 position-relative text-center">
                            <img src="../assets/images/error500.png" alt="" class="img-fluid error-500-img error-img" />
                            <h1 class="title text-muted">...</h1>
                        </div>
                        <div>
                            <h4>Sistema offline!</h4>
                            <p class="text-muted w-75 mx-auto">Infelizmente o nosso sistema está offline, tente novamente mais tarde.</p>
                            <a href="../" class="btn btn-success"><i class="bi bi-arrow-clockwise me-1"></i>Tentar novamente</a>
                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth-page content -->
    </div>
    <!-- end auth-page-wrapper -->

</body>


<!-- Mirrored from themesbrand.com/velzon/html/saas/auth-500.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 11:49:42 GMT -->
</html>

<?php else:
    header("Location: ../");
    exit;
    endif;
    ?>