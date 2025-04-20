<<<<<<< HEAD
<?php
session_start();
session_destroy();
header("Location: ../../index.html"); // Redirect to the login page after logging out
exit();
?>
=======
<?php
session_start();

// Clear the session
session_destroy();

// Clear the "Remember Me" cookie
setcookie('auth_token', '', time() - 3600, '/');

// Redirect to the homepage
header("Location: ../../index.html");
exit();
?>
>>>>>>> 97b4c39 (Initial commit: Add contact form functionality)
