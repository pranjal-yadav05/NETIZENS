<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    }
    if (isset($_POST['signout'])) {
        session_destroy();
        header("Location: signin.php");
        exit();
    }

    if (isset($_POST['settings'])) {
        header("Location: settings.php");
    }

    if (isset($_POST['home'])) {
        header("Location: index.php");
    }

    
    ?>
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
    @import url('https://fonts.googleapis.com/css2?family=Passion+One&display=swap');
    body, html {
            height: 100%;
    }
    body {
         background: linear-gradient(45deg, #2b6777, #c8d8e4, #ffffff, #f2f2f2, #52ab98);
        background-color: #f2f2f2;
        font-family: 'Roboto Condensed', sans-serif;
        margin: 0;
        padding: 0;
        padding-top: 20px;
    }

    h1 {
        text-align: center;
        margin: 0;
        font-size:28px;
        padding: 20px;
        background-color: #2b6777;
        color: #ffffff;
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
    .container {
        width: 100%;
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
       .container {
            border-radius: 15px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
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

    .topbar{
        justify-content:space-between;
    }

    .topbar button {
        background-color: #2b6777;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .topbar button:hover {
        background-color: #52ab98;
        transform: scale(1.05);
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

    /* Additional styling for suggestions container */
    .suggestions-container {
        padding:20px;
        margin: 50px auto;
        width:70%;
        max-width: 400px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .suggestions-list {
        list-style-type: none;
        padding: 0;
    }

    .suggestions-list li {
        display: flex;
        align-items: center;
         justify-content: space-between; 
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-info span {
        font-weight: bold;
    }

    .ask-button {
        margin-left: auto; /* Push the button to the right */
    }
    .requested-button {
        background-color: #ccc;
        color: #666;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: not-allowed;
    }
    .logo {
            width: 35px;
            height: 35px;
            border-radius: 17px;
            background-image: url("user.png");
            background-size: cover;
            margin-right: 10px;
        }

        .heading {
            font-family: 'Passion One', cursive;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: black;
            background: linear-gradient(45deg, #2b6777, #c8d8e4);
            padding: 17px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            font-size: 50px;
            width:fit-content;
            /* margin:auto; */
            width: 70%;
            max-width: 400px;
            margin: 25px auto;
            
        }
        

    </style>
</head>
<body>
     <div class="heading">
            <img class="logo" />
            NETIZENS
    </div>
    <div class="container">
         <form class="topbar" method="post">
            <button name="home">Home</button>
            <button id="sgnout" name="signout">Sign out</button>
            <button id="prof" name="settings">Settings</button>
        </form>
        <h2>Add Friend</h2><br>
        <form method="POST">
            <div class="form-group">
                <label for="friend_id">Friend's Username:</label>
                <input type="text" id="friend_id" name="friend_name" required>
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

            $friendName = isset($_POST['friend_name']);

            // Assuming the currently logged-in user's ID is stored in the variable $loggedInUserId
            $loggedInUserId = $_SESSION['user_id']; // Replace with your own code to get the logged-in user's ID

            if (isset($_POST['sub'])) {
                $friendName = $_POST['friend_name']; // Ensure this is correctly retrieved from the form submission
                if (empty($friendName)) {
                    echo "<p class='error-message'>Friend's Username is required</p>";
                } else {
                    // Prepare a statement to select the user_id based on username
                    $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ?");
                    
                    // Bind the parameters
                    mysqli_stmt_bind_param($stmt, "s", $friendName);
                    
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
                    
                    // Store the result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if the username exists
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $friend_id);
                        
                        // Fetch the result
                        mysqli_stmt_fetch($stmt);
                        
                        // Check if the friend request already exists
                        $sql = "SELECT * FROM friend_requests WHERE sender_id = ? AND receiver_id = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "ii", $loggedInUserId, $friend_id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) > 0) {
                            // Friend request already exists
                            echo "<p class='error-message'>Friend request already sent</p>";
                        } else {
                            // Check if the users are already friends
                            $sql = "SELECT * FROM friends WHERE (user_id_1 = ? AND user_id_2 = ?) OR (user_id_1 = ? AND user_id_2 = ?)";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "iiii", $loggedInUserId, $friend_id, $friend_id, $loggedInUserId);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) > 0) {
                                // Users are already friends
                                echo "<p class='error-message'>You are already friends with this user</p>";
                            } else {
                                // Insert the friend request into the friend_requests table
                                $sql = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "ii", $loggedInUserId, $friend_id);
                                if (mysqli_stmt_execute($stmt)) {
                                    echo "<p class='success-message'>Friend request sent successfully</p>";
                                } else {
                                    echo "<p class='error-message'>Error sending friend request: " . mysqli_error($conn) . "</p>";
                                }
                            }
                        }
                    } else {
                        // Username does not exist
                        echo "<p class='error-message'>User not found</p>";
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt);
                }
            }

            // Close the database connection
            mysqli_close($conn);
            } else {
                echo "<script>alert('You are not signed in!');</script>";
        }


        if (isset($_POST['ask'])) {
            // Establish a database connection
            $conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

            // Retrieve the friend ID from the POST data
            $friendId = $_POST['ask'];

            // Prepare a statement to check if the friend request already exists
            $sql = "SELECT * FROM friend_requests WHERE sender_id = ? AND receiver_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $loggedInUserId, $friendId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                // Friend request already exists
                echo "<p class='error-message'>Friend request already sent</p>";
            } else {
                // Prepare a statement to check if the users are already friends
                $sql = "SELECT * FROM friends WHERE (user_id_1 = ? AND user_id_2 = ?) OR (user_id_1 = ? AND user_id_2 = ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "iiii", $loggedInUserId, $friendId, $friendId, $loggedInUserId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Users are already friends
                    echo "<p class='error-message'>You are already friends with this user</p>";
                } else {
                    // Prepare a statement to insert the friend request into the friend_requests table
                    $sql = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ii", $loggedInUserId, $friendId);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<p class='success-message'>Friend request sent successfully</p>";
                    } else {
                        echo "<p class='error-message'>Error sending friend request: " . mysqli_error($conn) . "</p>";
                    }
                }
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            // Close the database connection
            mysqli_close($conn);
        } elseif (isset($_POST['cancel'])) {
            // Establish a database connection
            $conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

            // Retrieve the friend ID from the POST data
            $friendId = $_POST['cancel'];

            // Prepare a statement to delete the friend request from the friend_requests table
            $sql = "DELETE FROM friend_requests WHERE sender_id = ? AND receiver_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $loggedInUserId, $friendId);
            if (mysqli_stmt_execute($stmt)) {
                echo "<p class='success-message'>Friend request cancelled successfully</p>";
            } else {
                echo "<p class='error-message'>Error cancelling friend request: " . mysqli_error($conn) . "</p>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            // Close the database connection
            mysqli_close($conn);
        }


        ?>

    </div>

    <div class="suggestions-container">
        <h2>Suggestions:</h2>
        <ul class="suggestions-list">
           <?php
            // Establish a database connection
            $conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

            // Get the currently logged-in user's ID
            $loggedInUserId = $_SESSION['user_id'];

            // Prepare a statement to retrieve suggestions
            $sql = "SELECT DISTINCT users.user_id, users.username, users.profile_pic
                    FROM friends AS f1
                    INNER JOIN friends AS f2 ON f1.user_id_2 = f2.user_id_1
                    INNER JOIN users ON f2.user_id_2 = users.user_id
                    WHERE f1.user_id_1 = ?
                    AND NOT EXISTS (
                        SELECT 1
                        FROM friends AS f3
                        WHERE f3.user_id_1 = ?
                        AND f3.user_id_2 = users.user_id
                    )
                    AND users.user_id <> ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iii", $loggedInUserId, $loggedInUserId, $loggedInUserId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            

            if (mysqli_num_rows($result) > 0) {
                while ($user = mysqli_fetch_assoc($result)) {
                    $profilePic = $user['profile_pic'];

                    if (!empty($profilePic)) {
                        // If profile picture is available, use it
                        $imgSrc = 'data:image/jpeg;base64,' . base64_encode($profilePic);
                    } else {
                        // If profile picture is not available, use default image
                        $imgSrc = 'default.jpg'; // Change this to the path of your default image
                    }

                    echo "<li>";
                    echo "<div class='user-info'>";
                    // Assuming you have a profile photo URL in the user's data
                    echo "<img src='{$imgSrc}' alt='Profile Photo'>";
                    echo "<span>" . htmlspecialchars($user['username']) . "</span>";
                    echo "</div>";

                    // Prepare a statement to check if a friend request has already been sent to this user
                    $sql = "SELECT * FROM friend_requests WHERE sender_id = ? AND receiver_id = ?";
                    $requestStmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($requestStmt, "ii", $loggedInUserId, $user['user_id']);
                    mysqli_stmt_execute($requestStmt);
                    $requestResult = mysqli_stmt_get_result($requestStmt);

                    if (mysqli_num_rows($requestResult) > 0) {
                        // If a request exists, show "Requested"
                        echo "<form method='POST'><button type='submit' name='cancel' value='" . $user['user_id'] . "' class='requested-button'>Requested</button></form>";
                    } else {
                        // If no request exists, show the "Ask" button
                        echo "<form method='POST'><input type='hidden' name='ask' value='" . $user['user_id'] . "'><button type='submit' name='ask' value='" . $user['user_id'] . "' class='ask-button'>Ask</button></form>";
                    }
                    echo "</li>";
                }
            } else {
                echo "<p>No suggestions found.</p>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            // Close the database connection
            mysqli_close($conn);
            ?>

        </ul>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
