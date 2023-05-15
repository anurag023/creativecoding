<?php
$showError="false";
// error_reporting(0);
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include '_dbconnect.php';
   
    $pass = $_POST['loginPass'];
    $email = $_POST['loginEmail'];

    $sql= "Select * from `users` where user_email='$email'";
    $result =mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass ,$row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['useremail'] = $email;

            echo "logged in" .$email;
          
        }
        header("location: ../index.php");   
    }
    header("location: ../index.php");
}

?>