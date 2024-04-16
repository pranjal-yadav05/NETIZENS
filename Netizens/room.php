<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
// Assuming you have established a database connection
$connection = mysqli_connect("sql213.epizy.com", "epiz_34245275", "jj3pkWgQvydF", "epiz_34245275_netizens");

// Retrieve the logged-in user's ID from the session
if (isset($_SESSION['user_id']) && isset($_GET['friend_id'])) {
    $userId = $_SESSION['user_id'];
    $friendId = $_GET['friend_id'];

    // Retrieve the friend's username from the users table
    $query = "SELECT username, profile_pic FROM users WHERE user_id = $friendId";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $friend = mysqli_fetch_assoc($result);
        $friendUsername = $friend['username'];
        $friendProfilePic = $friend['profile_pic'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $_POST['message'];

            // Insert the message into the messages table
            $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($userId, $friendId, '$message')";
            mysqli_query($connection, $query);
        }

        // Retrieve and display the chat messages
        $query = "SELECT m.*, u.username 
                  FROM messages m
                  INNER JOIN users u ON m.sender_id = u.user_id
                  WHERE (m.sender_id = $userId AND m.receiver_id = $friendId) OR (m.sender_id = $friendId AND m.receiver_id = $userId) 
                  ORDER BY m.message_id ASC";
        $result = mysqli_query($connection, $query);
    } else {
        // Handle the case when the friend's username is not found
        $friendUsername = "Friend Not Found";
    }
} else {
    // Handle the case when 'user_id' or 'friend_id' is not set
    // Redirect to a login page or display an error message
    echo "Error: Invalid parameters";
    exit;
}

// Close the database connection
mysqli_close($connection);
?>

<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Chat</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
html, body {
            font-family: 'Roboto Condensed', sans-serif;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        a {
            text-decoration: none;
            color: black;
        }

        h2 {
            text-align: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100%;
            background-color: #2b6777;
            color: #ffffff;
        }

        .message-container {
            flex: 1;
            overflow-y: scroll;
            scroll-behavior: smooth;
            padding: 10px;
            margin-bottom: 60px; /* Add margin to accommodate input and send button */
        }

        .message-input-container {
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Adjust alignment to right */
            position: sticky;
            bottom: 0;
            background-color: #c8d8e4;
            padding: 10px;
        }

        .message-input-container input {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
            background-color: #ffffff;
        }

        .message-input-container button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #f2f2f2;
            color: #2b6777;
            font-size: 16px;
            cursor: pointer;
            max-width: 80px; /* Limit the width of the send button */
            white-space: nowrap; /* Prevent the button from wrapping to a new line */
            overflow: hidden; /* Hide any overflowing content */
            text-overflow: ellipsis; /* Display ellipsis (...) for overflowing content */
            position: relative; /* Add positioning context for the icon */
        }

        .button-text {
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px; /* Add spacing between the text and the icon */
        }

        .button-icon {
            display: none; /* Hide the icon by default */
            position: absolute;
            right: 10px; /* Adjust the position of the icon */
            top: 50%;
            transform: translateY(-50%);
        }

        .button-icon img {
            width: 16px; /* Adjust the width of the image */
            height: 16px; /* Adjust the height of the image */
        }

        @media (max-width: 312px) {
            .message-input-container button {
                max-width: none; /* Remove the maximum width */
                text-overflow: initial; /* Display the full button text */
            }

            .button-icon {
                display: inline-block; /* Show the icon */
            }

            .button-text {
                display: none; /* Hide the button text */
            }
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f2f2f2;
            color: #2b6777;
        }

        .sender-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .timestamp {
            color: gray;
            font-size: 12px;
        }

        .message.sent {
            background-color: #ffffff;
            color: #2b6777;
        }

        .message.received {
            background-color: #52ab98;
            color: #ffffff;
        }

        /* Hide the scrollbars */
        ::-webkit-scrollbar {
            width: 5px;
            background-color: #c8d8e4;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #f2f2f2;
        }

        @media (max-width: 470px) {
            

            .h2 {
                font-size: 20px;
            }
        }
        
        @media (max-width: 310px) {
            .message-input-container button {

                background-image:url("up-arrow.png");
            }

        }

        .top {
            display: flex;
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
            padding-left: 5px;
            width: 100%;
            position: sticky;
            top: 0;
            background-color: #2b6777;
            z-index: 1;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .arrow {
            margin-right: 5px;
            margin-left:5px;
             color:white;
        }

        .top-right {
            flex-grow: 1;
            text-align: center;
            display: flex; /* Add flexbox display */
            align-items: center; /* Center the content vertically */
        }

        .profile-pic {
            height: 25px;
            width: 25px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
            margin-left: 10px;
           
        }


        .input-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #c8d8e4;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .input-container input {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
            background-color: #ffffff;
        }

        .input-container button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #f2f2f2;
            color: #2b6777;
            font-size: 16px;
            cursor: pointer;
        }


        
    </style>
</head>
<body>
    <div class="top">
        <a href="index.php"><img class="arrow" src="arrow-12.png" height="20px" width="20px"></a>
        <h2 class="top-right" id="friend-name">
        <?php echo "<img class='profile-pic' src='data:image/jpeg;base64," . base64_encode($friendProfilePic) . "' alt='Profile Picture' />"; ?>

            <?php echo isset($friendUsername) ? $friendUsername : 'Friend Not Found'; ?>
        </h2>
    </div>
    <div class="container">
        <div class="message-container" id="message-container">
            <div id="message-list"></div>
        </div>


        <div class="message-input-container">
            <input id="message-input" type="text" placeholder="Type your message..." autocomplete="off">
                <button id="send-button">
                    <span class="button-text">Send</span>
                    <span class="button-icon"><img src="up-arrow.png" alt="Up Arrow"></span>
                </button>
        </div>


   <script>
$(document).ready(function () {
  var requestingMessages = false; // Flag to track if a request is in progress
  var friendId = <?php echo $friendId; ?>;

  function getMessages() {
    if (requestingMessages) return; // If a request is already in progress, exit the function
    requestingMessages = true; // Set the flag to indicate a request is in progress

    var messageContainer = $("#message-container");
    var isScrolledToBottom =
      messageContainer[0].scrollHeight - messageContainer.scrollTop() ===
      messageContainer.outerHeight();

    var previousScrollHeight = messageContainer[0].scrollHeight;

    $.ajax({
      url: "get_messages.php",
      type: "GET",
      data: { friend_id: friendId, timestamp: new Date().getTime() },
      dataType: "json",
      success: function (response) {
        
      var shouldScrollToBottom =
        messageContainer[0].scrollHeight - messageContainer.scrollTop() <=
        messageContainer.outerHeight() + 5;
        
        messageContainer.empty();

        for (var i = 0; i < response.length; i++) {
          var message = response[i];
          var senderLabel = message.sender_label;
          var messageText = message.message;
          var timestamp = formatDate(message.timestamp);
          var messageClass = message.sender_label === "You" ? "sent" : "received";

          var messageElement =
            "<div class='message " +
            messageClass +
            "'>" +
            "<p class='sender-label'>" +
            senderLabel +
            "</p>" +
            "<p class='message-text'>" +
            messageText +
            "</p>" +
            "<p class='timestamp'>" +
            timestamp +
            "</p>" +
            "</div>";

          messageContainer.append(messageElement);
        }

        if (shouldScrollToBottom) {
        messageContainer.scrollTop(messageContainer[0].scrollHeight);
      }
      },
      error: function () {
        console.log("Error retrieving messages.");
      },
      complete: function () {
        requestingMessages = false; // Reset the flag after the request is complete
        setTimeout(getMessages, 100); // Schedule the next request after a short delay
      },
    });
  }

  function scrollToBottom() {
    var messageContainer = $("#message-container");
    messageContainer.scrollTop(messageContainer[0].scrollHeight);
  }

 function formatDate(timestamp) {
  var date = new Date(timestamp);
  var options = {
    timeZone: "Asia/Kolkata", // Set the time zone to India (IST)
    hour12: true,
    hour: "numeric",
    minute: "numeric",
    day: "2-digit",
    month: "2-digit",
    year: "2-digit",
  };
  var formattedDate = date.toLocaleString("en-IN", options);

  // Extract the time and date portions
  var time = formattedDate.slice(0, -9);
  var date = formattedDate.slice(-8);

  return time + " " + date;
}


  // Event listener for the scroll event on the message container
  $("#message-container").on("scroll", function () {
    var messageContainer = $(this);
    var isScrolledToBottom =
      messageContainer[0].scrollHeight - messageContainer.scrollTop() ===
      messageContainer.outerHeight();

    if (isScrolledToBottom) {
      // If the user has scrolled to the bottom, update the flag and scroll to the bottom
      userScrolledUp = false;
    } else {
      // If the user has scrolled up, update the flag
      userScrolledUp = true;
    }
  });

  // Initial call to retrieve and display messages
  getMessages();

  // Function to send a message
  function sendMessage() {
    var message = $("#message-input").val();

    if (message !== "") {
      $.ajax({
        url: "room.php?friend_id=<?php echo $friendId; ?>",
        type: "POST",
        data: { message: message },
        success: function () {
          // Clear the input field
          $("#message-input").val("");

          // Call the getMessages function to retrieve and display updated messages
          getMessages();

          // Scroll to the bottom after sending the message
          setTimeout(scrollToBottom, 100); // Delay the scroll to allow new messages to be rendered
        },
        error: function () {
          console.log("Error sending message.");
        },
      });
    }
  }

  // Event listener for the send button
  $("#send-button").click(function () {
    sendMessage();
  });

  // Event listener for the Enter key in the message input field
  $("#message-input").keypress(function (e) {
    if (e.which === 13) {
      sendMessage();
    }
  });
});

</script>



</div>
</body>
</html>
