<<<<<<< HEAD
<?php
session_start();

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and return user ID
$response = [
    'isLoggedIn' => isset($_SESSION['user_id']),
    'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
    'success' => true
];

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
=======
<?php
session_start();

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isLoggedIn = false;
$user_id = null;

// Check if the user is logged in via session
if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true;
    $user_id = $_SESSION['user_id'];
} 
// If not logged in via session, check for the "Remember Me" cookie
elseif (isset($_COOKIE['auth_token'])) {
    $auth_token = $_COOKIE['auth_token'];

    // Validate the token against the database
    $stmt = $conn->prepare("SELECT user_id FROM auth_tokens WHERE token = ? AND expiry > NOW()");
    $stmt->bind_param("s", $auth_token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Log the user in by setting the session
        $_SESSION['user_id'] = $user_id;
        $isLoggedIn = true;
    } else {
        // If the token is invalid, clear the cookie
        setcookie('auth_token', '', time() - 3600, '/');
    }

    $stmt->close();
}

// Prepare the response
$response = [
    'isLoggedIn' => $isLoggedIn,
    'user_id' => $user_id,
    'success' => true
];

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
