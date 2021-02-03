<?php

class Posts{
private $conn;
private $user;

function __construct($conn, $user){
$this->conn = $conn;
$this->user = new Users($conn, $user);
}


function PostSubmit($body, $userTo){
    $body = mysqli_real_escape_string($this->conn, $body);
    $body = trim($body);

    if (!empty($body)) {
       
       $added_by = $this->user->getUsername();
       if ($userTo == $added_by) {
           $userTo = 'none';
       }
       $date = date('Y-m-d H:i:s');
       $closed_post = 'No';
       $delete_post = 'no';
       $like_post = 0;

       $sql =mysqli_query($this->conn, "INSERT INTO  twitter_post(post_content, added_by,user_to, post_date, userclosed, post_delete, likes)VALUE('$body','$added_by', '$userTo',  '$date', '$closed_post',  '$delete_post', '$like_post')");
       

       $numUserPost = $this->user->numOfPost();
       $numUserPost++;
       $sql = mysqli_query($this->conn, "UPDATE user_table SET num_posts = '{$numUserPost}' WHERE reg_surname = '{$added_by}'");

    }
}

function getPost(){
    $added_by = $this->user->getUsername();
    $sql = mysqli_query($this->conn, "SELECT * FROM twitter_post  WHERE added_by ='{$added_by}'  AND userclosed = 'no'");
    $num = mysqli_num_rows($sql);
    $postData ="";
    if ($num > 0) {
        while($row = mysqli_fetch_array($sql)){
            $postContent = $row['post_content'];
            $addedBy = $row['added_by'];
            $user_To = $row['user_to'];
            $postDate = $row['post_date'];
            $posted_byname = $this->user->getFirstAndLastname();
            $profile_pic = $this->user->getProfilePic();
            
            if ($user_To == 'none') {
                $firstAndLastname = $this->user->getFirstAndLastname();
                $userto = $firstAndLastname;
                $link = "<a href='$addedBy'>$userto</a>". " to ". "<a href='$addedBy'>$userto</a>";
            }

            $posted_date = new DateTime($postDate);
            $date = date('Y-m-d H:i:s');
            $future = new DateTime($date);
            $interval =$posted_date->diff($future);
            // Output — 05 years, 04 months and 17 days
            $present_date = $interval->format(' %d days ago, %H hrs ago, %i min ago, %s sec ago');

                $postData .= "<div class='post_data_container'>
                                    <div class='imgAndPostContent_wrapper'>
                                        <div class='img_wrapper'>
                                            <img src='$profile_pic' alt='$addedBy'>
                                        </div>

                                        <div class='postContent_wrapper'>
                                            <p>$link <span>$present_date</span></p>
                                            <p>$postContent</p>
                                        </div>
                                    </div>
                
                
                
                             </div>
                             <hr>";
                            

        }
    }
    return $postData;
}


}

// WHERE added_by ='{$added_by}'  AND userclosed = 'no'

// $interval->format('%Y years, %M months, %d days, %H hours ago, %i minutes ago, %s ago');