<?php
// Assuming you have established a database connection
$connection = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

if (isset($_GET['friend_id'])) {
    $friendId = $_GET['friend_id'];

    // Retrieve the logged-in user's ID from the session
    session_start();
    $userId = $_SESSION['user_id'];

    // Retrieve the friend's username from the users table
    $query = "SELECT username FROM users WHERE user_id = $friendId";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $friend = mysqli_fetch_assoc($result);
        $friendUsername = $friend['username'];

        // Retrieve the chat messages
        $query = "SELECT m.*, u.username 
                  FROM messages m
                  INNER JOIN users u ON m.sender_id = u.user_id
                  WHERE (m.sender_id = $userId AND m.receiver_id = $friendId) OR (m.sender_id = $friendId AND m.receiver_id = $userId) 
                  ORDER BY m.message_id ASC";
        $result = mysqli_query($connection, $query);

        // Store the messages in an array
        $messages = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $message = array(
                'sender_label' => ($row['sender_id'] == $userId) ? 'You' : $friendUsername,
                'message' => $row['message'],
                'timestamp' => $row['timestamp']
            );
            $messages[] = $message;
        }

        // Send the messages as JSON response
        header('Content-Type: application/json');
        echo json_encode($messages);
    }
}

// Close the database connection
mysqli_close($connection);
?>
