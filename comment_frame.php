<?php
session_start();
include 'database/database_config.php';
include 'asset\Classes\Users.php';
include 'asset\Classes\Posts.php';


$loggedIn = $_SESSION['surname'];
if (isset($_GET['post_id'])) {
 $post_id = $_GET['post_id'];
 
}
//submit comment
if (isset($_POST['submit_comment'])) {
    $sql1 = mysqli_query($conn, "SELECT added_by, user_to FROM twitter_post WHERE post_id = $post_id");
    $query_fetch = mysqli_fetch_array($sql1);
    $Posted_to = $query_fetch['added_by'];
    
    $comment_body = mysqli_real_escape_string($conn, $_POST['comment']);
    $comment_date = date('Y-m-d H:i:s');
    $post_id = $_GET['post_id'];
    $sql = mysqli_query($conn, "INSERT INTO comment(comment_body, comment_date, post_id, post_to, post_by, remove_post)VALUES('$comment_body', '$comment_date', $post_id, '$Posted_to', '$loggedIn', 'no')");
    

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/style.css">
    <title>Document</title>

    <style>
        body{
            background:black;
            color:white;
            padding: 0px;
            margin: 0px;
            box-sizing:border-box;
            
        }

        a{
            color:green;
        }
        .comentReply_section .replyImg{
            height: 35px;
            border-radius: 5px;
            margin-left:10px;
        }

        .coment_form{
           max-width:100%;
        }

        .comment_textarea{
            width: 80%;
            padding: 10px;
            margin-top:10px;
        }

        .comment_id{
            position: absolute;
            top:10px;
            padding: 15px;
            font-size: 15px;
            cursor:pointer;
            background: green;
            border:none;
            margin-left: 10px;
            border-radius: 5px;

        }

        .commentImg_wrapper{
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <form action="comment_frame.php?post_id=<?php echo $post_id ?>" method="POST" class="coment_form">
        <textarea name="comment" class="comment_textarea"></textarea>
        <input type="submit" name="submit_comment" value="comment" class="comment_id">

    </form>
  
     <?php
        
            //select submitted comment from db
            $sql = mysqli_query($conn, "SELECT * FROM comment WHERE post_id = '{$post_id}' AND remove_post ='no' ");
            $num_row = mysqli_num_rows($sql);
            if ($num_row > 0) {

                while($split_query = mysqli_fetch_array($sql)){
                $posted_comment = $split_query['comment_body'];
                $comment_date = $split_query['comment_date'];
                $comment_by = $split_query['post_by'];
                $comment_to = $split_query['post_to'];
                $post_id = $split_query['post_id'];
                
                
                $comment_date = new DateTime($comment_date);
                $date = date('Y-m-d H:i:s');
                $future = new DateTime($date);
                $interval =$comment_date->diff($future);
                $present_date = $interval->format(' %d days ago, %H hrs ago, %i min ago, %s sec ago');
                
                $profilePic_Obj = new Users($conn, $loggedIn);
                $profilePic = $profilePic_Obj->getProfilePic();
                $firstAndLastname = $profilePic_Obj->getFirstAndLastname();
                ?>

                <div class='comentReply_section'>
                    <div class='commentImg_wrapper'>
                        <img class='replyImg' src=<?php echo  $profilePic; ?> alt=''>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href='<?php echo $comment_by ?>' target='_parent'> <?php echo $firstAndLastname ?> </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php 
                        echo $present_date;
                        ?>
                    </div>
                          
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php 
                            echo $posted_comment;
                        ?>
                           
                 
                </div>
                <br> 
<?php
            }
            }


    ?>
 

</body>
</html>


