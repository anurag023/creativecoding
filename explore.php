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
    #ques {
        min-height: 433px;
    }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn , $sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname=$row['category_name'];
        $catdesc=$row['category_description'];
    }
    ?>

    <?php
    $method =$_SERVER['REQUEST_METHOD'];
    $ShowAlert=false;
    if($method=='POST')
    {
        $title=$_POST['title'];
        $desc=$_POST['desc'];
        $so=$_POST['sno'];

        $title=str_replace("<" , "&lt;" , $title);
        $title=str_replace(">" , "&gt;" , $title);

        $desc=str_replace("<" , "&lt;" , $desc);
        $desc=str_replace(">" , "&gt;" , $desc);
        $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$title', '$desc', '$id', '$so', current_timestamp());";
        $result=mysqli_query($conn , $sql);
        $ShowAlert=true;
    }
    ?>
    <div class="conatiner text-center my-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname?> forums</h1>
            <p class="lead"><?php $catdesc ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum.Keep it friendly.
                Be courteous and respectful. Appreciate that others may have an opinion different from yours.
                Stay on topic.
                Share your knowledge.
                Refrain from demeaning, discriminatory, or harassing behaviour and speech.
                self promotion not allowed.

            </p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </div>
        <h2 class="text-center">
            Ask a Question
        </h2>
    </div>
    <?php
    if($ShowAlert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your question is taken wait for other to response
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
         window.location="./explore.php?catid=' .$id. '";
    }
    setTimeout("redirectpage()", 2000)
</script>' ;

    }
   
    ?>
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'<div class="container bg-info">
            <h2 class="py-2">Start a discussion</h2>
            <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1" class="pl-2"><b>Problem Title</b></label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted pl-2">Keep your title as short as possible</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1" class="pl-2"><b>Describe your Problem</b></label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
    }
    else{
        echo '<div class="container bg-info"><h3 class="text-center">If you wanna ask any question .... log in first</h3></div>';
    }
    ?>
    <?php
    
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result=mysqli_query($conn , $sql);
    $noresult=true;
     echo '<div class="container py-2" id="ques">
        <h2 class="text-center">
            Queries
        </h2>';
    while($row=mysqli_fetch_assoc($result)){
        $noresult=false;
        $threadtitle=$row['thread_title'];
        $threadid=$row['thread_id'];
        
        $threaddesc1=$row['thread_desc'];
        $userid=$row['thread_user_id'];
        $time=$row['timestamp'];
        
        $sql2="SELECT user_email FROM `users` WHERE sno='$userid'";
        $result2=mysqli_query($conn , $sql2);
        $row2 = mysqli_fetch_assoc($result2);
    echo '
        <div class="media my-3 mt-2">
            <img src="images/profile.jpeg" width="40px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="font-weight-bold text-info">' .$row2['user_email'] .' at ' .$time.'</p><a class="text-dark" href="./answer.php?threadid=' . $threadid .'"><b><h5>' .$threadtitle .'</h5></b></a></p>
                ' .$threaddesc1 .'
            </div>
        </div>';
    
    }
    if($noresult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container bg-light">
          <h1 class="display-5">No question of this type</h1>
          <p class="lead">Be the first one to ask the question</p>
          </div>
      </div>';
        
    
    }
    echo '</div>';
    
?>
    

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