<?php
include "../includes/dashbord_sidebar.php";
include "../includes/fav_icon.php"; 
session_start();
if(!isset($_SESSION['state_login']) || $_SESSION['state_login'] != true)
{
    header("location: ../auth/login.php");
    exit;
}
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
echo $username . $user_id;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord</title>
</head>
<body>
    
</body>
</html>