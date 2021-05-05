<?php

class Posts{
private $conn;
private $user_obj;

public function __construct($conn, $user){
    $this->conn = $conn;
    $this->user_obj = new Users($conn, $user);

}


 public function PostSubmit($body, $userTo){
    $body = mysqli_real_escape_string($this->conn, $body);
    $body = trim($body);

    if (!empty($body)) {
       
       $added_by = $this->user_obj->getUsername();
       
       if ($userTo == $added_by) {
           $userTo = 'none';
       }
       $date = date('Y-m-d H:i:s');
       $closed_post = 'no';
       $delete_post = 'no';
       $like_post = 0;

       $sql =mysqli_query($this->conn, "INSERT INTO  twitter_post(post_content, added_by,user_to, post_date, userclosed, post_delete, likes)VALUE('$body','$added_by', '$userTo',  '$date', '$closed_post',  '$delete_post', '$like_post')");
       

       $numUserPost = $this->user_obj->numOfPost();
       $numUserPost++;
       $sql = mysqli_query($this->conn, "UPDATE user_table SET num_posts = '{$numUserPost}' WHERE reg_surname = '{$added_by}'");

    }
}
 

public function getPost(){
   
    $postData = "";
    $sql = mysqli_query($this->conn, "SELECT * FROM twitter_post WHERE post_delete = 'no' ORDER BY post_id DESC ");

        while($row = mysqli_fetch_array($sql)){
            $postContent = $row['post_content'];
            $addedBy = $row['added_by'];
            $user_To = $row['user_to'];
            $postDate = $row['post_date'];
            $post_id = $row['post_id'];
            
            if ($user_To == 'none') {
                $userTo ="";
            }else{
                $newUser_obj = new Users($this->conn, $user_To);
                $firstAndLastname = $newUser_obj->getFirstAndLastname();
                $userTo = "to <a href='$user_To'>$firstAndLastname</a>";
              
            }
?>

                <script>
                    function toggle<?php echo $post_id; ?>(){
                        const element = document.getElementById('comment_section<?php echo $post_id; ?>');
                        if(element.style.display = 'none'){
                            element.style.display = 'block';
                        }else{
                            element.style.display = 'none';
                        }
                    }

                </script>

            <?php
            $posted_date = new DateTime($postDate);
            $date = date('Y-m-d H:i:s');
            $future = new DateTime($date);
            $interval = date_diff($posted_date, $future);
            $present_date = $interval->format('%m Month ago , %d days ago, %H hrs ago, %i min ago, %s sec ago');
            

            $addedBy_obj = new Users($this->conn, $addedBy);
            if($addedBy_obj->isClosed()){
                continue;
            }

            //user table
                $sql1 = mysqli_query($this->conn, "SELECT reg_firstname, reg_lastname, profile_pic FROM user_table WHERE reg_surname = '{$addedBy}' ");
                $row = mysqli_fetch_array($sql1);
                $userFirstname = $row['reg_firstname'];
                $userlastname = $row['reg_lastname'];
                $userprofile_pic = $row['profile_pic'];
          
                //number of comment
                $sql2 = mysqli_query($this->conn, "SELECT * FROM comment WHERE post_id = '{$post_id}' ");
                $numCommentTopost = mysqli_num_rows($sql2);
             
                $close_button = '';
                if ($addedBy === $this->user_obj->getUsername()) {
                    $close_button = "<button id='post_delete$post_id' name='$post_id' class='btn btn-danger btn-sm'>X</button>";
                }else{
                    $close_button ="";
                }


                if($this->user_obj->isFriends($addedBy)) {
                    
                $postData .= "<div style='border:1px solid gray; padding:15px;' class='post_data_container'  onClick='javascript:toggle{$post_id}()'>
                                    <div class='imgAndPostContent_wrapper'>
                                        <div class='img_wrapper' >
                                            <a href='$addedBy' ><img src='$userprofile_pic' alt='$addedBy' ></a>
                                        </div>

                                        <div class='postContent_wrapper'>
                                            <p><a href=$addedBy>$userFirstname $userlastname </a>$userTo <span>$present_date</span></p> 
                                           
                                                 <div style='display:flex; justify-content:flex-end;'>$close_button</div>
                                            
                                            <p style='transform: translateY(-30px); margin-top:15px;'>$postContent</p>
                                        </div>
                                    </div>
                                    <div style='display:flex; margin-top:20px;'>
                                        comment($numCommentTopost)
                                        <iframe scrolling='' frameBorder='0' class='comment_iframe1' src='like_frame.php?post_id={$post_id}'></iframe>
                                    </div>
                                   
                                   
                                    <div class='comment_wrapper' id='comment_section$post_id' style='display:none;'>
                                        <iframe scrolling='' frameBorder='0' class='comment_iframe' src='comment_frame.php?post_id={$post_id}'></iframe>
                                    </div>
                
                
                             </div>
                             <hr>";
                     
                   
                     }    
                                            
                     ?>

                     <!-- select the delete element  -->
                     <script>
                        $(document).ready(function(){

                            $("#post_delete<?php echo $post_id ?> ").on('click', ()=>{
                                $attr = $('#post_delete<?php echo $post_id ?> ').attr('name')
                                
                             $.ajax({
                           type:'POST',
                            url: "includes/delete_post.php",
                            data:{
                              post_id: $attr
                             },
                             success:()=>{
                               location.reload();  
                             }
                        }) 
                            })



                        })

                     </script>

                     <?php
                    
                }
              
                return $postData;
        }

        


     public function getProfilePost($profileUsername){

            $profileData = "";
            $sql = mysqli_query($this->conn, "SELECT * FROM twitter_post WHERE post_delete = 'no' AND (added_by = '{$profileUsername}' OR user_to ='{$profileUsername}') ORDER BY post_id DESC ");

            while($row = mysqli_fetch_array($sql)){
            $postContent = $row['post_content'];
            $addedBy = $row['added_by'];
            $user_To = $row['user_to'];
            $postDate = $row['post_date'];
            $post_id = $row['post_id'];
            
            if ($user_To == 'none') {
                $userTo ="";
            }else{
                $newUser_obj = new Users($conn, $user_To);
                $firstAndLastname = $newUser_obj->getFirstAndLastname();
                $userTo = "to <a href='$user_To'>$firstAndLastname</a>";
              
            }
            ?>  

                <script>
                    function toggle<?php echo $post_id; ?>(){
                        const element = document.getElementById('comment_section<?php echo $post_id; ?>');
                        if(element.style.display = 'none'){
                            element.style.display = 'block';
                        }else{
                            element.style.display = 'none';
                        }
                    }

                </script>

            <?php
            //time
            $posted_date = new DateTime($postDate);
            $date = date('Y-m-d H:i:s');
            $future = new DateTime($date);
            $interval =$posted_date->diff($future);
            $present_date = $interval->format(' %d days ago, %H hrs ago, %i min ago, %s sec ago');

            $addedBy_obj = new Users($this->conn, $addedBy);
            if($addedBy_obj->isClosed()){
                continue;
            }

            //user table
                $sql1 = mysqli_query($this->conn, "SELECT reg_firstname, reg_lastname, profile_pic FROM user_table WHERE reg_surname = '{$addedBy}' ");
                    $row = mysqli_fetch_array($sql1);
                    $userFirstname = $row['reg_firstname'];
                    $userlastname = $row['reg_lastname'];
                    $userprofile_pic = $row['profile_pic'];
          
                //number of comment
                $sql2 = mysqli_query($this->conn, "SELECT * FROM comment WHERE post_id = '{$post_id}' ");
                $numCommentTopost = mysqli_num_rows($sql2);
             

                //delete button
                if ($addedBy === $this->user_obj->getUsername()) {
                    $close_button = "<button id='post_delete$post_id' name='$post_id' class='btn btn-danger'>X</button>";
                }else{
                    $close_button ="";
                }


                if($this->user_obj->isFriends($addedBy)) {
                    
                $profileData .= "<div class='post_data_container'  onClick='javascript:toggle{$post_id}()'>
                                    <div class='imgAndPostContent_wrapper'>
                                        <div class='img_wrapper' >
                                            <a href='$addedBy'><img src='$userprofile_pic' alt='$addedBy' ></a>
                                        </div>

                                        <div class='postContent_wrapper'>
                                            <p><a href=$addedBy>$userFirstname $userlastname </a> <span>$present_date</span> <span>$close_button</span></p>
                                            <p>$postContent</p>
                                        </div>
                                    </div>
                                    <div style='display:flex; margin-top:20px;'>
                                        comment($numCommentTopost)
                                        <iframe scrolling='' frameBorder='0' class='comment_iframe1' src='like_frame.php?post_id={$post_id}'></iframe>
                                    </div>
                                   
                                   
                                    <div class='comment_wrapper' id='comment_section$post_id' style='display:none;'>
                                        <iframe scrolling='' frameBorder='0' class='comment_iframe' src='comment_frame.php?post_id={$post_id}'></iframe>
                                    </div>
                
                
                             </div>
                             <hr>";
                     
                   
                     }    

                    ?>
                     
                     <!-- select the delete element  -->
                     <script>
                        $(document).ready(function(){

                            $("#post_delete<?php echo $post_id ?> ").on('click', ()=>{
                                $attr = $('#post_delete<?php echo $post_id ?> ').attr('name')
                                
                             $.ajax({
                           type:'POST',
                            url: "includes/delete_post.php",
                            data:{
                              post_id: $attr
                             },
                             success:()=>{
                               location.reload();  
                             }
                        }) 
                            })



                        })

                     </script>                       
                    
                    <?php
                }
              
                return $profileData;
        }

}




