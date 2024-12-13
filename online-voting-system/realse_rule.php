<?php
include('dbConnect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $rule_title = $_POST['rule_title'];
    $rule_description = $_POST['rule_description'];

    $stmt = $pdo->prepare("INSERT INTO rules (rule_title, rule_description) VALUES (:rule_title, :rule_description)");

   
    $stmt->bindParam(':rule_title', $rule_title, PDO::PARAM_STR);
    $stmt->bindParam(':rule_description', $rule_description, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "New rule added successfully.";
        header("Location: realse_rule.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rule</title>
    <link rel="stylesheet" href="css/.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0,0.1); 
        }
        form{
            display: flex;
            justify-content: center; 
            align-items: center; 
            flex-direction: column; 
        }
        h2 {
            color: #333;
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            color: #444;
        }

        input[type="text"],
        textarea {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        input[type="submit"]:active {
            background-color: #1e7e34;
        }
        
        
       
    </style>
</head>
<body>
<div class="container-fluid" id="cont-3">
<header id="nav-bar">
          <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon" style="color: white;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto animate__animated animate__bounceInDown" style="padding-right: 50px;">
               
                <li class="nav-item" >
                  <a class="nav-link" href="admin_dashboard.php" style="color:white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Dashboard</a>
                </li>
                <li class="nav-item" >
                  <a class="nav-link" href="user_suggestion.php"  style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Suggestions</a>
                </li>
                <li class="nav-item" >
                  <a class="nav-link" href="show_contact.php"  style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Contact</a>
                </li>
              
                <li class="nav-item">
                  <a class="nav-link" href="user_details_year.php" style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="user_cand_year.php" style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Candidates</a>
                </li>
              
                <li class="nav-item" >
                  <a class="nav-link" href="logout.php"  style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Logout</a>
                </li>
                
              
              </ul>
            </div>
          </nav>
        </header>
        <section>
<div class="container">
<div class="form-container">
        <h2>Add New News/Rules</h2>
        <form method="POST" action="realse_rule.php">
            <label for="title">Title:</label>
            <input type="text" name="rule_title" required>

            <label for="content">Content:</label>
            <textarea name="rule_description" required></textarea>

            <input type="submit" name="add_news" value="Add News">
        </form>
    </div>
   </div>
        </section>
    </div>
    <!-- JS -->
    <script src="js/jquery-3.2.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>    
        <script src="js/bootstrap.min.js"></script>  
</body>
</html>
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to respond.";
    exit;
}