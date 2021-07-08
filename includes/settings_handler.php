<?php
include 'database/database_config.php';

if (isset($_POST['update_user'])) {
    $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
    $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
    $email = htmlspecialchars(strip_tags($_POST['mail1']));

    $query = mysqli_query($conn, "SELECT reg_email FROM user_table WHERE reg_email ='{$email}' AND reg_surname ='{$_SESSION["surname"]}' ");
    $num_row = mysqli_num_rows($query);
    if ($num_row > 0) {
       mysqli_query($conn, "UPDATE user_table SET reg_firstname ='{$firstname}', reg_lastname ='{$lastname}', reg_email ='{$email}' WHERE reg_surname ='{$_SESSION["surname"]}' ");
       $update_message = "<div class='alert alert-success' role='alert'>User credentials updated</div>";
    }else {
        mysqli_query($conn, "UPDATE user_table SET reg_firstname ='{$firstname}', reg_lastname ='{$lastname}', reg-email ='{$email}' WHERE reg_surname ='{$_SESSION["surname"]}' ");
       $update_message = "<div class='alert alert-success' role='alert'>User credentials updated</div>";
    }


}else {
    $update_message = '';
}
