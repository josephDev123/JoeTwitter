<!-- index header -->
<?php include 'includes/header.php' ?>

    <div class="newsfeed_container">
        <div class="personal_detail_container">
            <img src="<?php echo $profile_pic; ?>" alt="">
            <div class="info_details">
                <?php 
                    echo  $firstname;
                    echo ' &nbsp';
                    echo 'Posts:'.$num_post;  
                ?>

          
            </div>
        </div>
        <div class="newsfeed_detail_right">
            <form class="newsfeed_form" action="" method="POST">
                <textarea name="post_value" id="" cols="10" rows="10" placeholder="type what's on your mind!"></textarea>
                <input type="submit" name="post_submit" value="post">
            </form>
<hr>
<hr>
            <?php 
            $post = new Posts($conn, $_SESSION['surname']);
            echo $post->getPost();
            ?>
           
        </div>

    </div>


</body>
</html>

<!-- "asset\images\profile_pic\download.png"  -->