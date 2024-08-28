<!DOCTYPE html>
<html>

<head>
    <title>Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
    <style>
        .centered-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            /* Adjust height as needed */
            background-color: #f8f9fa;
            /* Light background color */
        }

        .centered-section .auth-links {
            text-align: center;
        }

        .centered-section .auth-links a {
            display: inline-block;
            margin: 10px;
            padding: 20px 40px;
            font-size: 24px;
            /* Large text size */
            font-weight: bold;
            color: #E58C8A;
            /* Button text color */
            text-decoration: none;
            border: 2px solid #E58C8A;
            /* Button border color */
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .centered-section .auth-links a:hover {
            background-color: #E58C8A;
            /* Button background color on hover */
            color: #fff;
            /* Button text color on hover */
        }
    </style>
</head>

<body>
    <!-- Centered section for login and register -->
    <section class="centered-section">
        <div class="auth-links">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register-user') }}">Register</a>
        </div>
    </section>

</body>

</html>
