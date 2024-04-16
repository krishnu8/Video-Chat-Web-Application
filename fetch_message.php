<?php
include_once 'Database/Create_database.php';

// Check if 'pin' parameter is set in GET request
if (!isset($_GET['pin'])) {
    echo json_encode(array('error' => 'Pin parameter is missing.'));
    exit;
}

// Get the pin parameter from GET request
$pin = $_GET['pin'];

// Fetch messages from the database
$sql = "SELECT * FROM message WHERE Pin='$pin'";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(array('error' => 'Failed to fetch messages: ' . mysqli_error($con)));
    exit;
}

$messages = array();
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

// Close database connection
mysqli_close($con);

// Return messages as JSON
echo json_encode($messages);
?>
