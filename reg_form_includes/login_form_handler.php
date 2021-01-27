<?php
session_start();
if (isset($_POST['login_submit'])) {
    $login_email = filter_var($_POST['login_email'], FILTER_VALIDATE_EMAIL);

    $_SESSION['login_email'] = $login_email;
    $login_password = md5($_POST['login_password']);


    $sql ="SELECT * FROM  joetwitter_table WHERE reg_email = '$login_email' AND reg_password = '$login_password'";
    $selectDbquery = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($selectDbquery);
    if ($num > 0) {
        $dbusers= mysqli_fetch_array($selectDbquery);
         $dbusers['reg_email'];
         $dbusers['reg_password'];
         $dbusers['reg_firstname'];
             header('Location: index.php');
             $_SESSION['firstname'] = $dbusers['reg_firstname'];
        
    }else{
        // array_push($error_array, "Have not registered yet<br>");
        echo "Have not registered yet<br>";
    }
}