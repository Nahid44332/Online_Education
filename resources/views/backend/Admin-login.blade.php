<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin-Login</title>
    <style>
        body {
            font-family: "arial", sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #fafafa;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card {
            width: 100%;
            background-color: #d4e7ef;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #a7ddf5;
            box-sizing: border-box; /* padding fix */
        }

        .card .cartoon {
            margin-bottom: 35px;
            margin-left: auto;
            margin-right: auto;
            width: 180px;
            height: 180px;
        }

        .card .cartoon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card form {
            display: flex;
            flex-direction: column;
        }

        .card form .input-group {
            width: 100%;
            margin-bottom: 14px;
        }

        .card form .input-group input {
            padding: 16px;
            border: 2px solid transparent;
            border-radius: 5px;
            transition: all 0.3s ease;
            outline: none;
            color: #333;
            background-color: #f4f4f4;
            width: 100%;
            box-sizing: border-box; /* input width fix */
        }

        .card form .input-group input:focus {
            border-color: #39778c;
            background-color: #fff;
        }

        .card form button {
            background-color: #2d6476;
            color: #fff;
            padding: 16px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .card form button:hover {
            background-color: #39778c;
        }

        /* Back to website button style */
        .back-link {
            margin-top: 25px;
            font-size: 14px;
            color: #6b7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #2d6476;
            transform: translateX(-3px);
        }

        .back-link svg {
            height: 18px;
            width: 18px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="cartoon">
                <img src="https://i.ibb.co.com/98gpLCQ/l1.png" alt="Normal" id="animation1">
                <img src="https://i.ibb.co.com/Vq5j4Vg/l2.png" alt="Password Hidden" id="animation2" style="display: none;">
                <img src="https://i.ibb.co.com/Y0jsj90/l3.png" alt="Email Typing" id="animation3" style="display: none;">
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="email">
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>

        <a href="{{ url('/') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to main website
        </a>
    </div>

    <script>
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const animation1 = document.getElementById("animation1");
        const animation2 = document.getElementById("animation2");
        const animation3 = document.getElementById("animation3");

        const resetAnimations = () => {
            animation1.style.display = "none";
            animation2.style.display = "none";
            animation3.style.display = "none";
        };

        emailInput.addEventListener("focus", () => {
            resetAnimations();
            animation3.style.display = "block";
        });

        passwordInput.addEventListener("focus", () => {
            resetAnimations();
            animation2.style.display = "block";
        });

        const showDefault = () => {
            resetAnimations();
            animation1.style.display = "block";
        };

        emailInput.addEventListener("blur", showDefault);
        passwordInput.addEventListener("blur", showDefault);
    </script>
</body>

</html>