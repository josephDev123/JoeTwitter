<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- <script src="https://use.fontawesome.com/288f23abfe.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <title>Home</title>
</head>
<body>
    <header>
        <div class="header_logo">
            <h2><a href="#">JoeTwitter</a></h2>
        </div> 
        
        <div class="searchBar_container">
            <input type="text" placeholder="Search">
        </div>

        <div class="header_icons">
            <ul>
                <li><?php echo $_SESSION['firstname']; ?></li>
                <li><i class="fas fa-envelope-open-text"></i></li>
                <li><i class="fas fa-house-user"></i></li>
                <li><i class="far fa-bell"></i></li>
                <li><i class="fal fa-user-cog"></i></li>
                <li><i class="fas fa-arrow-circle-right"></i></li>
             
            </ul>
        </div>
    </header>
</body>
</html>