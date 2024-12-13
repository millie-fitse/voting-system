<!-- edit_campaign.php -->
<?php
$host = 'localhost'; // Database host
$user = 'root'; // Database username
$password = ''; // Database password
$dbname = 'campaign'; // Database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$campaign = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['name']) && isset($_GET['user_id'])) {
    $name = $_GET['name'];
    $user_id = $_GET['user_id'];

    // Fetch the campaign details
    $stmt = $conn->prepare("SELECT * FROM campaigns WHERE name=? AND user_id=?");
    $stmt->bind_param("si", $name, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $campaign = $result->fetch_assoc();
    } else {
        echo "No campaign found with the provided name and user ID.";
    }
}

// Handle file upload
$profile_picture = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    $target_file = $target_dir . basename($_FILES['profile_picture']['name']);

    // Check file type and size (optional)
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowedTypes) && $_FILES['profile_picture']['size'] < 5000000) { // 5MB limit
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $profile_picture = $target_file; // Save the file path
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Invalid file type or file too large.";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    // Update campaign logic
    $name = $_POST['name'];
    $profile_picture = $_POST['profile_picture']; // URL or path to the profile picture
    $education = $_POST['education'];
    $successes = $_POST['successes'];
    $deliverables = $_POST['deliverables'];
    $user_id = $_POST['user_id'];

    // Ensure that the update only occurs for the correct campaign
    $stmt = $conn->prepare("UPDATE campaigns SET name=?, profile_picture=?, education=?, successes=?, deliverables=? WHERE user_id=? AND name=?");
    $stmt->bind_param("sssssis", $name, $profile_picture, $education, $successes, $deliverables, $user_id, $name);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect to the view page
        header("Location: view_campaigns.php?user_id=" . urlencode($user_id));
        exit(); // Make sure to exit after redirecting
    } else {
        echo "No changes made to the campaign or invalid name/user ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign</title>
    <style>
        /* Basic CSS for the navbar */
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
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
            background-color: rgba(80, 0, 150, 0.8);
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
            /* Darker purple for headers */
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.05);
            /* Slight zoom effect on hover */
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
    <div class="navbar">
        <a href="profile.php">profile</a>

    </div>
    <h1>Edit Campaign</h1>
    <?php if ($campaign): ?>
        <form action="edit_campaign.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($campaign['user_id']); ?>">

            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($campaign['name']); ?>" required>

            <label for="profile_picture">Profile Picture URL:</label>
            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture" accept="image/*" required>

            <label for="education">Education:</label>
            <textarea name="education" required><?php echo htmlspecialchars($campaign['education']); ?></textarea>

            <label for="successes">Successes:</label>
            <textarea name="successes" required><?php echo htmlspecialchars($campaign['successes']); ?></textarea>

            <label for="deliverables">Deliverables:</label>
            <textarea name="deliverables" required><?php echo htmlspecialchars($campaign['deliverables']); ?></textarea>

            <button type="submit">Update Campaign</button>
        </form>
    <?php else: ?>
        <p>No campaign details available.</p>
    <?php endif; ?>
</body>

</html>