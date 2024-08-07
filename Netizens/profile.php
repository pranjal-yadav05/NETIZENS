<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

// Assuming you have established a database connection
$connection = mysqli_connect("sql213.epizy.com","epiz_34245275","jj3pkWgQvydF","epiz_34245275_netizens");

// Retrieve the user's ID from the session
$userId = $_SESSION['user_id'];

// Retrieve the user's data from the users table
$query = "SELECT * FROM users WHERE user_id = $userId";
$result = mysqli_query($connection, $query);

// Check if the user exists
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle the case when the user is not found
    echo "User Not Found";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // Check if the username is changed
    if ($user['username'] !== $username) {
        // Update the username in the database
        $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username' AND user_id != $userId";
        $checkUsernameResult = mysqli_query($connection, $checkUsernameQuery);

        if (mysqli_num_rows($checkUsernameResult) > 0) {
            // Username already exists
            $errorMessage = "Username already exists. Please choose a different username.";
        } else {
            $updateQuery = "UPDATE users SET username = '$username' WHERE user_id = $userId";
            $updateResult = mysqli_query($connection, $updateQuery);

            if ($updateResult) {
                $successMessage = "Profile updated successfully";
            } else {
                $errorMessage = "Error updating profile: " . mysqli_error($connection);
            }
        }
    }

    // Check if a new profile photo is uploaded
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_photo'];
        $filename = $file['name'];
        $tmpFilePath = $file['tmp_name'];

        echo "<script>alert('Wait for it to upload, do not refresh :)');</script>";

        // Read the contents of the uploaded file
        $fileContent = file_get_contents($tmpFilePath);

        // Update the profile photo in the database
        $query = "UPDATE users SET profile_pic = ? WHERE user_id = $userId";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, 's', $fileContent);
        mysqli_stmt_execute($statement);
    }

    // Redirect to the profile page
    header("Location: profile.php");
    exit;
}

// Close the database connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
     <link rel="icon" type="image/png" href="user.png"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
 @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Passion+One&display=swap');

    html, body {
        width: 100%;
        height: 100%;
    }
    body {
        font-family: 'Roboto Condensed', sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        padding-top: 20px;
        background-color: #2b6777;
    }

    h1 {
        text-align: center;
        padding: 20px;
        background-color: #2b6777;
        color: #ffffff;
        width: 100vw;
        margin: 0;
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

    .butt {
        display: flex;
        justify-content: center;
    }

    .container {
        width: 100%;
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        height: fit-content;
        position: relative;
    }

    h2 {
        text-align: center;
        margin-top: 0;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    .top {
        position: relative;
        display: flex;
        align-items: center;
        justify-content:center;
    }

    .profile-pic {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .arrow {
        width: 30px;
        height: 30px;
        margin-right: 10px;
        position: absolute;
        left: 0;
        top: 0;
    }

    .top-right {
        color: #ffffff;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
        border: 1px solid #c8d8e4;
        border-radius: 4px;
    }

    form {
        margin-top: 20px;
        position: relative;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #52ab98;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #2b6777;
    }

    .error-message,
    .success-message {
        text-align: center;
        margin-top: 10px;
        color: #333;
    }


</style>
<body>
    <div class="heading">
        <img class="logo" />
        NETIZENS
    </div>
    <div class="container">
        <div class="top">
            <div class="arr">
                <a href="index.php"><img class="arrow" src="arrow.png" alt="Back to Home"></a>
            </div>
            <div class="profile-pic-container">
                <img class="profile-pic" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($user['profile_pic']); ?>" alt="Profile Picture">
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>

            <label for="profile_photo">Profile Photo:</label>
            <input type="file" id="profile_photo" name="profile_photo"><br><br>
            <div class="butt">
                <button type="submit">Update Profile</button>
            </div>
        </form>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
        <?php if (isset($successMessage)) { ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php } ?>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php } ?>
    </div>
</body>
</html>


