<?php
$con=mysqli_connect("localhost","root","")or die("Conection fail");

mysqli_select_db($con,"Chat_Application");

// $q="create database Chat_Application";

// if(mysqli_query($con,$q))
// {
//     echo "Database create";
// }
// else{
//     echo "Database not create";
// }