<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Register</title>

    <link rel="shortcut icon" href="assets/img/favicon.png">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="assets/img/login.png" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Ro'yhatdan o'tish</h1>
                            <p class="account-subtitle">Enter details to create your account</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group col-12">
                                    <label for="name">Ism familiya</label>
                                    <input id="name" type="text" class="form-control" name="name" autofocus>
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Login</label>
                                    <input id="email" type="text" class="form-control" name="email">
                                    <span class="profile-views"><i class="fas fa-envelope"></i></span>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="d-block">Password</label>
                                    <input id="password" type="password" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="password">
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                    <span class="profile-views feather-eye toggle-password"></span>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="d-block">Confirm password</label>
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation">
                                    <span class="profile-views feather-eye reg-toggle-password"></span>
                                </div>

                                <div class=" dont-have">Already Registered? <a href="{{ route('login') }}">Login</a>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Register</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>
