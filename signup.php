<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');

* {
    box-sizing: border-box;
}

body {
    font-family: 'Roboto Condensed', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: linear-gradient(45deg, #2b6777, #c8d8e4, #ffffff, #f2f2f2, #52ab98);
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
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    color: #ffffff;
    background: linear-gradient(45deg, #2b6777, #c8d8e4);
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    font-size: 24px;
}

.container {
    max-width: 600px;
    width: 90%;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    font-size: 16px;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
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
input[type="email"],
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
    width: 100%;
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

.error,
#error {
    color: red;
    margin-top: 10px;
    text-align: center;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .heading {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .container {
        margin-top: 20px;
        font-size: 14px;
    }
}

    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="heading">
        <img class="logo" />
        GET YOUR NETIZENSHIP
    </div>
    <div class="container">
       <h2>Sign Up</h2>
        <form method="POST" action="signup.php" autocomplete="off">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Sign up</button>
            <h4>Already a Netizen? <a href="signin.php">Sign in here</a></h4>
        </form>
        <?php
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate the form data (you can add more validation if needed)
            if (!empty($username) && !empty($email) && !empty($password)) {
                // Check password strength
                $passwordStrength = passwordStrengthCheck($password);

                if ($passwordStrength !== 'strong') {
                    // Weak password
                    echo "Weak password. Your password should contain at least 8 characters, including lowercase and uppercase letters, numbers, and special characters.";
                    return;
                }

                // Connect to the database (replace with your database credentials)
                $conn = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if the username already exists
                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Username already exists
                    echo "Username already exists.";
                } else {
                    // Check if the email already exists
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Email already exists
                        echo "Email already exists.";
                    } else {
                        // Generate a hashed password
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // Insert the data into the database
                        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

                        if ($conn->query($sql) === TRUE) {
                            // Registration successful
                            echo "Registration successful. Please sign in.";
                            // Redirect to the signin page
                            header("Location: signin.php");
                            exit();
                        } else {
                            // Error inserting data
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }

                // Close the database connection
                $conn->close();
            } else {
                // Form data is not complete
                echo "Please fill in all the required fields.";
            }
        }

        // Function to check password strength
        function passwordStrengthCheck($password)
        {
            // Check if the password meets the desired strength criteria
            $hasUppercase = preg_match('/[A-Z]/', $password);
            $hasLowercase = preg_match('/[a-z]/', $password);
            $hasNumber = preg_match('/\d/', $password);
            $hasSpecialChar = preg_match('/[^A-Za-z0-9]/', $password);

            if (strlen($password) >= 8 && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar) {
                return 'strong';
            } else {
                return 'weak';
            }
        }
        ?>

    </div>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>