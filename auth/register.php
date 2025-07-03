<?php
include "../includes/functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']))
{
    if(isset($_POST['first_name']) && !empty($_POST['first_name']) &&
    isset($_POST['last_name']) && !empty($_POST['last_name']) &&
    isset($_POST['username']) && !empty($_POST['username']) &&
    isset($_POST['password']) && !empty($_POST['password']) &&
    isset($_POST['confirm_password']) && !empty($_POST['confirm_password']) &&
    // isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['tel']) && !empty($_POST['tel']))
    {
        $name = trim(filter_input(INPUT_POST,'first_name',FILTER_SANITIZE_SPECIAL_CHARS));
        $lastName = trim(filter_input(INPUT_POST,'last_name',FILTER_SANITIZE_SPECIAL_CHARS));
        $username = trim(filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS));
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        // $email = $_POST['email'];
        $tel = $_POST['tel'];
        $tel = trim($tel);
        $tel = str_replace(['-', ' '], '', $tel);
        $errors=[];
        //connect to server
        $conn =  connect_to_server();
        //confirm Username
        if(strlen($username) > 18)
        {
            $errors[] = "طول نام کاربری شما بیش از حد مجاز است";
        }
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username=?");
        $stmt->execute([$username]);
        if($stmt->fetchColumn() > 0)
        {
            $errors[] = "یوزرنیم شما قبلا ثبت شده";
        }
        //confirm password

        if($password !=  $confirmPassword)
        {
            $errors[] = "لطفا پسوورد خود را درست تائید کنید";
        }
        else
        {
            if(strlen($password) < 8 || strlen($password) > 16)
            {
                $errors[] = "پسوورد شما باید بین 8 تا 16 حرف باشد";
            }
            if(!preg_match('/[A-Z]/',$password) || !preg_match('/[a-z]/',$password))
            {
                $errors[] = "پسوورد شما باید حداقل یک حرف بزرگ یا یک حرف کوچک داشته باشدد";
            }
            if(!preg_match('/[0-9]/',$password))
            {
                $errors[] = "پسوورد شما باید حداقل یک عدد داشته باشد";
            }
            if(!preg_match('/[\W]/',$password))
            {
                $errors[] = "پسوورد شما باید حداقل یک حرف خاص داشته باشد";
            }
        }

        //confirm email

        // if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        // {
        //     $errors[] = "ایمیل شما نامعتبر است";
        // }
        // else
        // {
        //     $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email=?");
        //     $stmt->execute([$email]);
        //     if($stmt->fetchColumn() > 0)
        //     {
        //         $errors[] = "ایمیل شما قبلا ثبت شده";
        //     }
        // }
        // confirm tel
        if(!preg_match('/^09\d{9}$/', $tel))
        {
            $errors[] = "شماره نامعتبر است";
        }
        else
        {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE tel=?");
            $stmt->execute([$tel]);
            if($stmt->fetchColumn() > 0)
            {
                $errors[] = "شماره تلفن قبلا ثبت شده است";
            }
        }

        // import to database
        if(!empty($errors))
        {
            foreach($errors as $error)
            {
                echo $error;
            }
            exit;
        }
        else
        {
            try
            {
                $email = "a@gmail.com";
                $hashed_password = password_hash($password,PASSWORD_DEFAULT);
                $query = "INSERT INTO users (name,last_name,username,password,email,tel) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([$name,$lastName,$username,$hashed_password,$email,$tel]);

                header("location: login.php");
                exit;
            }catch(PDOException $exception)
            {
                echo "خطا در ثبت اطلاعات" . $exception->getMessage();

            }
            //disconnect from server
            $conn = null;
        }

    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/auth style/style_register.css">
    <title>register</title>
</head>

<body>
    <div id="register">
        <form action="register.php" class="register"  method="POST" >
            <h1 class="fa-solid fa-lock"> ثبت نام</h1>
           
                 <div class= "input-size">
             <div class="input" class="input_size">
                <input type="text" id="first_name"  name="first_name" required 
                value="<?= htmlspecialchars($_POST['first_Name'] ?? '')?>">
                <label for="frist_name">نام </label>

            </div>

                <div class="input" class="input_size"  >
                <input type="text" id="last_name"  name="last_name" required 
                value="<?= htmlspecialchars($_POST['last_name'] ?? '')?>">
                <label for="last_name"> نام خانوادگی</label>
            </div>

            </div>

                 <div class="input" id="tel">
                <input type="tel" id="tel" name="tel" required 
                value="<?= htmlspecialchars($_POST['tel'] ?? '')?>">
                <label for="tel"> تلفن</label>
            </div>

             <div class="input">
                <input type="text" id="username" name="username" required placeholder=""
                value="<?= htmlspecialchars($_POST['username'] ?? '')?>">
                <label for="username">نام کاربری</label>
                </div>

                <div class="input">
                <input type="password" name="password" id="password" required 
                value="<?= htmlspecialchars($_POST['password'] ?? '')?>">
                <label for="password">کلمه عبور</label>
            </div>

                <div class="input">
                <input type="password" name="confirm_password" id="confirm_password" required 
                value="<?= htmlspecialchars($_POST['confirm_password'] ?? '')?>">
                <label for="password">کلمه عبور</label>
            </div>

            <div id="password_condition">
         <ul>
                <li class="password_condition_list_item">
                        <h6 class="password_condition_list">رمزعبور شما حداقل باید 8 کارکتر و حداکثر16 کارکتر باشد</h6>
            </li>
             <li class="password_condition_list_item" >
                        <h6 class="password_condition_list"">رمزعبور شما حداقل باید دارای یک حرف بزرگ و یک حرف کوچک باشد</h6>
            </li>
             <li  class="password_condition_list_item" >
                        <h6 class="password_condition_list">  رمزعبور شما باید حداقل دارای یک عددو یک کارکتر خواص  باشد(#_.!) </h6>
            </li>
          
        </ul>
            </div>            
            <button id="submit" name="submit" type="submit" > ثبت نام</button>
        </form>
    </div>
</body>
</html>
