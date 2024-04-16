<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php error_reporting(0); ?>
<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    }?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Friend</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    body {
        background-color: #f2f2f2;
        font-family: 'Roboto Condensed', sans-serif;
        margin: 0;
        padding: 0;
        padding-top: 20px;
    }

    h1 {
        text-align: center;
        margin: 0;
        padding: 20px;
        background-color: #2b6777;
        color: #ffffff;
    }

    .container {
        width: 100%;
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #c8d8e4;
        border-radius: 4px;
        box-sizing: border-box;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #c8d8e4;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: #52ab98;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        align-self: center;
    }

    .error-message {
        color: red;
        margin-top: 10px;
        text-align: center;
    }

    .success-message {
        color: green;
        margin-top: 10px;
        text-align: center;
    }

    /* Responsive Styles */
    @media (max-width: 700px) {
        .container {
            width: 70%;
            margin: 50px auto;
        }
    }
    </style>
</head>
<body>
    <h1>MEET OTHER NETIZENS</h1>
    <div class="container">
        <h2>Add Friend</h2><br>
        <form method="POST">
        <div class="form-group">
            <label for="friend_name">Friend's Username:</label>
            <input type="text" id="friend_name" name="friend_name" required>
        </div> 
        
        <div id="butt" class="form-group">
            <button type="submit" name="sub">Add Friend</button>
        </div>
        </form>
        <?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Assuming you have established a database connection
    $conn=mysqli_connect("sql213.epizy.com","epiz_34245275","jj3pkWgQvydF","epiz_34245275_netizens");

    // Retrieve friend details from the form
    $friendName = $_POST['friend_name'];

    // Assuming the currently logged-in user's ID is stored in the variable $loggedInUserId
    $loggedInUserId = $_SESSION['user_id']; // Replace with your own code to get the logged-in user's ID

    $row = mysqli_query($conn, "SELECT user_id FROM users WHERE username = '$friendName'");
    $friend = mysqli_fetch_assoc($row);
    $friend_id = $friend['user_id'];

    if (isset($_POST['sub'])) {
        if (empty($friendName)) {
            echo "<p class='error-message'>Friend's Username is required</p>";
        } else {
            // Check if the friend request already exists
            $sql = "SELECT * FROM friend_requests WHERE sender_id = $loggedInUserId AND receiver_id = $friend_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Friend request already exists
                echo "<p class='error-message'>Friend request already sent</p>";
            } else {
                // Check if the users are already friends
                $sql = "SELECT * FROM friends WHERE (user_id_1 = $loggedInUserId AND user_id_2 = $friend_id) OR (user_id_1 = $friend_id AND user_id_2 = $loggedInUserId)";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Users are already friends
                    echo "<p class='error-message'>You are already friends with this user</p>";
                } else {
                    // Insert the friend request into the friend_requests table
                    $sql = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES ('$loggedInUserId', '$friend_id')";
                    if (mysqli_query($conn, $sql)) {
                        echo "<p class='success-message'>Friend request sent successfully</p>";
                    } else {
                        echo "<p class='error-message'>Error sending friend request: " . mysqli_error($conn) . "</p>";
                    }
                }
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "<script>alert('You are not signed in!');</script>";
}
?>

    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
