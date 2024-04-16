<?php
include_once 'Database/Create_database.php';

$username = $_COOKIE['username'];

// Retrieve message from POST data
$message = $_POST['message'];
$Pin = $_POST['pin'];
// Insert message into database
$q = "INSERT INTO `message`(`Pin`, `Sender`, `Message`) VALUES ('$Pin','$username','$message')";

if (mysqli_query($con,$q)) {
    echo "Message saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

// $con->close();

?>
