<?php
include 'database/database_config.php';


if(isset($_FILES['profile_pic'])){
  $errors= '';
  $file_name = $_FILES['profile_pic']['name'];
  $file_size =$_FILES['profile_pic']['size'];
  $file_tmp =$_FILES['profile_pic']['tmp_name'];
  $file_type=$_FILES['profile_pic']['type'];
  $file_ext=strtolower(end(explode('.', $file_name)));
  
  $extensions= array("jpeg","jpg","png");
  
  if(in_array($file_ext,$extensions)=== false){
     $errors.="<div class='alert alert-success'>extension not allowed, please choose a JPEG or PNG file.</div>";
  }
  
  if($file_size > 2097152){
     $errors.="<div class='alert alert-success'>File size must be excately 2 MB </div>";
  }
  
  if(empty($errors)==true){
     move_uploaded_file($file_tmp, "asset/images/profile_pic/".$file_name);
     $upload = "<div class='alert alert-success'>Success </div>";
     $sql =mysqli_query($conn, "UPDATE user_table SET profile_pic ='asset/images/profile_pic/$file_name' WHERE reg_surname ='{$_SESSION["surname"]}'");
    //  header('Location: settings.php');
  }
  // else{
  //    print_r($errors);
  // 
}else{
  $upload ='';
  $errors = '';
}







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



//change password handler
if(isset($_POST['update_password'])){
    if (empty($_POST['old_Password']) || empty($_POST['new_Password'])) {
        $password_message = "<div class='alert alert-danger' role='alert'>Password(s) is empty</div>";
    }else{

    $old_password =  md5($_POST['old_Password']);
    $new_Password = md5($_POST['new_Password']);

    $sql = mysqli_query($conn, "SELECT reg_password FROM user_table WHERE reg_surname ='{$_SESSION["surname"]}'");
    $result = mysqli_fetch_array($sql);
    $password = $result['reg_password'];
    if ($old_password == $password) {
        $sql2 = mysqli_query($conn, "UPDATE user_table SET reg_password ='{$new_Password}' WHERE reg_surname = '{$_SESSION["surname"]}'");
        $password_message = "<div class='alert alert-success' role='alert'>User password updated</div>";
    }else{
        $password_message = "<div class='alert alert-danger' role='alert'>User old password does not match</div>";
    }       
    }
    }else{
    $password_message ='';
}



// close users account code handler
if (isset($_POST['close_account'])) {
 $sql =mysqli_query($conn, "UPDATE user_table SET account_closed ='yes' WHERE reg_surname ='{$_SESSION["surname"]}'");
 $account_close_message = "<div class='alert alert-danger' role='alert'>User's account terminated. However, You can re-open account</div>";
 header('Location: settings.php');
}else {
    $account_close_message = "";
}

// open users account code handler

if (isset($_POST['open_account'])) {
    $sql =mysqli_query($conn, "UPDATE user_table SET account_closed ='no' WHERE reg_surname ='{$_SESSION["surname"]}'");
    $account_open_message = "<div class='alert alert-danger' role='alert'>User's account re-open. Happy tweeting</div>";
    header('Location: settings.php');
   }else {
       $account_open_message = "";
   }