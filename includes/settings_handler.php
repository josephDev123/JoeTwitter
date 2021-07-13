<?php
include 'database/database_config.php';
$_FILES["profile_pic"]["name"] ='';
$_FILES["profile_pic"]["size"] ='';
$upload_message = '';
    $target_dir = "images/profile_pic/";
$target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["profile_pic_submit_btn"])) {
  $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
  if($check !== false) {
    $upload_message.= '<div class="alert alert-danger">File is an image - " . $check["mime"] . "." </div>';
    $uploadOk = 1;
  } else {
    $upload_message.= "<div class='alert alert-danger'>File is not an image.  </div>";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
    $upload_message.= "<div class='alert alert-danger'>Sorry, file already exists. </div>";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["profile_pic"]["size"] > 500000) {
    $upload_message.= "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $upload_message.= "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $upload_message.= "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
    $upload_message.= "The file ". htmlspecialchars( basename( $_FILES["profile_pic"]["name"])). " has been uploaded.";
    $sql =mysqli_query($conn, "UPDATE user_table SET profile_pic ='$target_file' WHERE reg_surname ='{$_SESSION["surname"]}'");
  } else {
    $upload_message.= "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
  }
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