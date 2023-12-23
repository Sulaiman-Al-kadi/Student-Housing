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

$sqlFloors = "SELECT DISTINCT floor_number FROM rooms";
$resultFloors = $conn->query($sqlFloors);

if (!$resultFloors) {
    die("Error fetching floors: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['floor_number'])) {
    $selectedFloor = $_POST['floor_number'];
    $sqlRooms = "SELECT room_number, max_capacity, current_occupancy FROM rooms WHERE floor_number = '$selectedFloor' AND status = 'available'";
    $resultRooms = $conn->query($sqlRooms);

    if (!$resultRooms) {
        die("Error fetching rooms: " . $conn->error);
    }

    if ($resultRooms->num_rows === 0) {
        $noAvailableRooms = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user wants to book or cancel a room
    if (isset($_POST['book_room']) && isset($_POST['room_number'])) {
        // Check if the user has already booked a room
        if (!empty($user['room_number'])) {
            echo "You have already booked a room.";
        } else {
            $selectedRoom = $_POST['room_number'];

            // Check if the selected room is available
            $checkAvailabilitySql = "SELECT max_capacity, current_occupancy FROM rooms WHERE room_number = $selectedRoom AND status = 'available'";
            $availabilityResult = $conn->query($checkAvailabilitySql);

            if ($availabilityResult->num_rows > 0) {
                $roomData = $availabilityResult->fetch_assoc();
                $maxCapacity = $roomData['max_capacity'];
                $currentOccupancy = $roomData['current_occupancy'];

                // Check if the room has reached its capacity
                if ($currentOccupancy < $maxCapacity) {
                    // Increment current occupancy and update the user's record with the selected room
                    $updateSql = "UPDATE rooms SET current_occupancy = current_occupancy + 1 WHERE room_number = $selectedRoom";
                    if ($conn->query($updateSql) === TRUE) {
                        $updateUserSql = "UPDATE users SET room_number = $selectedRoom WHERE academic_id = '$academicId'";
                        if ($conn->query($updateUserSql) === TRUE) {
                            echo "Room booked successfully!";
                        } else {
                            echo "Error updating user record: " . $conn->error;
                        }
                    } else {
                        echo "Error updating room record: " . $conn->error;
                    }
                } else {
                    echo "Room has reached its capacity. Please choose another room.";
                }
            } else {
                echo "Selected room is not available.";
            }
        }
    } elseif (isset($_POST['cancel_booking'])) {
        // Check if the user has booked a room to cancel
        if (empty($user['room_number'])) {
            echo "You haven't booked a room to cancel.";
        } else {
            $canceledRoom = $user['room_number'];

            $cancelSql = "UPDATE rooms SET current_occupancy = current_occupancy - 1 WHERE room_number = $canceledRoom";
            if ($conn->query($cancelSql) === TRUE) {
                $clearUserRoomSql = "UPDATE users SET room_number = NULL WHERE academic_id = '$academicId'";
                if ($conn->query($clearUserRoomSql) === TRUE) {
                    echo "Room reservation canceled successfully!";
                } else {
                    echo "Error clearing user room record: " . $conn->error;
                }
            } else {
                echo "Error canceling room reservation: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Room Booking System</title>
</head>
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
        }

        p {
            line-height: 1.6;
            color: #555;
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


    </style>
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
        <h2>Welcome, <?php echo $user['name']; ?>!</h2>
        <h3>Room Booking System</h3>
        
        <form action="" method="post">
            <label for="floor" >Select Floor:</label>
            <select name="floor_number" id="floor" required>
                <?php
                while ($floor = $resultFloors->fetch_assoc()) {
                    echo "<option value='{$floor['floor_number']}'>Floor {$floor['floor_number']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="select_floor">Select Floor</button>
        </form>

        <?php if (isset($noAvailableRooms) && $noAvailableRooms) : ?>
            <p>No available rooms on this floor.</p>
        <?php endif; ?>

        <?php if (isset($resultRooms) && $resultRooms->num_rows > 0) : ?>
            <form action="" method="post">
                <label for="room">Select Room:</label>
                <select name="room_number" id="room" required>
                    <?php
                    while ($room = $resultRooms->fetch_assoc()) {
                        echo "<option value='{$room['room_number']}'>Room {$room['room_number']} (Capacity: {$room['max_capacity']})</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="book_room">Book Room</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($user['room_number'])) : ?>
            <form action="" method="post">
                <button type="submit" name="cancel_booking">Cancel Reservation</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>
