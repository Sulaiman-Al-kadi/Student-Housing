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
        }

        p {
            line-height: 1.6;
            color: #555;
        }

        
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
    display: block;
    margin-bottom: 8px;
}

      
        img {
  display: inline-block;
}
    </style>
</head>

<body>
    <header>
        <h1>Student Housing</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="dorm_map.php">Dorm Map</a>
    </nav>

        <div class="main-content">
            <h2>Dorm Map</h2>
            <p>
                Navigate our dorm's map
            </p>
            <img src="images/SA_Housing_ResidenceHall_FloorPlans_Featherman.jpg" alt="" width="1100">
            
        </div>




</body>

</html>