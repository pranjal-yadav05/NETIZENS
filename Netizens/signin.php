<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Passion+One&display=swap');



    body,html{
        width:100%;
        height:100%;
    }
    body {
        background: linear-gradient(45deg, #2b6777, #c8d8e4, #ffffff, #f2f2f2, #52ab98);
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
        display: flex;
        align-items: center;
        justify-content: center;
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
        margin: 50px auto;
        
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
    input[type="password"] {
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

    h4 {
        text-align: center;
        color: #333;
        margin-top: 20px;
    }

    a {
        color: #52ab98;
        text-decoration: none;
    }

    #error {
        color: red;
        margin-top: 10px;
    }

    /* Responsive Styles */
    @media (max-width: 700px) {
        .heading,.container {
            width: 70%;
            margin: 50px auto;

        }
        
    }
    @media (max-width: 320px){
        .heading img{
            display: none;
        }
    }
    /* @media (max-width: 768px) {
        .heading {
            font-size: 32px;
        }
    } */
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <div class="heading">
        <img class="logo" />
        NETIZENS
  </div>
  <div class="container">
    <h2>Sign In</h2>
    <form method="POST" autocomplete="off" action="signin.php">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div id="butt" class="form-group">
        <button type="submit">Sign In</button>
      </div>
      <h4>Not a Netizen?<a href="signup.php"> Get your Netizenship here</a></h4>
      <?php
session_start();

// Assuming you have established a database connection
$connection = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password (you can customize this validation as per your requirements)

    // Query the database to check if the user exists
    $query = "SELECT user_id, password FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // If the password is correct, set the 'user_id' session variable and redirect to the chat page
            $user_id = $row['user_id'];
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
            exit;
        } else {
            // If the password is incorrect, show an error message
            echo "Invalid username or password.";
        }
    } else {
        // If the user doesn't exist, show an error message
        echo "Invalid username or password.";
    }
}
?>

    </form>
  </div>
</body>
</html>
