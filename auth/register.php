<?php
include "../includes/functions.php";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']))
{
    if(isset($_POST['Frist_Name']) && !empty($_POST['Frist_Name']) &&
    isset($_POST['Last_Name']) && !empty($_POST['Last_Name']) &&
    isset($_POST['User_Name']) && !empty($_POST['User_Name']) &&
    isset($_POST['password']) && !empty($_POST['password']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['tel']) && !empty($_POST['tel']))
    {
        $name = trim(filter_input(INPUT_POST,'Frist_Name',FILTER_SANITIZE_SPECIAL_CHARS));
        $lastName = trim(filter_input(INPUT_POST,'Last_Name',FILTER_SANITIZE_SPECIAL_CHARS));
        $username = trim(filter_input(INPUT_POST,'User_Name',FILTER_SANITIZE_SPECIAL_CHARS));
        $password = $_POST['password'];
        $confirmPassword = $_POST['Confirm_Password'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $tel = trim($tel);
        $tel = str_replace(['-', ' '], '', $tel);
        $errors=[];
        //connect to server
        $conn =  connect_to_server("localhost","main","root","");
        //confirm Username
        if(strlen($username) > 18)
        {
            $errror[] = "طول نام کاربری شما بیش از حد مجاز است";
        }
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username=?");
        $stmt->execute([$username]);
        if($stmt->fetchColumn() > 0)
        {
            $errors[] = "یوزرنیم شما قبلا ثبت شده";
        }
        //confirm password

        if($password != $confirmPassword)
        {
            $errror[] = "لطفا پسوورد خود را درست تائید کنید";
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

        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $errors[] = "ایمیل شما نامعتبر است";
        }
        else
        {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email=?");
            $stmt->execute([$email]);
            if($stmt->fetchColumn() > 0)
            {
                $errors[] = "ایمیل شما قبلا ثبت شده";
            }
        }
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
                $hashed_password = password_hash($password,PASSWORD_DEFAULT);
                $query = "INSERT INTO users (name,last_name,username,password,email,tel) VALUES (?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([$name,$lastName,$username,$password,$email,$tel]);
                header("location: ../login.php");
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