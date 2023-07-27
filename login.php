<?php

$servername = "localhost";
$db_username = " ";
$db_password = " ";
$database = "login_system";

// Create a connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['login-username'];
$password = $_POST['login-password'];

// Prepare the SQL statement to retrieve the user's password from the database
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if the username exists and retrieve the stored password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

    // Verify the provided password against the stored password
    if (password_verify($password, $storedPassword)) {
        // Start a session and set the username
        session_start();
        $_SESSION['username'] = $username;
        echo "success";
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Invalid username or password.";
}

// Close the connection
$stmt->close();
$conn->close();
?>
