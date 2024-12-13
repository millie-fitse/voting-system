<?php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "campaign"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$name = $_POST['name'];
$user_id = $_POST['user_id'];
$password = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM login WHERE name=? AND user_id=? AND password=?");
$stmt->bind_param("sss", $name, $user_id, $password);

// Execute and get the result
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Successful login
    session_start(); // Start session to manage user state
    $_SESSION['user_id'] = $user_id; // Store user_id in session
    header("Location: profile.php"); // Redirect to profile page
    exit();
} else {
    // Failed login
    echo "Invalid credentials. Please try again.";
}

$stmt->close();
$conn->close();
