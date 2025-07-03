<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/auth style/style_login.css">
    <title>LOGIN</title>
</head>
<body>
    
<div class="login">
    
    <form action="" method="post" class="login_form">
         <h1>ورود</h1>
        <div class="input">
            
            <input type="text" name="username" id="username"  required>
            <label for="username">نام کاربری</label>
        </div>
        <div class="input">
            
            <input type="password" name="password" id="password" required>
             <label for="password"> رمزعبور</label>
        </div>
        <div class="submit">
            <button type="submit" name="submit" id="submit" >ورود</button>
        </div>
    </form>
</div>
    
</body>
</html>

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