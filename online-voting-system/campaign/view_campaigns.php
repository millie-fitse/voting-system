<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Campaigns</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Basic CSS for the navbar */
        body {
            font-family: Arial, sans-serif;
        }

       

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* styles.css */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(153, 102, 255, 0.5)), url('path/to/abstract-background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        .navbar {
            background-image: linear-gradient(to right, #a517ba,#5f1178 );
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: rgba(153, 102, 255, 0.9);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #4B0082;
           
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.05);
           
        }
        .navbar-brand{
    position: absolute ;
    top:0;
    }
        @media (max-width: 768px) {
            .navbar a {
                float: none;
                width: 100%;
            }

            .container {
                padding: 10px;
            }

            h1 {
                font-size: 1.5em;
            }
        }
    </style>

</head>

<body>
    <!------------------  Navbar Section ------------------>
  <div class="container-fluid" id="cont-3">
    <header id="nav-bar">
      <nav class="navbar navbar-expand-lg navbar-light bg-dark">
      <a class="navbar-brand" href=../index.html  ><img src="../img/logo.png" width="100px" height="85px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon" style="color: white;"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto animate__animated animate__bounceInDown" style="padding-right: 50px;">
            <li class="nav-item" >
              <a class="nav-link" href="../index.html" style="color:white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Home</a>
            </li>
            <li class="nav-item" >
              <a class="nav-link" href="../candidate.php"  style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Campaign</a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" href="../result.php" style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">Result</a>
            </li>
          
            <li class="nav-item" >
              <a class="nav-link" href="../about.php"  style="color: white; font-weight: 600; text-align: center; font-size: 18px; margin-top: 20px;  text-transform: capitalize; padding: 20px;">About</a>
            </li>
          
          </ul>
        </div>
    </nav>
</header>
    <div class="container mt-5">
        <h2>Campaign Profiles</h2>
        <div class="row">
            <?php
            // Database connection details
            $servername = "localhost";
            $username = "root"; // Your database username
            $password = ""; // Your database password
            $dbname = "campaign"; // Your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM campaigns";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-3">';
                    echo '<div class="card">';
                    // Construct the full image path
                    // Assuming 'profile_picture' contains the filename, not the full path
                    $image_path = 'uploads/' . htmlspecialchars($row['profile_picture']); // Use a relative path

                    // Display the profile picture
                    echo '<img src="' . $image_path . '" class="card-img-top" alt="Profile Picture" style="height: 200px; object-fit: cover;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p class="card-text"><strong>Education:</strong> ' . htmlspecialchars($row['education']) . '</p>';
                    echo '<p class="card-text"><strong>Successes:</strong> ' . htmlspecialchars($row['successes']) . '</p>';
                    echo '<p class="card-text"><strong>Deliverables:</strong> ' . htmlspecialchars($row['deliverables']) . '</p>';
                    echo '</div></div></div>';
                }
            } else {
                echo "No campaigns found.";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>