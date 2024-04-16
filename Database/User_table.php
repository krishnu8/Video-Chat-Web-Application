<?php
include_once 'Create_database.php';

$q = "create table User
(User_id int(10) AUTO_INCREMENT primary key,Name char(50),Status char(25))";
if (mysqli_query($con, $q)) {
    echo 'Table created';
} else {
    echo 'Table not created';
}
