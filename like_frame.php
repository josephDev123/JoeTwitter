<?php 

session_start();
include 'database/database_config.php';
include 'asset\Classes\Users.php';
include 'asset\Classes\Posts.php';

$loggedIn = $_SESSION['surname'];

if (isset($_GET['post_id'])) {
 $post_id = $_GET['post_id'];
}

$sql = mysqli_query($conn, "SELECT * FROM twitter_post WHERE post_id = '{$post_id}'");
$fetch_sql = mysqli_fetch_array($sql);
$added_by = $fetch_sql['added_by'];
$num_post_likes =  $fetch_sql['likes'];

$sql3 =  mysqli_query($conn, "SELECT num_likes FROM user_table WHERE reg_surname = '{$added_by}'");
$fetch_sql3 = mysqli_fetch_array($sql3);
$user_num_like = $fetch_sql3['num_likes'];


if (isset($_POST['like'.$post_id])) {
    $num_post_likes++;
    mysqli_query($conn, "UPDATE twitter_post SET likes = {$num_post_likes} WHERE post_id = {$post_id}");
    $user_num_like++;
    $query = mysqli_query($conn, "UPDATE user_table SET num_likes = {$user_num_like} WHERE reg_surname = '{$added_by}'");
    $insert_like = mysqli_query($conn, "INSERT INTO post_likes( post_id, likes_by)VALUES('$post_id', '$loggedIn')");
  
}


if (isset($_POST['unlike'.$post_id])) {
    $num_post_likes--;
    mysqli_query($conn, "UPDATE twitter_post SET likes = {$num_post_likes} WHERE post_id = {$post_id}");
    $user_num_like--;
    $query = mysqli_query($conn, "UPDATE user_table SET num_likes = {$user_num_like} WHERE reg_surname = '{$added_by}'");
   mysqli_query($conn, "DELETE FROM post_likes WHERE post_id = '{$post_id}'");
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            padding:0px;
            margin:0px;
            box-sizing: border-box;
            height: 20px;
           
        }

        .like{
       
        background: none;
        color: white;
        border: none;
        }
        
        .like:hover{
        cursor: pointer;
        background: none;
        color: white;
        border: none;
        }


        .unlike{
        
        background: none;
        color: white;
        border: none;
        }

        .unlike:hover{
        cursor: pointer;
        background: none;
        color: white;
        border: none;
        }

    </style>
</head>
<body>
    <?php 
    $query = mysqli_query($conn, "SELECT * FROM post_likes WHERE likes_by = '{$loggedIn}' AND post_id = {$post_id}");
    $fetch_query = mysqli_num_rows($query);
    if ($fetch_query > 0) {
        ?>

        <form action="like_frame.php?post_id=<?php echo $post_id; ?>" method="POST" style="display:flex">
             <input type="submit" name='unlike<?php echo $post_id ?>' value='Unlike: (<?php echo $num_post_likes ?>) likes' class="unlike">
           
            
         </form>
        
     <?php

    }else{
        ?>
        <form action="like_frame.php?post_id=<?php echo $post_id; ?>" method="POST" style="display:flex">
            <input type="submit" name='like<?php echo $post_id ?>' value='Like: (<?php echo $num_post_likes ?>) likes' class="like">
            
        </form>

        <?php
    }

    ?>
    
    
   
</body>
</html>


