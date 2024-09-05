<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte.min.css">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fc;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .login-form {
            width: 100%;
        }

        .login-form .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-form .login-logo img {
            max-width: 80%;
            height: auto;
            margin-bottom: 1rem;
        }

        .login-form .login-logo h1 {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }

        .login-form .btn-primary {
            background-color: #6f42c1;
            border-color: #6f42c1;
            width: 100%;
            font-weight: bold;
        }

        .login-form .btn-primary:hover {
            background-color: #5a379b;
            border-color: #5a379b;
        }

        .login-form .input-group-text {
            background-color: #ffffff;
            border-right: none;
        }

        .login-form .form-control {
            border-left: none;
        }

        .login-form .form-group {
            margin-bottom: 1rem;
        }

        .login-form .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .login-form .forgot-password a {
            color: #6f42c1;
            text-decoration: none;
        }

        .login-form .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 576px) {
            .login-container {
                width: 100%;
                padding: 1rem;
            }

            .login-form .login-logo img {
                max-width: 90%;
            }

            .login-form .login-logo h1 {
                font-size: 1.25rem;
            }

            .login-form .btn-primary {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Login Form Section -->
        <div class="login-form">
            <p class="login-box-msg">Please sign in to your account</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Email Or Phone" name="login" value="{{ old('login') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('login')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend') }}/dist/js/adminlte.min.js"></script>
</body>

</html>
