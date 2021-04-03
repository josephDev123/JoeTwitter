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



?>

<div class="request_container">
<h2>Friend Request</h2>

   <?php
      $sql = mysqli_query($conn, "SELECT * FROM friend_request WHERE user_to = '$loggedIn'");
      $num_row = mysqli_num_rows($sql);
     
      if ($num_row == 0) {
         echo '<h3>You have no friend request for now</h3>';
      
      }else{
            while($row = mysqli_fetch_array($sql)){
               $request_from = $row['user_from'];
               $user_to_add = $row['user_to'];
               $userWhoSentRequest = new Users($conn, $request_from);
               echo "<h3>". $userWhoSentRequest->getFirstAndLastname()." sent friend request</h3>";

               if(isset($_POST['accept'.$request_from])){
                  $add_friend_obj = new Users($conn, $request_from);
                  $add_friend_obj->addFriend($user_to_add);
                  header('Location: responseFriend.php');
                
               }
?>
               <form action="responseFriend.php" method="POST">
                  <input type="submit" name="accept<?php echo $request_from;?>" value="Accept" class="accept">
                  <input type="submit" name="ignore<?php echo $request_from;?>" value="Ignore" class="ignore">
               </form>
            <?php
            }
      }
      ?>
</div>



<?php
//footer
include 'includes/footer.php';