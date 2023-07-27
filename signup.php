<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "login_system";

// Create a connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['signup-username'];
$password = $_POST['signup-password'];

// Validate 
if (strlen($password) < 8) {
  echo "Password must be at least 8 characters long.";
} else {
  // Prepare the SQL statement to check if the username already exists
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "Username already exists. Please choose a different username.";
  } else {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user details into the table
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    if ($stmt->execute()) {
      session_start();
      $_SESSION['username'] = $username;
      header("Location: homepage.php");
      exit();
    } else {
      echo "Error: " . $stmt->error;
    }
  }
}

// Close
$stmt->close();
$conn->close();
?>
