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
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result=mysqli_query($conn , $sql);
    while($row=mysqli_fetch_assoc($result)){
        $threadtitle=$row['thread_title'];
        $threaddesc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];

    
        //query to fetch user name
    $sql2 ="SELECT user_email from `users` WHERE sno='$thread_user_id'";
    $result2= mysqli_query($conn ,$sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $postedby=$row2['user_email'];
    }
    ?>
    <?php
    $method =$_SERVER['REQUEST_METHOD'];
    $ShowAlert=false;
    if($method=='POST')
    {
        $comm=$_POST['comm'];
        $so=$_POST['sno'];
        $comm=str_replace("<" , "&lt;" , $comm);
        $comm=str_replace(">" , "&gt;" , $comm);
        $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comm', '$id', current_timestamp(), '$so');";
        $result=mysqli_query($conn , $sql);
        $ShowAlert=true;
    }
    ?>

    <!-- Category cantainer start here -->
    <div class="conatiner text-center my-3">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $threadtitle?> </h1>
            <p class="lead"><?php echo $threaddesc ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum.Keep it friendly.
                Be courteous and respectful. Appreciate that others may have an opinion different from yours.
                Stay on topic.
                Share your knowledge.
                Refrain from demeaning, discriminatory, or harassing behaviour and speech.
                self promotion not allowed.

            </p>
            <p>Posted by:<b><?php echo $postedby; ?></b></p>
        </div>
    </div>
    
    <?php
       
       if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){

        echo '<div class="container bg-info">
                <h2 class="py-2">Post your answer</h2>
                <form action="' .$_SERVER["REQUEST_URI"] .'" method="post">

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="pl-2"><b>Type your answer</b></label>
                        <textarea class="form-control" id="comm" name="comm" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                    <button type="submit" class="btn btn-success">post Comment</button>
                </form>
            </div>';
       }
       else{
        echo '<div class="container bg-info"><h3 class="text-center">If you wanna ask give answer of this question .... log in first</h3></div>';
       }
    ?>
    <?php
    if($ShowAlert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your comment is added
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
         window.location="./answer.php?threadid=' .$id. '";
    }
    setTimeout("redirectpage()", 2000)
</script>' ;

    }
   
    ?>

    <div class="container py-2" id="ques">
        <h2 class="text-center">
            Discussion

        </h2>
        <?php
    
            $id=$_GET['threadid'];
            $sql="SELECT * FROM `comments` WHERE thread_id=$id";
            $result=mysqli_query($conn , $sql);
            $noresult=true;
            // echo '<div class="container py-2" id="ques">
            //     <h2 class="text-center">
            //         Queries
            //     </h2>';
            while($row=mysqli_fetch_assoc($result)){
                $noresult=false;
                $id=$row['comment_id'];
                $content=$row['comment_content'];
                $userid=$row['comment_by'];
                $comment_time=$row['comment_time'];
                $sql2="SELECT user_email FROM `users` WHERE sno='$userid'";
                $result2=mysqli_query($conn , $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                
            
            echo '
                <div class="media my-3 mt-2">
                    <img src="images/profile.jpeg" width="40px" class="mr-3" alt="...">
                    <div class="media-body">
                        <p class="font-weight-bold text-info">' .$row2['user_email'] .' at ' .$comment_time.'</p>
                        ' .$content .'
                    </div>
                </div>';
            
            }
            if($noresult){
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container bg-light">
                <h1 class="display-5">till now no one comment on it</h1>
                <p class="lead">Be the first one to answer it</p>
                </div>
            </div>';
                
    
    }
    echo '</div>';
    
?>
    </div>
    <?php
//     $id=$_GET['catid'];
//     $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
//     $result=mysqli_query($conn , $sql);
//     while($row=mysqli_fetch_assoc($result)){
//         $threadtitle=$row['thread_title'];
//         $threadid=$row['thread_id'];
//         $threaddesc1=$row['thread_desc'];
    
//     echo '<div class="container py-2" id="ques">
//         <h2 class="text-center">
//             Queries
//         </h2>
//         <div class="media my-3">
//             <img src="images/profile.jpeg" width="40px" class="mr-3" alt="...">
//             <div class="media-body">
//                 <h5 class="mt-0"><a class="text-dark" href=./answer.php>' .$threadtitle .'</a></h5>
//                 ' .$threaddesc1 .'
//             </div>
//         </div>
//     </div>';
// }
    
    
// ?>

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