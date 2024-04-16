<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (isset($_POST['signout'])) {
    session_destroy();
    header("Location: signin.php");
    exit();
}
if(isset($_POST['profile'])){
    header("Location: profile.php");
}

if(isset($_POST['home'])){
    header("Location: index.php");
}

// Assuming you have established a database connection
$conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

// Retrieve friend requests from the database
$loggedInUserId = $_SESSION['user_id'];
$query = "SELECT * FROM friend_requests WHERE receiver_id = $loggedInUserId";
$requestResult = mysqli_query($conn, $query);

// Check for query execution errors
if (!$requestResult) {
    echo "Error executing query: " . mysqli_error($conn);
    exit();
}

// Handle friend request approval
if (isset($_POST['approve'])) {
    $requestId = $_POST['request_id'];

    // Retrieve the friend request details
    $getRequestQuery = "SELECT * FROM friend_requests WHERE request_id = '$requestId'";
    $getRequestResult = mysqli_query($conn, $getRequestQuery);
    $requestRow = mysqli_fetch_assoc($getRequestResult);
    $senderId = $requestRow['sender_id'];

    // Insert the friend into the friends table
    $insertFriendQuery = "INSERT INTO friends (user_id_1, user_id_2) VALUES ('$loggedInUserId', '$senderId')";
    $insertFriendResult = mysqli_query($conn, $insertFriendQuery);

    if ($insertFriendResult) {
        // Delete the friend request from the friend_requests table
        $deleteRequestQuery = "DELETE FROM friend_requests WHERE request_id = '$requestId'";
        $deleteRequestResult = mysqli_query($conn, $deleteRequestQuery);

        if ($deleteRequestResult) {
            header("Location: friend_request.php");
        } else {
            echo "Error deleting friend request: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting friend into friends table: " . mysqli_error($conn);
    }
}

// Handle friend request disapproval
// Handle friend request disapproval
if (isset($_POST['reject'])) {
    $requestId = $_POST['request_id'];
    
    // Delete the friend request from the friend_requests table
    $deleteRequestQuery = "DELETE FROM friend_requests WHERE request_id = '$requestId'";
    $deleteRequestResult = mysqli_query($conn, $deleteRequestQuery);
    
    if ($deleteRequestResult) {
        header("Location: friend_request.php");
    } else {
        echo "Error deleting friend request: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETIZENS - Friend Requests</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
        body {
            font-family: 'Roboto Condensed', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #2b6777;
            color: #ffffff;
        }

        .container {
            max-width: 600px;
            border-radius:15px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button {
            background-color: #2b6777;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #52ab98;
        }

        .friend-list {
            margin-top: 20px;
        }

        .friend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .friend-name {
            margin-right: 10px;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #2b6777;
            font-weight: bold;
        }

        a:hover {
            color: #52ab98;
        }
        
        .add-friend-button {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .add-friend-button button {
            background-color: #f2f2f2;
            color: #2b6777;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-friend-button button:hover {
            background-color: #c8d8e4;
        }

        .request-list {
            margin-top: 20px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 4px;
        }

        .request-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .request-info {
            display: flex;
            align-items: center;
        }

        .request-name {
            margin-right: 10px;
        }

        .request-actions {
            display: flex;
        }

        .request-actions button {
            margin-right: 10px;
        }

        .no-requests {
            text-align: center;
        }

    </style>
</head>
<body>
    <h1>NETIZENS - Friend Requests</h1>
    <div class="container">
        <form method="post">
            <button id="sgnout" name="signout">Sign out</button>
            <button id="prof" name="profile">Edit Profile</button>
            <button name="home">Home</button>
        </form>
        <div class="request-list">
            <h3>Friend Requests:</h3>
            <?php
            if (mysqli_num_rows($requestResult) > 0) {
                // Display each friend request
                while ($row = mysqli_fetch_assoc($requestResult)) {
                    $requestId = $row['request_id'];
                    $senderId = $row['sender_id'];
                    $query = "SELECT username FROM users WHERE user_id = $senderId";
                    $senderResult = mysqli_query($conn, $query);
                    $senderUsername = mysqli_fetch_assoc($senderResult)['username'];
                    echo "<div class='request-item'>";
                    echo "<div class='request-info'>";
                    echo "<span class='request-name'>$senderUsername</span>";
                    echo "</div>";
                    echo "<div class='request-actions'>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='request_id' value='$requestId'>";
                    echo "<button type='submit' name='approve'>Approve</button>";
                    echo "<button type='submit' name='reject'>Reject</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='no-requests'>You are done!</div>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
