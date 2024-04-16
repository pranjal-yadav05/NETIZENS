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

if(isset($_POST['friends'])){
    header("Location: friend_request.php");
}

if(isset($_POST['setting'])){
    header("Location: settings.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETIZENS</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
        body, html {
            height: 100%;
        }

        body {
            font-family: 'Roboto Condensed', sans-serif;
            display: flex;
            margin: 0;
            align-items: center;
            height: 100%;
            width: 100vw;
            flex-direction: column;
            padding: 0;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #2b6777;
            color: #ffffff;
            width: 100vw;
        }

        .container {
            max-width: 600px;
            border-radius: 15px;
            margin: 20px 50px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
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
            margin: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #52ab98;
            transform: scale(1.05);
        }

        /* Rest of your styles ... */

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
        
    .profile-pic {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .friend-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

        .request-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    }
    #friend {
    position: relative;
    }
    .no-requests {
            text-align: center;
    }

    </style>
</head>
<body>
    <h1>Netizens Unleashed: Where Chat Knows No Bounds!</h1>
    <div class="container">
        <form method="post">
           <button id="sgnout" name="signout">Sign out</button>
         <?php
        // Assuming you have established a database connection
        $conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");
        $loggedInUserId=$_SESSION['user_id'];
        // Get the number of friend requests
        $query = "SELECT COUNT(*) AS request_count FROM friend_requests WHERE receiver_id = $loggedInUserId AND request_status = 'pending'";
        $requestResult = mysqli_query($conn, $query);

        if ($requestResult) {
            $requestCount = mysqli_fetch_assoc($requestResult)['request_count'];

            // Display the friend requests button with the request count
            echo "<button id='friend' name='friends'>Friend Requests";
            if ($requestCount > 0) {
                echo " <span class='request-count'>$requestCount</span>";
            }
            echo "</button>";
        } else {
            echo "Error retrieving friend requests: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

            <button id="friend" name="setting">Settings</button> 
        </form>
        <div class="friend-list">
            <h3>Friends List:</h3>
            <?php
            // Assuming you have established a database connection
            $conn=mysqli_connect("sql213.epizy.com","epiz_34245275","jj3pkWgQvydF","epiz_34245275_netizens");

            // Retrieve the list of friends from the database
            $loggedInUserId = $_SESSION['user_id']; // Replace with your own code to get the logged-in user's ID
            $query = "SELECT * FROM friends WHERE user_id_1 = $loggedInUserId OR user_id_2 = $loggedInUserId";
            $result = mysqli_query($conn, $query);

            
            // Display each friend as a clickable link
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $friendId = ($row['user_id_1'] == $loggedInUserId) ? $row['user_id_2'] : $row['user_id_1'];
                    $friendQuery = "SELECT username, profile_pic FROM users WHERE user_id = $friendId";
                    $friendResult = mysqli_query($conn, $friendQuery);
                    
                    if ($friendData = mysqli_fetch_assoc($friendResult)) {
                        $friendUsername = $friendData['username'];
                        $friendProfilePic = $friendData['profile_pic'];
                        echo "<a class='friend-item' href='room.php?friend_id=$friendId'><img class='profile-pic' src='data:image/jpeg;base64," . base64_encode($friendProfilePic) . "'/><span>$friendUsername</span></a>";
                    }
                }
            } else {
                echo "<div class='no-requests'>Seems like you are alone :(</div>";
            }



            // Close the database connection
            mysqli_close($conn);
            ?>
            <div class="add-friend-button">
                <a href="add_friend.php"><button>Add Friend</button></a>
            </div>
        </div>
    </div>
</body>
</html>