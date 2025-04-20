<<<<<<< HEAD
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Check for redirect URL in session storage via JavaScript
    echo "<script>
        var redirectUrl = sessionStorage.getItem('redirect_after_login');
        if (redirectUrl) {
            sessionStorage.removeItem('redirect_after_login');
            window.location.href = redirectUrl;
        } else {
            window.location.href = 'index.html';
        }
    </script>";
    exit();
}

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                
                // After successful login, check sessionStorage for redirect
                echo "<script>
                    var redirectUrl = sessionStorage.getItem('redirect_after_login');
                    if (redirectUrl) {
                        sessionStorage.removeItem('redirect_after_login');
                        window.location.href = redirectUrl;
                    } else {
                        window.location.href = 'index.html';
                    }
                </script>";
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../uploads/images/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- jQuery from Google CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="css/style.css" rel="stylesheet">
    <title>Login | RaicéNote Account</title>
    <style>
        h2 {
            font-size: 4em;
            font-weight: 400;
        }

        .header,
        a {
            color: #888888;
        }

        a.active,
        a:hover {
            color: black;
        }


        .error-message {
            color: red;
            margin-bottom: 1rem;
        }

        .login-input {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;
            /* Optional: Adds a subtle border around the input */
        }

        .login-input:focus {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;

        }

        .login-button {
            background-color: black;
            color: white;
            border: 1px solid white;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-radius: 0;
            height: 5em;
        }

        .login-button:hover {
            background-color: #000000;
            color: white;
        }

        .login-input::placeholder {
            color: black;
        }

        .fulllength-form {
            height: 70vh;
            margin-top: 3em;
        }

        @media (max-width: 768px) {
            .right-col {
                display: flex;
                justify-content: flex-end;
            }

            .hide {
                display: none;
            }

            .hide+.logo-wrapper+.hide~.logo-wrapper {
                margin: 0 auto;
                justify-content: center;
            }

            .logo-wrapper {
                padding-top: 20px;
                display: flex;
                justify-content: center;
                flex-grow: 1;
            }

            h2 {
                font-size: 10vw;
                margin: 10px 0 30px;
            }

            .login-button {
                height: 7em;
                z-index: 200;
            }
            .fulllength-form {
                height: 50vh;}
            footer {
                margin-bottom: 7em;
            }.login-input {
            background-color: #E9E9EB;
            border: 1px solid #ccc;}
        }
    </style>
</head>

<body>
    <header class="header" id="header">
        <div class="hide">RaicéNote Account</div>
        <div class="logo-wrapper">
            <div class="logo"><a href="index.html"><img src="../uploads/images/Asset 4-8.png"></a></div>
        </div>
        <div class="hide"><a href="login.php">LOG IN</a> / <a href="register.php">SIGN UP</a></div>
    </header>
    <div class="container mt-3">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="row row-cols-2 row-cols-md-1">
                    <div class="col">
                        <h2><a href="login.php" class="active">LOGIN</a></h2>
                    </div>
                    <div class="col right-col">
                        <h2><a href="register.php">SIGN UP</a></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-8 fulllength-form">
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control login-input" id="email" name="email" aria-label="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control login-input" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn login-button">LOG IN</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php" style="color: black; text-decoration: underline;">Register here</a></p>
            </div>
        </div>
    </div>
</body>
<footer class="text-light py-5" style="background-color: black;">
    <div class="container">
        <div class="row">

            <!-- Column 1: Shop -->
            <div class="col-6 col-lg-3">
                <h5><a href="#" class="footer-link text-uppercase">SHOP</a></h5>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-light">Best Sellers</a></li>
                    <li><a href="#" class="text-light">Seasonal Specials</a></li>
                    <li><a href="#" class="text-light">Korean Makgeolli</a></li>
                    <li><a href="#" class="text-light">Japanese Sake</a></li>
                </ul>

                <h5><a href="#" class="footer-link text-uppercase">Events</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">Contact Us</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">ABOUT US</a></h5>

            </div>


            <!-- Column 2: Address -->
            <div class="col-6 col-lg-4 ">
                <h5 class="text-uppercase mb-4">Our Location</h5>
                <p class="text-light" style="font-size: smaller;">123 Main Street, Suite 100, City, Country</p>
                <a href="https://www.google.com/maps" target="_blank" class="btn btn-light btn-sm mt-3">GET DIRECTIONS &rarr;</a>
                <h5 class="mt-3"><a href="#" class="text-light">Social Media</h5>
                <div class="social-media-icons mt-3">
                    <a href="#" class="text-light me-3"><i class="bi bi-facebook" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-instagram" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-twitter" style="font-size: 20px;"></i></a>
                </div>

            </div>

            <!-- Column 3: Newsletter Subscription -->
            <div class="col-lg-5 mt-5">
                <h5 class="text-uppercase">want more of raicé?</h5>
                <p class="mb-4" style="font-size: smaller;">Get our email. Letters from our brewers, new products, coming-up events, workshop, and more. Not too often - just enough</p>
                <form action="#" method="post">
                    <div class="input-group" style="height: 3em;">
                        <input type="email" class="form-control rounded-0 custom-input" placeholder="EMAIL" aria-label="Email" required>
                        <button class="btn custom-button" type="submit">SIGN UP</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</footer>
<script src="js/auth.js"></script>
=======
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Check for redirect URL in session storage via JavaScript
    echo "<script>
        var redirectUrl = sessionStorage.getItem('redirect_after_login');
        if (redirectUrl) {
            sessionStorage.removeItem('redirect_after_login');
            window.location.href = redirectUrl;
        } else {
            window.location.href = 'index.html';
        }
    </script>";
    exit();
}

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']); // Check if "Remember Me" is selected

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];

                // If "Remember Me" is selected, set a cookie
                if ($rememberMe) {
                    $auth_token = bin2hex(random_bytes(32)); // Generate a secure token
                    $expiry_time = time() + (30 * 24 * 60 * 60); // 30 days from now

                    // Store the token in the database
                    $stmt = $conn->prepare("INSERT INTO auth_tokens (user_id, token, expiry) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $user['user_id'], $auth_token, date('Y-m-d H:i:s', $expiry_time));
                    $stmt->execute();

                    // Set the cookie
                    setcookie('auth_token', $auth_token, $expiry_time, '/', '', true, true); // Secure and HTTP-only
                }

                // After successful login, check sessionStorage for redirect
                echo "<script>
                    var redirectUrl = sessionStorage.getItem('redirect_after_login');
                    if (redirectUrl) {
                        sessionStorage.removeItem('redirect_after_login');
                        window.location.href = redirectUrl;
                    } else {
                        window.location.href = 'index.html';
                    }
                </script>";
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../uploads/images/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- jQuery from Google CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="css/style.css" rel="stylesheet">
    <title>Login | RaicéNote Account</title>
    <style>
        h2 {
            font-size: 4em;
            font-weight: 400;
        }

        .header,
        a {
            color: #888888;
        }

        a.active,
        a:hover {
            color: black;
        }


        .error-message {
            color: red;
            margin-bottom: 1rem;
        }

        .login-input {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;
            /* Optional: Adds a subtle border around the input */
        }

        .login-input:focus {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;

        }

        .login-button {
            background-color: black;
            color: white;
            border: 1px solid white;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-radius: 0;
            height: 5em;
        }

        .login-button:hover {
            background-color: #000000;
            color: white;
        }

        .login-input::placeholder {
            color: black;
        }

        .fulllength-form {
            height: 70vh;
            margin-top: 3em;
        }

        @media (max-width: 768px) {
            .right-col {
                display: flex;
                justify-content: flex-end;
            }

            .hide {
                display: none;
            }

            .hide+.logo-wrapper+.hide~.logo-wrapper {
                margin: 0 auto;
                justify-content: center;
            }

            .logo-wrapper {
                padding-top: 20px;
                display: flex;
                justify-content: center;
                flex-grow: 1;
            }

            h2 {
                font-size: 10vw;
                margin: 10px 0 30px;
            }

            .login-button {
                height: 7em;
                z-index: 200;
            }
            .fulllength-form {
                height: 50vh;}
            footer {
                margin-bottom: 7em;
            }.login-input {
            background-color: #E9E9EB;
            border: 1px solid #ccc;}
        }
    </style>
</head>

<body>
    <header class="header" id="header">
        <div class="hide">RaicéNote Account</div>
        <div class="logo-wrapper">
            <div class="logo"><a href="index.html"><img src="../uploads/images/Asset 4-8.png"></a></div>
        </div>
        <div class="hide"><a href="login.php">LOG IN</a> / <a href="register.php">SIGN UP</a></div>
    </header>
    <div class="container mt-3">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="row row-cols-2 row-cols-md-1">
                    <div class="col">
                        <h2><a href="login.php" class="active">LOGIN</a></h2>
                    </div>
                    <div class="col right-col">
                        <h2><a href="register.php">SIGN UP</a></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-8 fulllength-form">
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control login-input" id="email" name="email" aria-label="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control login-input" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn login-button">LOG IN</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php" style="color: black; text-decoration: underline;">Register here</a></p>
            </div>
        </div>
    </div>
</body>
<footer class="text-light py-5" style="background-color: black;">
    <div class="container">
        <div class="row">

            <!-- Column 1: Shop -->
            <div class="col-6 col-lg-3">
                <h5><a href="#" class="footer-link text-uppercase">SHOP</a></h5>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-light">Best Sellers</a></li>
                    <li><a href="#" class="text-light">Seasonal Specials</a></li>
                    <li><a href="#" class="text-light">Korean Makgeolli</a></li>
                    <li><a href="#" class="text-light">Japanese Sake</a></li>
                </ul>

                <h5><a href="#" class="footer-link text-uppercase">Events</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">Contact Us</a></h5>
                <h5><a href="#" class="footer-link text-uppercase">ABOUT US</a></h5>

            </div>


            <!-- Column 2: Address -->
            <div class="col-6 col-lg-4 ">
                <h5 class="text-uppercase mb-4">Our Location</h5>
                <p class="text-light" style="font-size: smaller;">123 Main Street, Suite 100, City, Country</p>
                <a href="https://www.google.com/maps" target="_blank" class="btn btn-light btn-sm mt-3">GET DIRECTIONS &rarr;</a>
                <h5 class="mt-3"><a href="#" class="text-light">Social Media</h5>
                <div class="social-media-icons mt-3">
                    <a href="#" class="text-light me-3"><i class="bi bi-facebook" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-instagram" style="font-size: 20px;"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-twitter" style="font-size: 20px;"></i></a>
                </div>

            </div>

            <!-- Column 3: Newsletter Subscription -->
            <div class="col-lg-5 mt-5">
                <h5 class="text-uppercase">want more of raicé?</h5>
                <p class="mb-4" style="font-size: smaller;">Get our email. Letters from our brewers, new products, coming-up events, workshop, and more. Not too often - just enough</p>
                <form action="#" method="post">
                    <div class="input-group" style="height: 3em;">
                        <input type="email" class="form-control rounded-0 custom-input" placeholder="EMAIL" aria-label="Email" required>
                        <button class="btn custom-button" type="submit">SIGN UP</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</footer>
<script src="js/auth.js"></script>
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
</html>