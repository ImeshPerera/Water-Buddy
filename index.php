<!DOCTYPE html>
<html>

<head>
    <title>WaterBuddy</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body class="main-background">
    <!-- Alert Boxes Start -->
    <?php require "alert.php"; ?>
    <!-- Alert Boxes End -->
    <div class="container-fluid vh-100 d-flex align-content-center">
        <div class="row align-content-sm-center">
            <!-- header -->
            <div class="col-12">
                <div class="row">
                    <div class="col-12 logo">
                    </div>
                    <div class="col-12">
                        <p class="text-center title1">Hi, Welcome to WaterBuddy</p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <!-- Content Start-->
            <div class="col-12 px-3">
                <div class="row">
                    <div class="col-6 d-none d-lg-block background">
                    </div>
                    <!-- Content Sign Up-->
                    <div class="col-12 col-lg-6 <?php if(isset($_GET["Sign_In"]) || isset($_COOKIE["u"])){?><?php echo "d-none"; }else{} ?>" id="signUpBox">
                        <div class="row g-3">
                            <div class="col-12 text-center">
                                <label class="form-lable title2 text-center text-bold">Register new account</label>
                            </div>
                            <div class="col-6">
                                <label class="form-lable">Full Name</label>
                                <input id="fullname" class="form-control" type="text" />
                            </div>
                            <div class="col-6">
                                <label class="form-lable">Waterbill Account No</label>
                                <input id="accountno" class="form-control" type="number" min="0" />
                            </div>
                            <div class="col-12">
                                <label class="form-lable">Address</label>
                                <input id="address" class="form-control" type="text" />
                            </div>
                            <div class="col-12">
                                <label class="form-lable">Email</label>
                                <input id="email" class="form-control" type="text" />
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-lable">Username <sup>*</sup></label>
                                        <input id="username" class="form-control" type="text" />
                                    </div>
                                    <div class="col-6">
                                        <label class="form-lable">Password <sup>*</sup></label>
                                        <div class="input-group mb-3">
                                            <input id="password" class="form-control" type="password" />
                                            <button id="password1b" onclick="showPass1();" class="btn btn-light bi bi-eye"></button>
                                        </div>
                                    </div>
                                    <p class="text-danger text-bold">Remember your Username & Password to future logins !</p>
                                </div>
                            </div>                            
                            <div class="col-12 col-lg-6 d-grid">
                                <button onclick="SignUp();" class="btn btn-primary">Sign Up</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-dark" onclick="changeView();">Already have an account? Sign In</button>
                            </div>
                        </div>
                    </div>
                    <!-- Content Sign In-->
                    <div class="col-12 col-lg-6 <?php if(isset($_GET["Sign_In"]) || isset($_COOKIE["u"])){?><?php }else{echo "d-none";} ?>" id="signInBox">
                        <div class="row g-3">
                        <div class="col-12 text-center">
                                <label class="form-lable title2 text-center text-bold">Sign into your account</label>
                            </div>

                            <?php 
                                $u = "";
                                $p = "";

                                if(isset($_COOKIE["u"])){
                                    $u = $_COOKIE["u"];
                                }
                                if(isset($_COOKIE["p"])){
                                    $p = $_COOKIE["p"];
                                }
                            ?>
                            <div class="col-12">
                                <label class="form-lable">Username</label>
                                <input id="logusername" class="form-control" value="<?php echo $u ?>" type="text" />
                            </div>
                            <div class="col-12">
                                <label class="form-lable">Password</label>
                                <div class="input-group mb-3">
                                    <input id="logpassword" class="form-control" value="<?php echo $p ?>" type="password" />
                                    <button id="password2b" onclick="showPass2();" class="btn btn-light bi bi-eye"></button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" <?php if(isset($_COOKIE["p"])){echo "checked";}?>/>
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button onclick="SignIn();" class="btn btn-primary">Sign In</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-danger" onclick="changeView();">New to eShop? Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 mt-lg-5">
                    <p class="text-center"><a href="https://www.imeshperera.com" class="text-decoration-none text-dark">&copy; 2024 imeshperera.com All Rights Reserved</a></p>
                </div>
            </div>
            <!-- Content End -->
        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>