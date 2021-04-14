<!-- index header -->
<?php include 'includes/header.php' ?>

    <div class="newsfeed_container">
        <div class="personal_detail_container">
            <a href='<?php echo $_SESSION['surname']; ?>'><img src="<?php echo $profile_pic; ?>" alt=""></a>
            <div class="info_details">
                 <a href="<?php echo $user->getUsername()?>"><?php echo $user->getFirstAndLastname()?></a>
                 <?php
                    echo ' <br>';
                   echo 'Posts:'.$user->numOfPost();
                   echo ' <br>';
                   echo 'Likes:'.$user->numLikes();
                ?>
                <br>
               

          
            </div>
        </div>
        <div class="newsfeed_detail_right">
            <form class="newsfeed_form" action="" method="POST">
                <textarea name="post_value" id="" cols="10" rows="10" placeholder="type what's on your mind!"></textarea>

                <input type="submit" name="post_submit" value="post" style="cursor:pointer">
            </form>
<hr>

            <?php 
                 echo $post->getPost();
            ?>
           
        </div>

    </div>
    <?php

    //footer
include 'includes/footer.php';