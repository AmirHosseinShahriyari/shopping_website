<?php
include "../includes/functions.php";
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['submit']))
{
    if(isset($_POST['username'])&!empty($_POST['username'])&
    isset($_POST['password'])&!empty($_POST['password']))
    {
        $username = trim(filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS));
        $password =$_POST['password'];
    }
    else
    {
        echo "بعضی از فیلد ها خالی است";
    }
    $conn = connect_to_server();
    $query = 'SELECT password FROM users WHERE username=?';
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);
    if($stmt->rowCount() > 0)
    {
        $user_information = $stmt->fetch(PDO::FETCH_ASSOC); // تمام اطلاعات سطر رو میریزه داخل آرایه
        $hash_password = $user_information['password'];
    }
    else
    {
        echo "کاربر پیدا نشد";
    }

    if(password_verify($password,$hash_password))
    {
        $_SESSION['state_login'] = true;
        header("location: ../user/dashbord.php");
        exit;
    }
    else
    {
        echo "پسوورد شما اشتباه است";
    }
}
?>