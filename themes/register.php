<<<<<<< HEAD
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
$error_message = "";
$registration_successful = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $confirm_password = sanitizeInput($_POST["confirm_password"]);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Email already exists!"; 
    } elseif ($password != $confirm_password) {
       $error_message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            $registration_successful = true;
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the connection
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
    <title>Sign Up | RaicéNote Account</title>
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

        .register-input {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;
            /* Optional: Adds a subtle border around the input */
        }

        .register-input:focus {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;

        }

        .register-button {
            background-color: black;
            color: white;
            border: 1px solid white;
        }

        .register-button:hover {
            background-color: #000000;
            color: white;
        }

        .register-input::placeholder {
            color: black;
        }

        .register-button {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-radius: 0;
            height: 5em;
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
                margin: 10px 0 10px;
            }

            .register-button {
                height: 7em;
                z-index: 200;
            }

            .fulllength-form {
                height: 50vh;
            }

            footer {
                margin-bottom: 7em;
            }

            .register-input {
                background-color: #E9E9EB;
                border: 1px solid #ccc;
            }
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
                        <h2><a href="login.php">LOGIN</a></h2>
                    </div>
                    <div class="col right-col">
                        <h2><a href="register.php" class="active">SIGN UP</a></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-8 fulllength-form">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control register-input" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control register-input" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control register-input" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn register-button">SIGN UP</button>
                    <div id="errorDisplay" class="error-message"><?php echo $error_message; ?></div>
                </form>

                <p class="mt-3">Already have an account? <a href="login.php" style="color: black; text-decoration: underline;">Log In here</a></p>
            </div>
        </div>
        <?php if ($registration_successful): ?>
        <!-- Success Modal -->
        <div class="modal fade show" id="successModal" tabindex="-1" role="dialog" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registration Successful</h5>
                    </div>
                    <div class="modal-body">
                        <p>Your account has been created successfully. You can now log in.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn btn-primary">Go to Login</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($registration_successful): ?>
    <script>
        // Automatically show the modal on page load
        var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
            keyboard: false
        });
        successModal.show();
    </script>
    <?php endif; ?>

=======
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
$error_message = "";
$registration_successful = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $confirm_password = sanitizeInput($_POST["confirm_password"]);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Email already exists!"; 
    } elseif ($password != $confirm_password) {
       $error_message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            $registration_successful = true;
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the connection
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
    <title>Sign Up | RaicéNote Account</title>
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

        .register-input {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;
            /* Optional: Adds a subtle border around the input */
        }

        .register-input:focus {
            background-color: #E9E9EB;
            border: none;
            border-bottom: 1px solid #ccc;

        }

        .register-button {
            background-color: black;
            color: white;
            border: 1px solid white;
        }

        .register-button:hover {
            background-color: #000000;
            color: white;
        }

        .register-input::placeholder {
            color: black;
        }

        .register-button {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-radius: 0;
            height: 5em;
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
                margin: 10px 0 10px;
            }

            .register-button {
                height: 7em;
                z-index: 200;
            }

            .fulllength-form {
                height: 50vh;
            }

            footer {
                margin-bottom: 7em;
            }

            .register-input {
                background-color: #E9E9EB;
                border: 1px solid #ccc;
            }
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
                        <h2><a href="login.php">LOGIN</a></h2>
                    </div>
                    <div class="col right-col">
                        <h2><a href="register.php" class="active">SIGN UP</a></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-8 fulllength-form">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control register-input" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control register-input" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control register-input" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn register-button">SIGN UP</button>
                    <div id="errorDisplay" class="error-message"><?php echo $error_message; ?></div>
                </form>

                <p class="mt-3">Already have an account? <a href="login.php" style="color: black; text-decoration: underline;">Log In here</a></p>
            </div>
        </div>
        <?php if ($registration_successful): ?>
        <!-- Success Modal -->
        <div class="modal fade show" id="successModal" tabindex="-1" role="dialog" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registration Successful</h5>
                    </div>
                    <div class="modal-body">
                        <p>Your account has been created successfully. You can now log in.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn btn-primary">Go to Login</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($registration_successful): ?>
    <script>
        // Automatically show the modal on page load
        var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
            keyboard: false
        });
        successModal.show();
    </script>
    <?php endif; ?>

>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
</html>