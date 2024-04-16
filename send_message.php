<?php
session_start();

// Assuming you have established a database connection
$connection = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

// Retrieve the logged-in user's ID from the session
if (isset($_SESSION['user_id']) && isset($_POST['friend_id']) && isset($_POST['message'])) {
    $userId = $_SESSION['user_id'];
    $friendId = $_POST['friend_id'];
    $message = $_POST['message'];

    // Insert the message into the messages table
    $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($userId, $friendId, '$message')";
    mysqli_query($connection, $query);

    // Close the database connection
    mysqli_close($connection);

    // Return a success response (you can modify this as per your needs)
    echo "Message sent successfully";
} else {
    // Return an error response (you can modify this as per your needs)
    echo "Error: Invalid parameters";
}
?>
