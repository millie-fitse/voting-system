<?php
session_start(); 

// Database connection 
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "campaign"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'] ?? '';
    $user_id = $_SESSION['user_id'] ?? ''; 
    $education = $_POST['education'] ?? '';
    $successes = $_POST['successes'] ?? '';
    $deliverables = $_POST['deliverables'] ?? '';

    // Handle file upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; 
        $original_file_name = basename($_FILES["profile_picture"]["name"]); 
        $target_file = $target_dir . $original_file_name;

        // Check if uploads directory exists; create it if not
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Check file type and size
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes) && $_FILES['profile_picture']['size'] < 5000000) { // 5MB limit
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = $original_file_name; // Save the filename (not full path) for database
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type or file too large.";
            exit(); 
        }
    } else {
        echo "File upload error: " . $_FILES['profile_picture']['error'];
        exit(); 
    }

    // Insert the record into the database
    if ($profile_picture) { 
        $stmt = $conn->prepare("INSERT INTO campaigns (user_id, name, profile_picture, education, successes, deliverables) VALUES (?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("ssssss", $user_id, $name, $profile_picture, $education, $successes, $deliverables);

            // Execute and check for success
            if ($stmt->execute()) {
                header("Location: view_campaigns.php"); 
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "No profile picture uploaded.";
    }
}

$conn->close();
