<?php
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted verification code
    $verificationCode = $_POST['verification_code'];

    // Compare the submitted verification code with the one stored in the session
    if ($verificationCode == $_SESSION['verification_code']) {
        // Verification code is correct, store the email in the database

        // Retrieve the email from the session
        $email = $_SESSION['email'];

        // Store the email in the users table
        $query = "INSERT INTO users (email) VALUES (:email)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Redirect to the signin page or display a success message
        echo "Signup successful! Please proceed to signin.";
        exit;
    } else {
        // Verification code is incorrect
        echo "Incorrect verification code.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify</title>
</head>
<body>
    <h1>Verify</h1>
    <form method="POST" action="">
        <label for="verification_code">Verification Code:</label>
        <input type="text" name="verification_code" id="verification_code" required>

        <button type="submit">Verify</button>
    </form>
</body>
</html>
