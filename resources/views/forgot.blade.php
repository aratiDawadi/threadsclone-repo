<!DOCTYPE html>
<html>

<head>
    <title> Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
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
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <h5 class="text-white text-center mb-3">Forgot-Password</h5>
                <p class="text-center text-white mb-3 ">Enter your email to reset password</p>
                <form method="POST" action="{{ route('forgotPassword') }}">
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
                        <p style="color:#FFFF00; text-align:center;">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card mb-5">
                        <div class="card-body p-4">
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control"
                                    name="email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Continue</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
