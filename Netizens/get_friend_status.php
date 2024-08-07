<?php
session_start();

// Assuming you have established a database connection
$connection = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

// Retrieve the friend's ID from the GET parameters
if (isset($_GET['friend_id'])) {
    $friendId = $_GET['friend_id'];

    // Query the database to get the friend's online status
    $query = "SELECT status FROM users WHERE user_id = $friendId";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];

        // Return the friend's online status as JSON
        echo json_encode($status);
    } else {
        // If the friend's online status is not found, return 'offline'
        echo json_encode('offline');
    }
} else {
    // If the friend's ID is not provided, return an error
    echo json_encode('error');
}

// Close the database connection
mysqli_close($connection);
?>
