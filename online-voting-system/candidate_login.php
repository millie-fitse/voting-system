<!-- login.php -->
<?php
session_start();
include('dbConnect.php');

$error = "";
$msg = "";

if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['username'];
    $pass = $_REQUEST['password'];

    if (!empty($email) && !empty($pass)) {
        // Prepare the SQL query with placeholders to prevent SQL injection
        $sql = "SELECT * FROM candidates WHERE email = :email AND mobile = :pass";

        $stmt = $pdo->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $email;
            header("Location: candidate_dashboard.php");
            exit(); 
        } else {
            $error = "<p class='alert alert-warning'>Email or Password does not match!</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please fill all the fields</p>";
    }
}
?>


<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<style>
		.card{
			width:400px;
			margin-left:auto;
			margin-right:auto;
			margin-top:100px;
			text-align:center;
			padding:30px;	
			border:4px #a517ba solid;
			border-radius:5px;	
		}
	</style>
	<body>
		<section class="sec">
			<div class="card">
				<div class="row">
					<div class="col-md-12">
						<h3 class="mb-5">Candidate Login</h3>
	
					<form action="process.php" method="post">
						<div class="form-group">
							<input required type="text" class="form-control" name="username" placeholder="Your Email *" value="" />
						</div>
						<div class="form-group">
							<input required type="password" class="form-control" name="password" placeholder="Your Password *" value="" />
						</div>
						<div class="form-group">
							<input required type="submit" class="btnSubmit " name="login" value="Login"/>
						</div>	
					</form>
				</div>
			</div>
		</div>
	</section>
	<script src="js/jquery-3.2.1.slim.min.js"></script>
		<script src="js/popper.min.js"></script>    
		<script src="js/bootstrap.min.js"></script> 
	</body>
	</html>

