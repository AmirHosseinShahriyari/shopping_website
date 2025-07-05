<!-- <?php
// include "../includes/dashbord_sidebar.php";
// include "../includes/fav_icon.php"; 
// session_start();
// if(!isset($_SESSION['state_login']) || $_SESSION['state_login'] != true)
// {
//     header("location: ../auth/login.php");
//     exit;
// }
// $username = $_SESSION['username'];
// $user_id = $_SESSION['user_id'];
// echo $username . $user_id;

 ?> -->


<?php
include "../includes/dashbord_sidebar.php";
include "../includes/fav_icon.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/fonts/font awesome.css">
    <link rel="stylesheet" href="../css/user/style_dashbord.css">
    <title>Dashbord</title>
</head>
<body>
    <div class="dashbord_content">

    <div class="Quick_access_container">
         <a href="">
        <div class="edit_account_container Quick_access_item">
            <img class="edit_account_img Quick_access_img" src="../assets/image & icon/edit icon.png" alt="">
            <h2 class="Quick_access_h2">ویرایش حساب </h2>
        </div>
        
        </a>

         <a href="">
        <div class="support_container Quick_access_item">
            <img class="support_img Quick_access_img" src="../assets/image & icon/support icon.png" alt="">
            <h2 class="Quick_access_h2"> پشتیبانی</h2>
        </div>
        </a>
        
        <a href="">
         <div class="Favorites_container Quick_access_item" >
            
         <img class="support_img Quick_access_img" src="../assets/image & icon/Favorites icon.webp" alt="">
            <h2 class="Quick_access_h2">   مورد علاقه ها</h2>
        </div>
        </a>
        


    </div>
    <div class="Last_purchase_container">

    </div>
     </div>

</body>
</html>