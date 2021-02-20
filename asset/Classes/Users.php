
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

    public function isFriends($surname){
        $friend_array = ','.$surname.',';
        $friends = $this->user['array_friends'];
        if (strstr($friends, $friend_array) || $surname == $this->user['reg_surname']) {
            return true;
        }else{
            return false;
        }
    }

   

}