<!DOCTYPE html>
<html>

<head>
    <title>Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <h6 class="text-white mb-3">Reset-Password</h6>
                <form method="POST" action="{{ route('resetPassword', ['token' => $token]) }}">
                    @csrf
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p style="color:red;">{{ $error }}</P>
                        @endforeach
                    @endif

                    @if (Session::has('error'))
                        <p style="color:red;">{{ Session::get('error') }}</p>
                    @endif

                    @if (Session::has('message'))
                        <p style="color:green;">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card mb-5">
                        <div class="card-body p-4">
                            <div class="form-group mb-3 position-relative">
                                @if ($user)
                                    <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                                @endif
                                <input type="password" placeholder="Enter New Password" id="password"
                                    class="form-control" name="password">
                                <i class="fas fa-eye-slash password-icon"
                                    onclick="togglePasswordVisibility('password')"></i>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3 position-relative">
                                <input type="password" placeholder="Confirm Password" id="confirm_password"
                                    class="form-control" name="password_confirmation">
                                <i class="fas fa-eye-slash password-icon"
                                    onclick="togglePasswordVisibility('confirm_password')"></i>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Reset Password</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
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
