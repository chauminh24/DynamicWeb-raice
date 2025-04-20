<<<<<<< HEAD
<?php
session_start();

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: index.html");
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

// Generate a new password hash
$new_password = 'thisisapassword'; // Change this to the new password
$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
$email = 'robert.taylor@email.com'; // Change this to the user's email

// Update the user's password hash in the database
$stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $new_password_hash, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password.";
}

$stmt->close();
$conn->close();
?>
=======
<?php
session_start();

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: index.html");
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

// Generate a new password hash
$new_password = 'thisisapassword'; // Change this to the new password
$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
$email = 'robert.taylor@email.com'; // Change this to the user's email

// Update the user's password hash in the database
$stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $new_password_hash, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password.";
}

$stmt->close();
$conn->close();
?>
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
