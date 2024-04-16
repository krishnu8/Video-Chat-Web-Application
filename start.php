<?php
session_start(); // Start or resume the session

include_once 'Database/Create_database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Start'])) {
    $select = 'SELECT * FROM `room` WHERE Joined = 0';
    $result = mysqli_query($con, $select);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $pin = $row['Pin'];
        $_SESSION['Join_session'] = $pin;
        $update = "UPDATE `room` SET `Joined`='1' WHERE `Pin` = '$pin'";
        mysqli_query($con, $update);


    } elseif ($count == 0) {
        $randomCode = rand(1000, 9999);
        $q = "INSERT INTO `room`(`Pin`, `Created`, `Joined`) VALUES ($randomCode,'1','0')";
        if(!(mysqli_query($con, $q))){
            ?>
<script>
    alert("Something Went Wrong. We will be right Back Shortly");
</script>
<?php
        }
        $_SESSION['Create_session'] = $randomCode;
    }

    header('Location: Home.php');
    exit; // Make sure to exit after sending the header
}

if(isset($_POST['Stop'])){
    $delete = "DELETE FROM `room` WHERE Joined = 0";
    mysqli_query($con,$delete);
    header('Location: Home.php');
    exit;
}
?>
