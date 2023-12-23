<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['academic_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
require_once('db_connect.php');

$academicId = $_SESSION['academic_id'];
$sql = "SELECT * FROM users WHERE academic_id = '$academicId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #000; 
        }

        /* Header and Navigation Bar Styles */
        header, nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            transition: color 0.3s ease-in-out;
        }

        nav a:hover {
            color: #ffd700; 
        }

        /* Main Content Styles */
        .main-content {
            max-width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            

        }

        h2 {
            color: #333;
            margin-left: 120px;
        }

        p {
            line-height: 1.6;
            color: #555;
            margin : 10px auto;
            color: #fff;
            background-color: #555;
        }

        /* Button Styles */
.action-button {
    background-color: #ffd700;
    color: #333;
    padding: 15px 10px;
    text-decoration: none;
    border-radius: 8px;
    display: block;
    margin: 10px auto; 
    transition: background-color 0.3s ease-in-out;
    font-size: 16px;
    font-weight: bold;
    border: 2px solid #ffd700;
    cursor: pointer;
}
        .action-button:hover {
            background-color: #333;
            color: #ffd700;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
        
         label {
         margin : 10px auto;
        }
        
    </style>
</head>
<body>
<body>
    <header>
        <h1>Student Housing</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="dorm_map.php">Dorm Map</a>
        
    </nav>

    <h2>User Profile</h2>
    
    <div class="main-content">
        <label for="academic_id">Academic ID:</label>
        <p><?php echo $user['academic_id']; ?></p>

        <label for="national_id">National ID:</label>
        <p><?php echo $user['national_id']; ?></p>

        <label for="name">Name:</label>
        <p><?php echo $user['name']; ?></p>

        <label for="college_name">College Name:</label>
        <p><?php echo $user['college_name']; ?></p>

        <label for="room_number">Room Number:</label>
        <p><?php echo $user['room_number']; ?></p>
    </div>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
