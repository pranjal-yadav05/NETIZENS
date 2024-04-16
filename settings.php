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

if (isset($_POST['profile'])) {
    header("Location: profile.php");
}

if (isset($_POST['home'])) {
    header("Location: index.php");
}

// Assuming you have established a database connection
$conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

$loggedInUserId = $_SESSION['user_id'];

// Retrieve the user's friends from the database
$query = "SELECT users.user_id, users.username
          FROM friends
          INNER JOIN users ON (friends.user_id_2 = users.user_id AND friends.user_id_1 = $loggedInUserId)
          OR (friends.user_id_1 = users.user_id AND friends.user_id_2 = $loggedInUserId)";

$friendsResult = mysqli_query($conn, $query);

// Check for query execution errors
if (!$friendsResult) {
    echo "Error executing query: " . mysqli_error($conn);
    exit();
}

if (isset($_POST['delete'])) {
    $friendId = $_POST['friend_id'];
    
    // Delete the friend from the friends table
    $deleteFriendQuery = "DELETE FROM friends WHERE (user_id_1 = $loggedInUserId AND user_id_2 = $friendId) OR (user_id_1 = $friendId  AND user_id_2 = $loggedInUserId) ";
    $deleteFriendResult = mysqli_query($conn, $deleteFriendQuery);
    
    if ($deleteFriendResult) {
        // Delete the corresponding chat
        $deleteChatQuery = "DELETE FROM messages WHERE (sender_id = $loggedInUserId AND receiver_id = $friendId) OR (sender_id = $friendId AND receiver_id = $loggedInUserId)";
        $deleteChatResult = mysqli_query($conn, $deleteChatQuery);
        
        if ($deleteChatResult) {
            header("Location: settings.php");
        } else {
            echo "Error deleting chat: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting friend: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETIZENS - Settings</title>
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
            border-radius: 15px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        form button{
            margin: 0 3px;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        button {
            background-color: #2b6777;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #52ab98;
            transform: scale(1.05);
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
            color: #2b6777;
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

        .delete-button {
            background-color: #f2f2f2;
            color: #2b6777;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #c8d8e4;
        }

        .no-friends {
            text-align: center;
            color: #888;
            padding: 20px 0;
        }


    </style>
</head>
<body>
    <h1>NETIZENS - Settings</h1>
    <div class="container">
        <form method="post">
            <button id="sgnout" name="signout">Sign out</button>
            <button id="prof" name="profile">Edit Profile</button>
            <button name="home">Home</button>
        </form>
        <div class="friend-list">
            <h3>Friends:</h3>
            <?php
            if (mysqli_num_rows($friendsResult) > 0) {
                // Display each friend
                while ($row = mysqli_fetch_assoc($friendsResult)) {
                    $friendId = $row['user_id'];
                    $friendUsername = $row['username'];
                    echo "<div class='friend-item'>";
                    echo "<span class='friend-name'>$friendUsername</span>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='friend_id' value='$friendId'>";
                    echo "<button class='delete-button' type='submit' name='delete'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<div class='no-friends'>You have no friends yet.</div>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
