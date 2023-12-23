<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the login form
    $academicId = $_POST['academic_id'];
    $password = $_POST['password'];

    // SQL query to check if the user exists
    $sql = "SELECT * FROM users WHERE academic_id = '$academicId' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['academic_id'] = $academicId;
        header("Location: index.php"); 
        exit();
    } else {
        // User not found, display an error message
        $error_message = "Invalid academic ID or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Housing</title>
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
        .login-content {
            max-width: 40%;
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
            margin: 10px auto;
        }

        p {
            line-height: 1.6;
            color: #555;
        }

        /* Button Styles */
.action-button {
    background-color:  #333;
    color: #fff;
    padding: 15px 10px;
    text-decoration: none;
    border-radius: 8px;
    display: block;
    margin: 10px auto;
    transition: background-color 0.3s ease-in-out;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}
        .action-button:hover {
            background-color: #333;
            color: #820300;
        }


        .login-info {
    max-width: 400px;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

    </style>
</head>

<body>
    <header>
        <h1>Student Housing</h1>
    </header>



    <div class="login-content">

        <!-- Request a Room Section -->
        <?php if (isset($error_message)) { ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="academic_id">Academic ID:</label>
        <input type="text" name="academic_id" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
      

</body>

</html>
