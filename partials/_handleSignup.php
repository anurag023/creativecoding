<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include '_dbconnect.php';
    $user_email=$_POST['signupEmail'];
    $password=$_POST['signupPassword'];
    $cpassword=$_POST['signupCPassword'];

    $existsql = "SELECT * FROM `users` WHERE user_email='$user_email'";
    $result = mysqli_query($conn,$existsql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError = "Email is already exist";
    }
    else{
        if($password == $cpassword)
        {
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $sql= "INSERT INTO `users` (`user_email`, `user_pass`, `time`) VALUES ('$user_email', '$hash' ,current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result)
            {
                $showAlert = true;
                header("Location:../index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "password do no match";
            
        }
    
    }
    header("Location:../index.php?signupsuccess=false&error=$showError");
}
?>