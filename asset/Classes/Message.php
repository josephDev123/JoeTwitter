<?php

class Messages{
    private $conn;
    private $user_obj;

    public function __construct($conn, $user){
        $this->conn = $conn;
        $this->user_obj = new Users($conn, $user);

    }

        public function getMostRecentUser(){
           $userLogedin = $this->user_obj->getUsername();
           $sql = mysqli_query($this->conn, "SELECT user_to, user_from FROM message WHERE user_to = '{$userLogedin}' OR user_from='{$userLogedin}' ORDER BY id DESC LIMIT 1 ");
            if(mysqli_num_rows($sql) == 0){
                return FALSE;
            }
            while($row = mysqli_fetch_array($sql)){
                $user_to = $row['user_to'];
                $user_from = $row['user_from'];
    
                if ($user_to != $userLogedin) {
                    return $user_to;
                }else{
                    return $user_from;
                }
            }
           
        }

        public function sendMessage($message, $user_to ){
            if($message !=""){
                $userLogedin = $this->user_obj->getUsername();
                $message_date = date('Y:m:d H:i:s');
                
                $sql = mysqli_query($this->conn, "INSERT INTO message( user_to, user_from, message_body, message_date, viewed, opened, message_delete) VALUES('$user_to', '$userLogedin', '$message', '$message_date', 'no', 'no', 'no')");
            }
        }


            public function getMessage($userTo){
                $data = "";
                $userLogedin = $this->user_obj->getUsername();
                $sql = mysqli_query($this->conn, "UPDATE message SET viewed = 'yes' WHERE user_to = '{$userLogedin}'");

                $sql2 = mysqli_query($this->conn, "SELECT * FROM message WHERE user_to = ('{$userLogedin}' AND user_from = '{$userTo}') OR user_to = ('{$userTo}' AND user_from = '{$userLogedin}' )  AND message_delete = 'no' ORDER BY id DESC ");

               
                 
                while($row =mysqli_fetch_array($sql2)){
                    $body = $row['message_body'];
                    $user_to = $row['user_to'];
                    $user_from = $row['user_from'];
                    
                    // if ($user_to != $userLogedin) {
                    //     return $user_to;
                    // }else{
                    //     return $user_from;
                    // }

                    $div_data = ($user_to != $userLogedin)? "<div class='green'>":"<div class='yellow'>";
                    $data .= $div_data.$body."</div>";
                }
                  
                    return $data;
                
                    
            }


}




