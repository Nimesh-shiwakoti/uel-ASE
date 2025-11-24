<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Google - ToysZone.com</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #00b894, #019875); /* Green gradient */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .login-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #019875; /* Dark green for header */
        }

        .login-container p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #00b894; /* Button green */
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .google-btn img {
            width: 20px;
            margin-right: 12px;
            background: #fff;
            border-radius: 50%;
        }

        .google-btn:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transform: translateY(-2px);
            background: #019875; /* Darker green on hover */
        }

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-container h1 {
                font-size: 24px;
            }

            .google-btn {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>ToysZone.com</h1>
        <p>To make your purchase, please login with your Google account.</p>

        <!-- Google Login Button -->
        <a href="google_oauth_redirect.php" class="google-btn">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2sSeQqjaUTuZ3gRgkKjidpaipF_l6s72lBw&s" alt="Google Logo">
            Login with Google
        </a>

        <div class="footer-text">
            By logging in, you agree to our Terms of Service and Privacy Policy.
        </div>
    </div>

</body>
</html>
