<?php
 include 'includes/header.php';
 //session
 if (isset($_SESSION['surname'])) {
     $loggedIn = $_SESSION['surname']; 
 }

 //from profile url
if(isset($_GET['profile_username'])){
    $username = $_GET['profile_username']; 
}

$sql = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname = '$username' ");
$num_row = mysqli_num_rows($sql);
if ($num_row > 0) {
    $fetch_sql = mysqli_fetch_array($sql);
        $profile_pic =  $fetch_sql['profile_pic'];
        $num_post = $fetch_sql['num_posts'];
        $num_friends = str_word_count($fetch_sql['array_friends']) ;
        $profile_username= $fetch_sql['reg_surname'];
}


//form data
if (isset($_POST['remove_friend'])) {
    $user_friend_obj= new Users($conn, $loggedIn);
    $user_friend_obj->removeFriend($username);
   
}


// if (isset($_POST['respondToRequest'])) {
//     header('Location: responseFriend.php');
// }

if (isset($_POST['addFriend'])) {
   $userWhoAdded = new Users($conn, $loggedIn);
   $userWhoAdded->addToFriendRequest($username);
  
}

?>

<diymv class='profile_container'>
    <div class="profile_wrapper">
        <div class="personal_profile_details">
            <div class="profilePic_container">
                <a href="<?php echo $profile_username ?>"><img class="profile_img" src="<?php echo $profile_pic ?>" alt=""></a>   
            </div>
            <hr>

            <div class="profile_details">
                <h4>Posts: <?php echo $num_post ?></h4>
                <h4>Friends: <?php echo $num_friends ?></h4>
              
            </div>
            <hr>
            
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" style='    margin-left: 25%;'>POST CONTENT</button>

            
            <div class="addFriend_container">
                
            <?php if($loggedIn != $username){ ?>
                
            <form action="<?php echo $username;  ?>" method="POST">

                <?php      
                   $user_obj = new Users($conn, $loggedIn);
                   if($user_obj->isFriends($username)){
                       echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend">'; 
                   }
                //    elseif ($user_obj->didRecieveRequest($username)) {
                //     echo '<input type="submit" name="respondToRequest" class="primary" value="Respond to friend Request">'; 
                //    }
                   elseif ($user_obj->didSendRequest($username)) {
                    echo '<input type=""  name="friendRequestSent" class="success" value="Friend Request Sent" disabled>'; 
                   }else{
                        echo '<input type="submit" name="addFriend" class="warning" value="Add Friend">'; 
                   }
                      
                ?>

                </form>
<?php }  ?>  
        </div>
           
        </div>
     
        <div class="profile_newfeed_container" style='background-color:black;'>
        <?php 
        $profile_post = new Posts($conn, $loggedIn);
        echo $profile_post->getProfilePost($username);
        ?>
       
        </div>

    </div>
</div>

<!-- modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" id="profileForm">
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Post:</label>
            <textarea class="form-control" id="message_text" name="profile_post"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="sendpostfromProfile">Send post</button>
      </div>
    </div>
  </div>
</div>



   <!-- //footer -->
   <?php
   include 'includes/footer.php';