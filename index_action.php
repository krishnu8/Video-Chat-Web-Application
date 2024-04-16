<?php
include_once 'Database/Create_database.php';
if (isset($_POST['Submit_form'])) {
    $Name = @$_POST['Name'];

    $q = "INSERT INTO User(`Name`) VALUES ('$Name');";

    if (mysqli_query($con, $q)) {
        setcookie('username', $Name, time() + (365 * 24 * 60 * 60), '/'); // '/' makes the cookie available across the entire domain
    }
    header("Location: index.php");
    exit();
}
?>
