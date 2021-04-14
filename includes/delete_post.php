<?php
include '../database/database_config.php';


if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
 
    $sql=mysqli_query($conn, "UPDATE twitter_post SET post_delete = 'yes' WHERE post_id = '{$post_id}'");

    //select the user that posted the post
    $sql1=mysqli_query($conn, "SELECT added_by FROM twitter_post WHERE post_id = '{$post_id}' ");
    $added_user_array = mysqli_fetch_array($sql1);
    $added_user = $added_user_array['added_by'];
    

//select other credential of the user who posted the post
    $sql2=mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname = '{$added_user}' ");
    $user_detail_array = mysqli_fetch_array($sql2);
    $num_post = $user_detail_array['num_posts'];
 
    $num_post = --$num_post;
    $num_likes = $user_detail_array['num_likes'];
    if ($num_likes == 0) {
        $num_likes = $num_likes;
    }else{
        $num_likes = --$num_likes;
    }
   

    //decrease the num of post by the user who post it
$sql3=mysqli_query($conn, "UPDATE user_table SET num_posts =  '{$num_post}' WHERE reg_surname = '{$added_user}'");
   $sql4=mysqli_query($conn, "UPDATE user_table SET num_likes = '{$num_likes}' WHERE reg_surname = '{$added_user}'");
}


?>

<!-- // if ($num_post == 0) {
    //     $num_post = $num_post;
    // }else{
    //     $num_post =--$num_post;
    // } -->