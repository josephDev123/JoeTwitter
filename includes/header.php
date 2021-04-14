<?php
session_start();
include 'database/database_config.php';
include 'asset\Classes\Users.php';
include 'asset\Classes\Posts.php';
include 'asset\Classes\Message.php';


$user =new Users($conn, $_SESSION['surname']);
$post = new Posts($conn, $_SESSION['surname']);

if(!isset( $_SESSION['surname'])){
    header('Location: reg_form.php');
}

if(isset($_SESSION['surname'])){
    $sql = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname = '{$_SESSION["surname"]}' ");
    $row = mysqli_fetch_array($sql);
    $firstname = $row['reg_firstname'];
    $lastname = $row['reg_lastname'];
    $num_post = $row['num_posts'];
    $profile_pic = $row['profile_pic'];
}

if (isset($_POST['post_submit'])) {
    $post = new Posts($conn, $_SESSION['surname']);
    $post->PostSubmit($_POST['post_value'],  $_SESSION['surname']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- <script src="https://use.fontawesome.com/288f23abfe.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

    <script src="asset\js\jquery.js"></script>
    <title>Home</title>
</head>
<body>
    <header>
        <div class="header_logo">
            <h2><a href="index.php">JoeTwitter</a></h2>
        </div> 
        
        <div class="searchBar_container">
            <input type="text" placeholder="Search">
        </div>

        <div class="header_icons">
            <ul>
                <li><a href='<?php echo $_SESSION['surname']; ?>' style='color:green; text-decoration:none'><?php echo $_SESSION['firstname']; ?></a></li>
                <li><i class="fas fa-envelope-open-text"></i></li>
                <li><a href="index.php"><i class="fas fa-house-user"></i></a></li>
                <li><a href="responseFriend.php"><i class="fas fa-bell"></i></a></li>
                <li><i class="fal fa-user-cog"></i></li>
                <li><a href="logout.php"><i class="fas fa-arrow-circle-right"></i></a></li>
             
            </ul>
        </div>
    </header>