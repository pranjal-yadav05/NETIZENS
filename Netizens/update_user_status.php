<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_POST['online'])) {
    $user_id = $_SESSION['user_id'];
    $online = $_POST['online'] == 'true' ? 'online' : 'offline';
    
    // Assuming you have established a database connection
    $connection = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

    // Update the user's status
    $query = "UPDATE users SET status = '$online' WHERE user_id = $user_id";
    mysqli_query($connection, $query);
}
?>
