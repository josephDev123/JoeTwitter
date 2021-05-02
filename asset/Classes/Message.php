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
            }else{
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

                $sql2 = mysqli_query($this->conn, "SELECT * FROM message WHERE (user_to = '{$userLogedin}' AND user_from = '{$userTo}') OR (user_to = '{$userTo}' AND user_from = '{$userLogedin}' )  AND message_delete = 'no' ORDER BY id  ");

               
                 
                while($row =mysqli_fetch_array($sql2)){
                    $body = $row['message_body'];
                    $user_to = $row['user_to'];
                    $user_from = $row['user_from'];
                    $div_data = ($user_to != $userLogedin)? "<div class='green'>":"<div class='yellow'>";
                    $data .= $div_data.$body."</div><br><br>";
                }
                  
                    return $data;
                
                    
            }

            public function lastestGetMessage($userloggedIn, $userToUsername){
                $userloggedIn = $this->user_obj->getUsername();
                $details =[];
                $sql = mysqli_query($this->conn, "SELECT * FROM message WHERE (user_to ='{$userloggedIn}' AND user_from ='{$userToUsername}') OR (user_to ='{$userToUsername}' AND user_from ='{$userloggedIn}')  ORDER BY id DESC ");
                while($row = mysqli_fetch_array($sql)){
                    $sent_by = ($row['user_to'] == $userloggedIn)? 'They said':'You said';
                    $message_body = $row['message_body'];
                    $message_date = $row['message_date'];

                    $posted_date = new DateTime($message_date);
                    
                    $date = date('Y-m-d H:i:s');
                    $future = new DateTime($date);
                    $interval = date_diff($posted_date, $future);
                    $present_date = $interval->format(' %d days ago, %H hrs ago, %i min ago');

                    array_push($details, $sent_by);
                    array_push($details, $message_body);
                    array_push($details, $present_date);
                }
                return $details;
            }


            public function get_conversational_list(){
                $userloggedIn = $this->user_obj->getUsername();
                $convoc_div_string = '';
                $usersArray =[];
                $sql = mysqli_query($this->conn, "SELECT user_to, user_from FROM message WHERE user_to ='{$userloggedIn}' OR user_from ='{$userloggedIn}' ORDER BY id DESC LIMIT 8");
                while($row = mysqli_fetch_array($sql)){
                    $users = ( $row['user_to'] !== $userloggedIn)? $row['user_to']: $row['user_from'];
                    if (!in_array($users, $usersArray)) {
                       array_push($usersArray, $users);
                    }
                }

                foreach( $usersArray as $userToUsername){
                    $message_to_obj = new Users($this->conn, $userToUsername);
                    $usertoprofile = $message_to_obj->getProfilePic();
                    $latest_message_detail = $this->lastestGetMessage($userloggedIn, $userToUsername);
                    $fist_lastname = $message_to_obj->getFirstAndLastname();
                
               
                // $latest_message_detail = $this->lastestGetMessage($userloggedIn, $userToUsername);

                //use_to first and lastname
               

               $dot = (strlen($latest_message_detail[1]) > 15)? '...':'';

               if (strlen($latest_message_detail[1] ) > 12) {
                  $message = str_split($latest_message_detail[1], 12);
                  $message =$message[0].$dot;
               }else{
                $message = $latest_message_detail[1];
               }
            

               $convoc_div_string .= "<a href=message.php?u=$userToUsername>  
               <div style='border:2px solid gray; padding:15px; border-radius:5px;' >
                    <img src=$usertoprofile alt=''>
                    <div class='name_date_wrapper'>
                        <h5>$fist_lastname </h5> <span>$latest_message_detail[2] </span>
                    </div>
                    <div class='message_wrapper'>
                    <span><strong> $latest_message_detail[0]</strong></span>:  <span> $message</span>
                    </div>
                
               </a> 
               </div>
               <br>   <br>
               "
               ;
             
            }
              return $convoc_div_string;
           
              
            

        }


 }



//  "<a href='message.php?u='.$userToUsername>
//  <div class='name_date_wrapper'>
//      <h3>$fist_lastname </h3> <span>$latest_message_detail[2] </span>
//  </div>

//  <div class='message_wrapper'>
//      <h3> $latest_message_detail[0]</h3> <span> $message</span>
//  </div>
 
// </a> ";