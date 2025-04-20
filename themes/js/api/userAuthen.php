<<<<<<< HEAD
<?php
// auth_status.php
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

// Check if user is logged in
$response = [
    'isLoggedIn' => isset($_SESSION['user_id']),
    'success' => true
];

// If logged in, add user data
if ($response['isLoggedIn']) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $response['user'] = [
        'username' => $user['username'],
        'email' => $user['email']
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
=======
<?php
// auth_status.php
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

// Check if user is logged in
$response = [
    'isLoggedIn' => isset($_SESSION['user_id']),
    'success' => true
];

// If logged in, add user data
if ($response['isLoggedIn']) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $response['user'] = [
        'username' => $user['username'],
        'email' => $user['email']
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
?>