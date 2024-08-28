<!DOCTYPE html>
<html>

<head>
    <title>Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                @if (session('registered'))
                    <span class="text-white">Registered</span>
                @else
                    <h6 class="text-white mb-3">Register Your Account</h6>
                    <form method="POST" action="{{ route('postsignup') }}">
                        @csrf
                        <div class="card mb-5">
                            <div class="card-body p-4">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="First Name" id="firstname" class="form-control"
                                        name="firstname" value="{{ old('firstname') }}" required>
                                    @error('firstname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Last Name" id="lastname" class="form-control"
                                        name="lastname" value="{{ old('lastname') }}" required>
                                    @error('lastname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Username" id="username" class="form-control"
                                        name="username" value="{{ old('username') }}" required>
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" placeholder="Email" id="email_address" class="form-control"
                                        name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Mobile Number" id="mobile_number"
                                        class="form-control" name="mobile_number" value="{{ old('mobile_number') }}"
                                        required>
                                    @error('mobile_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 position-relative">
                                    <input type="password" placeholder="Password" id="password" class="form-control"
                                        name="password" required>
                                    <i class="fas fa-eye-slash password-icon"
                                        onclick="togglePasswordVisibility('password')"></i>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 position-relative">
                                    <input type="password" placeholder="Confirm Password" id="confirm_password"
                                        class="form-control" name="password_confirmation" required>
                                    <i class="fas fa-eye-slash password-icon"
                                        onclick="togglePasswordVisibility('confirm_password')"></i>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" name="submit"
                                        class="btn btn-dark btn-block">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "4000",
                    "extendedTimeOut": "1500",
                    "positionClass": "toast-top-right",
                    "toastClass": "toast-error"
                };
                toastr.error('{{ session('error') }}');
            });
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
</body>

</html>
