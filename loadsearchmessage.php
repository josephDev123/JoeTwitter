<?php
include 'database/database_config.php';
include 'asset/Classes/Users.php';



$userLoggedIn = $_POST['user_from'];
$value = $_POST['content'];
$getnewfriend ='';
// $returned ='';
$split_value = explode(' ', $value);

// if (in_array('-', $split_value)) {
//     $returned .= mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname LIKE '{$value}%' AND account_closed ='no'");
// }else
// }
// else{
//     $returned = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_firstname LIKE '%{$split_value[0]}%' OR reg_lastname LIKE '%{$split_value[1]}%' AND account_closed ='no'");
// }


if(count($split_value) == 2){
    $returned = mysqli_query($conn, "SELECT * FROM user_table WHERE (reg_firstname LIKE '%$split_value[0]%' OR reg_lastname LIKE '%$split_value[0]%' ) AND account_closed ='no'");
if ($value !=='') {
    while($row = mysqli_fetch_array($returned)){
        $user_firstname = $row['reg_firstname'];
        $user_lastname = $row['reg_lastname'];
        $user_username = $row['reg_surname'];
        $user_profilepic = $row['profile_pic'];
        
        $userTo = ($user_username !=$userLoggedIn)? $user_username:'';
        // $user_obj = new Users($conn, $userLoggedIn);
        $user_obj = new Users($conn, $userTo);
        if ($user_obj->isFriends($userTo)) {
          echo "<div class='' style='background-color:white;'>
                    <div class='imgMessageWrapper'>
                         <img src='{$user_profilepic}' alt='profile pic'>
                    </div>
                     $user_obj->getFirstAndLastname();
                     $user_firstname.' '.$user_lastname; 
                </div> ";
           
                        }         
            }
          
    }
}


