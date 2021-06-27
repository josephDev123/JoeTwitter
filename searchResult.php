<?php
include 'database\database_config.php';
include 'asset\Classes\Users.php';

// $query = $_POST['query'];
// $personLoggedIn = $_POST['personLoggedIn'];
$content = json_decode(file_get_contents('php://input'), true);

// $name = explode($query, ' ');

// if (strpos($query, '-')) {
//     $returedQuery = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname LIKE '$query%' AND account_closed ='no' ");
// }elseif (count($name) == 2) {
//     $returedQuery = mysqli_query($conn, "SELECT * FROM user_table WHERE (reg_firstname LIKE '$name[0]%' AND reg_lastname LIKE  '$name[1]%') AND account_closed ='no' ");
// }else {
//     $returedQuery = mysqli_query($conn, "SELECT * FROM user_table WHERE (reg_firstname LIKE '$name[0]%' || reg_lastname LIKE  '$name[1]%') AND account_closed ='no' ");
// }

// if ($query !='') {
  
// }
echo $content['query'] ;


