<?php
session_start();
if (!isset($_SESSION['role'])) {
    
} else {
    header('location: admin/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Home - PT Kepri Citra Buana</title>
</head>

<body>
    <header>
        <?php include 'layouts/navbar.php' ?>
        <div class="view jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('https://mdbootstrap.com/img/Photos/Others/gradient2.png'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
            <div class="mask rgba-purple-slight">
                <div class="container h-100 d-flex justify-content-center align-items-center">
                    <div class="row pt-5 mt-3">
                        <div class="col-md-12 wow fadeIn mb-3">
                            <div class="text-center">
                                <h1 class="display-4 font-weight-bold mb-5 wow fadeInUp">PT. Kepri Citra Buana</h1>
                                </li>
                                <h5 class="mb-5 wow fadeInUp" data-wow-delay="0.2s">
                                    Contractor and Developer
                                </h5>
                                <div class="wow fadeInUp" data-wow-delay="0.4s">
                                    <a class="btn btn-purple btn-rounded white-text" href="" data-target="#modallogin" data-toggle="modal">
                                        <i class="fas fa-user"></i>
                                        Log In Now!
                                    </a>
                                </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="modal fade" id="modallogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-light blue accent-4">
                    <h5 class="modal-title" id="exampleModalLabel">Log In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/inventory/controller/login.php" method="post">
                    <div class="modal-body">
                        <input class="form-control mb-3 border border-info" type="text" name="username" id="username" placeholder="Username" required>
                        <input class="form-control border border-info" type="password" name="password" id="password" placeholder="Password" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn red accent-4 text-light" data-dismiss="modal">Close</button>
                        <button type="submit" name="login" class="btn blue accent-4 text-light">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
</body>

</html>