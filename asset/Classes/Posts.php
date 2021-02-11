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
            
            if ($user_To == 'none') {
                $userTo ="";
            }else{
                $newUser_obj = new Users($conn, $user_To);
                $firstAndLastname = $newUser_obj->getFirstAndLastname();
                $userTo = "to <a href='$user_To'>$firstAndLastname</a>";
              
            }

            
            $posted_date = new DateTime($postDate);
            $date = date('Y-m-d H:i:s');
            $future = new DateTime($date);
            $interval =$posted_date->diff($future);
            $present_date = $interval->format(' %d days ago, %H hrs ago, %i min ago, %s sec ago');

            $addedBy_obj = new Users($this->conn, $addedBy);
            if($addedBy_obj->isClosed()){
                continue;
            }

            
                $sql1 = mysqli_query($this->conn, "SELECT reg_firstname, reg_lastname, profile_pic FROM user_table WHERE reg_surname = '{$addedBy}' ");
                $row = mysqli_fetch_array($sql1);
                $userFirstname = $row['reg_firstname'];
                $userlastname = $row['reg_lastname'];
                $userprofile_pic = $row['profile_pic'];
          

                $postData .= "<div class='post_data_container'>
                                    <div class='imgAndPostContent_wrapper'>
                                        <div class='img_wrapper'>
                                            <a href='$addedBy'><img src='$userprofile_pic' alt='$addedBy'></a>
                                        </div>

                                        <div class='postContent_wrapper'>
                                            <p><a href=$addedBy>$userFirstname $userlastname </a>$userTo <span>$present_date</span></p>
                                            <p>$postContent</p>
                                        </div>
                                    </div>
                
                
                             </div>
                             <hr>";
                            
                            
        }
        return $postData;
    
 
}


}

// WHERE added_by ='{$added_by}'  AND userclosed = 'no'

// $interval->format('%Y years, %M months, %d days, %H hours ago, %i minutes ago, %s ago');