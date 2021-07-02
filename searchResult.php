<?php
// session_start();
include 'database\database_config.php';
include 'asset\Classes\Users.php';

//get the sent data in array form
$content = json_decode(file_get_contents('php://input'), true);
$query = $content["query"];
$personLoggedIn = $content["personLoggedIn"];

$name = str_split($query);

if (strpos($content['query'], '-')) {
    $returedQuery = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname LIKE '$query%' AND account_closed ='no' ");
}elseif (count($name) == 2) {
    $returedQuery = mysqli_query($conn, "SELECT * FROM user_table WHERE (reg_firstname LIKE '$name[0]%' AND reg_lastname LIKE  '$name[1]%') AND account_closed ='no' ");
}else {
    $returedQuery = mysqli_query($conn, "SELECT * FROM user_table WHERE (reg_firstname LIKE '$name[0]%' OR reg_lastname LIKE  '$name[1]%') AND account_closed ='no' ");
}

if ($query !=' ') {
  while($sqlFetch = mysqli_fetch_array($returedQuery)){
    $firstname = $sqlFetch['reg_firstname'];
    $lastname = $sqlFetch['reg_lastname'];
    $email = $sqlFetch['reg_email'];
    $password = $sqlFetch['reg_password'];
    $surname = $sqlFetch['reg_surname'];
    $date = $sqlFetch['reg_date'];
    $profile_pic = $sqlFetch['profile_pic'];
    $num_posts = $sqlFetch['num_posts'];
    $num_likes = $sqlFetch['num_likes'];
    $array_friends = $sqlFetch['array_friends'];

    $user_obj = new Users($conn, $surname);
  
    if($personLoggedIn != $surname){
       echo $surname;
    //    echo "<a href=$surname>
    //         <div class='sql_result_wrapper'>
    //             <div class='img_And_namesWrapper'>
    //                 <img src=$user_obj->getProfilePic() alt=''>
    //                 <h3> $user_obj->getFirstAndLastname()</h3>
    //             </div>
    //         </div>
    //     </a>";
       
    }
    

  }
}
