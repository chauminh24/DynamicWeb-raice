<?php
// Enable error reporting for debugging purposes (REMOVE this in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'website_raicenote';

// Establish database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check for database connection errors
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all form fields are set and sanitize them
    if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $subject = sanitizeInput($_POST['subject']);
        $message = sanitizeInput($_POST['message']);

        // Validate required fields
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email address.'
            ]);
            exit;
        }

        // Prepare the SQL query to insert data into the database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to prepare the database query.'
            ]);
            exit;
        }

        // Bind parameters to the SQL query
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        // Execute the query and check for errors
        if ($stmt->execute()) {
            // Send confirmation email to the user (optional)
            $to = $email;
            $email_subject = "Thank you for contacting us!";
            $email_message = "Hello $name,\n\nThank you for your message. We'll get back to you soon.\n\nYour Message:\n$subject\n\nMessage:\n$message\n";
            $headers = "From: no-reply@raicenote.com\r\nReply-To: no-reply@raicenote.com\r\nContent-Type: text/plain; charset=UTF-8\r\n";

            // Send email
            if (!mail($to, $email_subject, $email_message, $headers)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to send confirmation email.'
                ]);
                exit;
            }

            // Send a success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Your message has been sent successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to save the message to the database.'
            ]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required form fields.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}

// Close the database connection
$conn->close();
?>
