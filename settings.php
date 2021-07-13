<?php
include 'includes/header.php';
include 'includes/settings_handler.php';
?>

<?php
            $sql = mysqli_query($conn, "SELECT * FROM user_table WHERE reg_surname ='{$_SESSION["surname"]}' ");
            $result = mysqli_fetch_array($sql);
 ?>

<div class='container'>
    <div class="row">
        <div class='col-md-4 mx-auto'>
        <h3 style='padding:10px; background:green;color:white;'>Setting Page</h3>
        <img src="<?php echo $profile_pic ?>" height='150' width='150' class="img-responsive rounded-circle mx-auto d-block" alt="<?php echo $row['reg_surname']; ?>">

        <div class="mb-3">
        <?php echo $upload_message; ?>
            <form action="settings.php" method="post" enctype="multipart/form-data">
                <label for="formFile" class="form-label">Change profile image</label>
                <input class="form-control" name='profile_pic' type="file" id="formFile">
                 <input class='btn btn-primary' type="submit" name='profile_pic_submit_btn' value='Upload picture'>
            </form>
        </div>
<br>
<!-- change firstname, lastname, email -->
        <h4>Change Credentials</h4>
        <?php echo $update_message; ?>
        <form action='settings.php' method='POST'>
        <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" name='firstname' id="firstname" aria-describedby="" value='<?php echo $result['reg_firstname']?>'>
            </div>
        <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" name='lastname' id="lastname" aria-describedby="" value='<?php echo $result['reg_lastname']?>'>
            </div>
            <div class="mb-3">
                <label for="mail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name='mail1' id="mail1" aria-describedby="emailHelp" value='<?php echo $result['reg_email']?>'>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
           
            <button type="submit" name='update_user' class="btn btn-primary">Update User</button>
        </form>

        <br>
       
        <h4>Change Password</h4>
        <?php echo $password_message; ?>
        <form action='settings.php' method='POST'>
            <div class="mb-3">
                <label for="old_Password" class="form-label">Old Password</label>
                <input type="password" name='old_Password' class="form-control" id="old_Password">
            </div>

            <div class="mb-3">
                <label for="new_Password" class="form-label">New Password</label>
                <input type="password" name='new_Password' class="form-control" id="new_Password">
            </div>
            <button type="submit" name='update_password' class="btn btn-primary">Change Password</button>
        </form>

        <br>
<?php 
        if($row['account_closed'] == 'no'){
            ?>
         <h4>Close Account</h4>
        <?php echo $account_close_message; ?>
        <form action='settings.php' method='POST'>
        <button type="submit" name='close_account' class="btn btn-danger">Close Account</button>
        </form>

<?php
        }else {
            ?>
           <h4>Open Account</h4>
        <?php echo $account_close_message; ?>
        <form action='settings.php' method='POST'>
        <button type="submit" name='open_account' class="btn btn-primary">Open Account</button>
        </form>
           <?php
        }
       ?>

        

        </div>
    </div>
</div>