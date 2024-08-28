<!DOCTYPE html>
<html>

<head>
    <title> Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style type="text/css">
        body {
            background: black url('images/saymore.webp') no-repeat;
            background-size: 100% auto;
            padding-top: 250px;
        }

        h6 {
            font-weight: bold;
            text-align: center;
        }


        img {
            position: fixed;
            height: 60%;
            width: 100%;
        }

        .password-visible input[type="password"] {
            -webkit-text-security: disc;
            -ms-text-security: circle;
        }

        .password-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            z-index: 100;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <h6 class="text-white mb-3">Log in</h6>
                <form method="POST" action="{{ route('postlogin') }}">
                    @csrf
                    <div class="card mb-5">
                        <div class="card-body p-4">
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 position-relative">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                    name="password">
                                <i class="fas fa-eye-slash password-icon"
                                    onclick="togglePasswordVisibility('password')"></i>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <a href="/register" style="color:black;"class="text-decoration-none">
                                    Create an Account</a>
                                <a href="/forgot-password" style="color:black;"class="text-decoration-none">Forgot
                                    Password?</a>
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Log in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (session('message'))
            <script>
                // JavaScript to display the toast message
                toastr.success('{{ session('message') }}');
                // Clear the session message after displaying it
                {{ session()->forget('message') }}
            </script>
        @elseif(session('error'))
            <script>
                // JavaScript to display the error toast message
                toastr.error('{{ session('error') }}');
                // Clear the session message after displaying it
                {{ session()->forget('message') }}
            </script>
        @endif

        <script>
            function togglePasswordVisibility(fieldId) {
                var field = document.getElementById(fieldId);
                var icon = document.querySelector(`#${fieldId} + .password-icon`);
                if (field.type === "password") {
                    field.type = "text";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    field.type = "password";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            }
        </script>
    </div>
</body>

</html>
