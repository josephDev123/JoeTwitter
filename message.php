<?php
include 'includes/header.php';
$message_obj = new Messages($conn, $_SESSION['surname']);

if (isset($_GET['u'])) {
   $user_to = $_GET['u'];
}else{
    $user_to = $message_obj->getMostRecentUser();
    if ($user_to == FALSE) {
        $user_to = 'new';
    }
}

?>

<div class="newsfeed_container">
        <div class="personal_detail_container">
            
            <div class="info_details" style='display:flex'>
                <a href='<?php echo $_SESSION['surname']; ?>'><img src="<?php echo $profile_pic; ?>" alt=""></a>
                
                <div>
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


            <div class="convo_list_container" style="color:black; background-color:white; ">
                <h3>Conversational List</h3>
               <?php 
               if($message_obj->get_conversational_list()){
                   echo $message_obj->get_conversational_list();
                 
               }else{
                   echo 'New Message';
               }
                 ?>

            </div>


        </div>

        <div class="newsfeed_detail_right">
        <?php
           if($user_to != 'new'){
               $userTo_obj = new Users($conn, $user_to);

               if (isset($_POST['send_message'])) {
                 if (isset($_POST['message'])) {
                   $message = $_POST['message'];
                   $message = mysqli_real_escape_string($conn, $message);
                   $message_obj->sendMessage($message, $user_to);
                }
               }
              
           }
          

           if($user_to == 'new'){
                ?>
                <form action="" method="POST">
                   <label for="search">To:</label> 
                   <input type="text" name='q' id='search' onkeyup= "listOfUsersToMessage(event)">
                
                </form>
                <div class='load_search'>

                </div>
                <?php
           }else{
               ?>

            <div class="load_message">
            <h5> You and  <a href="<?php echo $user_to ?>"> <?php echo $userTo_obj->getFirstAndLastname(); ?> </a> </h5>
                <?php echo $message_obj->getMessage($user_to); ?>
          </div>
                <form action="" method="POST">
                 <textarea name="message" id="message_box" cols="" rows=""></textarea>
                 <input type="submit" name ="send_message" id="send_message" value="send message">
                            
                </form>
               <?php
           }
           ?>
        </div>

    </div>


           <script>
   
           function listOfUsersToMessage(event){

               $.post('loadsearchmessage.php', {
                   content:event.target.value,
                   user_from: '<?php echo $_SESSION['surname']; ?>'
               },
                (data)=>{
                   $('.load_search').html(data)
               })
           }

           </script>
 <?php
        // include "includes/footer.php";
 ?>

