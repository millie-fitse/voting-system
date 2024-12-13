<?php
// Include the database connection
include('dbConnect.php');

// Define a query to fetch the username based on a specific condition
$sql = "SELECT email FROM candidates WHERE id = :id"; 
// Prepare the SQL statement
$stmt = $pdo->prepare($sql);

// Bind the value to the placeholder 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Set the user ID (this can be dynamic based on user input or session data)
$id = 1; 

// Execute the query
$stmt->execute();

// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if a username was found
if ($row) {
    echo  $row['username'];
} 
?>
