<?php
session_start();
include('dbConnect.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $cid = $_GET['id'];

    // Prepare the delete query
    $sql = "DELETE FROM candidates WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Bind the ID and execute the query
    $stmt->bindParam(':id', $cid, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Successfully deleted, redirect to the previous page
        $_SESSION['message'] = "Candidate deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete candidate.";
    }
    
    // Redirect to the previous page 
    header("Location: user_cand.php"); 
    exit();
} else {
    // No ID provided, redirect with error message
    $_SESSION['error'] = "Invalid request.";
    header("Location: candidates_list.php");
    exit();
}
?>
