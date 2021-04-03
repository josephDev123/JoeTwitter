
<?php

class Users{
private $conn;
private $user;

   public function __construct($conn, $user){
        $this->conn = $conn;
        $sql = mysqli_query($conn, "SELECT * FROM  user_table WHERE reg_surname = '{$user}' ");
        $this->user = mysqli_fetch_array($sql);
    }

    public function getFirstAndLastname(){
        $surname = $this->user['reg_surname'];
        $sql =mysqli_query($this->conn, "SELECT reg_firstname, reg_lastname FROM user_table WHERE reg_surname = '{$surname}' ");
        $row = mysqli_fetch_array($sql);
        return $row['reg_firstname'] .' '. $row['reg_lastname'];
    }

    public function getUsername(){
        $surname = $this->user['reg_surname'];
        $sql = mysqli_query($this->conn, "SELECT reg_surname FROM user_table WHERE reg_surname = '{$surname}'");
        $row = mysqli_fetch_array($sql);
        return $row['reg_surname'];
    }

    public function getProfilePic(){
        $surname = $this->user['reg_surname'];
        $sql = mysqli_query($this->conn, "SELECT profile_pic FROM user_table WHERE reg_surname = '{$surname}'");
        $row = mysqli_fetch_array($sql);
        return $row['profile_pic'];
        
    }


    public function isClosed(){
        $surname = $this->user['reg_surname'];
        $sql = mysqli_query($this->conn, "SELECT account_closed FROM user_table WHERE reg_surname = '{$surname}' ");
        $row = mysqli_fetch_array($sql);
        if ($row['account_closed'] == 'yes') {
         return true;
        }else{
            return false;
        }
    }

    public function numOfPost(){
        $surname = $this->user['reg_surname'];
        $sql = mysqli_query($this->conn, "SELECT num_posts FROM user_table WHERE reg_surname = '{$surname}'");
        $row =mysqli_fetch_array($sql);
        return $row['num_posts'];
    }

    public function numLikes(){
        $surname = $this->user['reg_surname'];
         $sql = mysqli_query($this->conn, "SELECT num_likes FROM user_table WHERE reg_surname = '{$surname}' ");
        $fetch_sql = mysqli_fetch_array($sql);
        return $fetch_sql['num_likes'];
    }

    public function isFriends($surname){
        $friend_array = ','.$surname.',';
        $friends = $this->user['array_friends'];
        if (strstr($friends, $friend_array) || $surname == $this->user['reg_surname']) {
            return true;
        }else{
            return false;
        }
    }

   public function didRecieveRequest($user_to){
        $user_from = $this->user['reg_surname'];
        $sql = mysqli_query($this->conn, "SELECT * FROM friend_Request WHERE user_from = '$user_from' AND user_to = '$user_to' ");
        $check_sql = mysqli_num_rows($sql);
        if($check_sql > 0){
            return true;
        }else{
            return false; 
        }
   }

   public function didSendRequest($user_to){
    $user_from = $this->user['reg_surname'];
    $sql = mysqli_query($this->conn, "SELECT * FROM friend_Request WHERE user_from = '$user_from' AND user_to = '$user_to' ");
    $check_sql = mysqli_num_rows($sql);
    if($check_sql > 0){
        return true;
    }else{
        return false; 
    }
}

public function removeFriend($friend_to_remove){
    $remove_by = $this->user['reg_surname'];
    $sql = mysqli_query($this->conn, "SELECT * FROM user_table WHERE reg_surname = '$friend_to_remove'");
    $sql_fetch = mysqli_fetch_array($sql);
    $friends = $sql_fetch['array_friends'];

    //i removed friend
    $myFriends = $this->user['array_friends'];
    $removeFriend= str_replace($friend_to_remove.',', '', $myFriends);
    $update_sql = mysqli_query($this->conn, "UPDATE user_table SET array_friends = '$removeFriend' WHERE reg_surname = '$remove_by'");

// automatically i am remove from the person i removed friend list
    $removeFriend= str_replace($remove_by.',', '', $friends);
    $update_sql = mysqli_query($this->conn, "UPDATE user_table SET array_friends = '$removeFriend' WHERE reg_surname = '$friend_to_remove'");

}

public function addToFriendRequest($friend_to_add){
    $user_from = $this->user['reg_surname'];
       $sql = mysqli_query($this->conn, "INSERT INTO friend_request(user_from, user_to) VALUES('$user_from', '$friend_to_add')"); 
    
}

public function addFriend($finally_friend_to_add){
    $user_from = $this->user['reg_surname'];
    $myFriends = $this->user['array_friends'];
   $sql = mysqli_query($this->conn, "UPDATE user_table SET array_friends = CONCAT('$myFriends', '$finally_friend_to_add,') WHERE reg_surname = '$user_from'");
//add the user that accept your friend request as friend
   $sql = mysqli_query($this->conn, "UPDATE user_table SET array_friends = CONCAT(array_friends, '$user_from,') WHERE reg_surname = '$finally_friend_to_add'");

   $sql1 = mysqli_query($this->conn, "DELETE FROM friend_request WHERE user_from = '$user_from' AND user_to ='$finally_friend_to_add'");
}

}


