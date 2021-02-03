
<?php

class Users{
private $conn;
private $user;

    function __construct($conn, $user){
        $this->conn = $conn;
        $sql = mysqli_query($conn, "SELECT * FROM  user_table WHERE reg_surname = '{$user}' ");
        $this->user = mysqli_fetch_array($sql);
    }

    function getFirstAndLastname(){
        $surname = $this->user['reg_surname'];
        $sql =mysqli_query($this->conn, "SELECT reg_firstname, reg_lastname FROM user_table WHERE reg_surname = '{$surname}' ");
        $row = mysqli_fetch_array($sql);
        return $row['reg_firstname'] .' '. $row['reg_lastname'];
    }

    function getUsername(){
        return $this->user['reg_surname'];
    }

    function getProfilePic(){
        return $this->user['profile_pic'];
    }

    function numOfPost(){
        $surname = $this->user['reg_surname'];
        $sql = mysqli_query($this->conn, "SELECT num_posts FROM user_table WHERE reg_surname = '{$surname}'");
        $row =mysqli_fetch_array($sql);
        return $row['num_posts'];
    }

}