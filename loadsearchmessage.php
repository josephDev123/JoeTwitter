<?php
include 'asset/Classes/Users.php';
include 'database/database_config.php';


$userLoggedIn = $_POST['user_from'];
$value = $_POST['content'];
$getnewfriend ='';
$returned ='';
$split_value = explode(' ', $value);

if (in_array('-', $split_value)) {
    $returned .= mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname LIKE '{$value}%' AND account_closed ='no'");
}elseif(count($split_value) > 3){
    $returned .= mysqli_query($conn, "SELECT * FROM user_table WHERE (reg_firstname LIKE '{$split_value[0]}%' AND reg_lastname LIKE '{$split_value[1]}%') AND account_closed ='no'");
}
// else{
//     $returned = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_firstname LIKE '%{$split_value[0]}%' OR reg_lastname LIKE '%{$split_value[1]}%' AND account_closed ='no'");
// }

if (strlen($value) > 1) {
    while($row = mysqli_fetch_array($returned)){
        $user_firstname = $row['reg_firstname'];
        $user_lastname = $row['reg_lastname'];
        $user_username = $row['reg_surname'];
        $user_profilepic = $row['profile_pic'];
        
        $userTo = ($user_username !=$userLoggedIn)? $user_username:'';
        // $user_obj = new Users($conn, $userLoggedIn);
        $user_obj = new Users($conn, $userTo);
        if ($user_obj->isFriends($userTo)) {
           $getnewfriend.=" <div class=''>
                                <div class='imgMessageWrapper'>
                                     <img src='$user_profilepic' alt='profile pic'>
                                </div>
                              $user_obj->getFirstAndLastname();
                            </div> ";
                }
            }
            return $getnewfriend;
    }