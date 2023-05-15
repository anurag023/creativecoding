<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    .container {
        min-height: 100vh;
    }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>

    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>

    <?php
    $method =$_SERVER['REQUEST_METHOD'];
    $ShowAlert=false;
    if($method=='POST')
    {
        $useremail=$_POST['useremail'];
        $username=$_POST['username'];
        $feedback=$_POST['feedback'];
        $feedback=str_replace("<" , "&lt;" , $feedback);
        $feedback=str_replace(">" , "&gt;" , $feedback);
        $sql="INSERT INTO `contact` (`user_email`, `username`, `feedback` , `timestamp`) VALUES ('$useremail', '$username', '$feedback', current_timestamp() );";
        $result=mysqli_query($conn , $sql);
        $ShowAlert=true;
    }
    ?>
    <?php
    if($ShowAlert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your feeedback is added
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    echo '<script>
    var seconds=0;
    function displayseconds()
    {
        seconds +=1;
    }
    setInterval(displayseconds,1000);
    function redirectpage()
    {
         window.location="contact.php";
    }
    setTimeout("redirectpage()", 2000)
</script>' ;

    }
    ?>
    <div class="container">
        <h1 class="text-center">Contact Us</h1>
        <form action="<?php $_SERVER["REQUEST_URI"] ?>" method="post" class="mx-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="useremail" name="useremail" aria-describedby="emailHelp">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                <!-- <small id="emailHelp" class="form-text text-muted">W</small> -->
            </div>
            <div class="form-group">
                <label for="feedback">feedback</label>
                <input type="text" class="form-control" id="feedback" name="feedback">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php include 'partials/_footer.php';?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>