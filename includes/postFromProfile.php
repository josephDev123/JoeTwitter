<?php 
include '../asset/classes/Posts.php';
include '../asset/classes/Users.php';
include '../database/database_config.php';

if (isset($_POST['text'])) {
    $profilePost = $_POST['text'];
   $profile_userTo = $_POST['userTo'];
   $profile_postby = $_POST['postBy'];
//    $user_obj = new Users()
   $profilePost_obj = new Posts($conn, $profile_postby);
  $profilePost_obj->PostSubmit($profilePost, $profile_userTo);
  
}


?>
<!-- 
Hi there, I'm a self-taught full-stack web developer. As you see I have hands-on experience building scalable, dynamic, and secure web applications. My strengths are building beautiful and interactive user interfaces, managing state in an application on the front-end (React), and also writing reusable and testable code.  -->