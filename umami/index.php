<?php
session_start();
if(isset($_POST['uname'])) {
    if($_POST['uname'] == 'umamisquare' && $_POST['password'] == 'medetai2020') {
        $_SESSION['umami'] = '1';
        header('Location: https://umamisquare.com/');
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/animate.min.css">

    <link rel="stylesheet" href="css/fontawesome.min.css">

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/responsive.css">
    <title>Umami-square</title>
    <link rel="icon" type="image/png" href="img/favicon.png">

</head>

<body>

    <div class="preloader">
        <div class="loader">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
        </div>
    </div>


    <div class="navbar-area">
        <div class="container">
            <div class="navbar-menu">
                <div class="logo">
                    <a href="index.html"><img src="img/logo.png" alt="image"></a>
                </div>
            </div>
        </div>
    </div>


    <div class="main-banner">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <div class="main-banner-content">
                                <p>Enter passcode to get in the site.</p>
                                <form class="newsletter-form2" data-toggle="validator" method="post">
                                    <div class="d-flex flex-wrap">
                                        <div class="frm-lft">
                                            <input type="text" class="input-newsletter form-control" placeholder="Username" name="uname">
                                        </div>
                                        <div class="frm-middle">
                                            <input type="password" class="input-newsletter form-control" placeholder="Password" name="password">
                                        </div>
                                        <div class="frm-last">
                                            <button type="submit">Enter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>

    <script src="js/popper.min.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/wow.min.js"></script>

    <script src="js/jquery.ajaxchimp.min.js"></script>

    <script src="js/form-validator.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>