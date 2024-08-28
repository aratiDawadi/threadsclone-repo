<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        p {
            font-size: 14px;
            color: #333;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }

        .signature {
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Hey {{ $user->firstname }},</p>
        <p>We understand that forgetting a password can happen to anyone. Don't worry, we've got you covered. Click the
            button below to reset your password.</p>
        <div class="button-container">
            <a href="{{ url('reset/' . $user->remember_token) }}" class="button">Reset Your Password</a>
        </div>
        <p class="signature">Thanks,<br>{{ config('app.name') }} Team</p>
    </div>
</body>

</html>
