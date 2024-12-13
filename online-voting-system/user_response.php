<?php

session_start();
include('dbConnect.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $response = $_POST['response'];
    $rule_id = $_POST['rule_id'];
    $user_id = $_SESSION['user_id'];  
    
    
    

    // Check if the user has already responded
    $check_stmt = $pdo->prepare("SELECT * FROM user_responses WHERE user_id = ? AND rule_id = ?");
    $check_stmt->bind_param("ii", $user_id, $rule_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "You have already responded to this rule.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO user_responses (user_id, rule_id, response) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $rule_id, $response);

        if ($stmt->execute()) {
            echo "Your response has been recorded.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Form for user response -->
<form action="user_response.php" method="POST">
    <label for="response">Do you approve this rule?</label><br>
    <input type="radio" name="response" value="approve" required> Approve<br>
    <input type="radio" name="response" value="disapprove" required> Disapprove<br>

    <input type="hidden" name="rule_id" value="<?php echo $_GET['rule_id']; ?>"> <!-- Pass the rule ID from URL -->
    
    <input type="submit" value="Submit Response">
</form>
</body>
</html>