<?php include './database/database_config.php'; ?>
<?php include "reg_form_includes/reg_form_handler.php";?>
<?php include "reg_form_includes/login_form_handler.php";?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link rel="stylesheet" href="asset/css/bootstrap.css">
    <link rel="stylesheet" href="asset/css/login_reg.css">
   
    <title>Welcome to JoeTwitter</title>
</head>
<body>

<div class="wrapper">
    <div class="login_register_header">
        <h2>JoeTwitter</h2>
        <p>Login or Register</p>

    </div>
        <div id="first_form">
            <form action="reg_form.php" method="POST">
            
                <input type="email" name="login_email" placeholder="Your email" value=" <?php if(isset($_SESSION['login_email'])) echo $_SESSION['login_email']?>"><br>
                <input type="password" name="login_password"><br>
                <input type="submit" name="login_submit" value="Login">
            </form>
            <a href="#" id="signup" class="signup">Need an account? Register</a>
        </div>

        <div id="second_form">
            <form action="reg_form.php" method="POST">
                <?php 
                if (isset($error_array)) {
                    if (in_array("Registration successful<br>", $error_array)) {
                        echo "<div class='alert alert-success'>Registration successful</div><br>";
                    }
                }
                ?>
                <input type="text" name="reg_firstname" placeholder="Enter Firstname" value="<?php if (isset($_SESSION['reg_firstname'])) echo $_SESSION['reg_firstname']; ?>"><br>
            <?php 
                if (isset($error_array)) {
                    if (in_array("Firstname is empty<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Firstname is empty</div><br>";
                    }elseif (in_array("Invalid firstname given<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Invalid firstname given</div><br>";
                    }
                }
            
            ?>

                <input type="text" name="reg_lastname" placeholder="Enter lastname" value="<?php if (isset($_SESSION['reg_lastname'])) echo $_SESSION['reg_lastname']; ?>"><br>

                <?php 
                if (isset($error_array)) {
                    if (in_array("Lastname is empty<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Lastname is empty</div><br>";
                    }elseif (in_array("Invalid lastname given<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Invalid lastname given</div><br>";
                    }
                }
            ?>

                <input type="email" name="reg_email" placeholder="Enter  email"  value="<?php if (isset($_SESSION['reg_email'])) echo $_SESSION['reg_email']; ?>"><br>

                <?php 
                if (isset($error_array)) {
                    if (in_array("Email is empty<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Email is empty</div><br>";
                    }elseif (in_array("Invalid email format<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Invalid email format</div><br>";
                    }
                }
            
            ?>


                <input type="password" name="reg_password" placeholder="Enter password"><br>

                <?php 
                if (isset($error_array)) {

                    if (in_array("Password is empty<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Password is empty</div><br>";
                    }
                    // elseif (in_array("Password Must Contain At Least 8 Characters!<br>", $error_array)) {
                    //     echo "Password Must Contain At Least 8 Characters!<br>";
                    // }elseif (in_array(" Password Must Contain At Least 1 Number!<br>", $error_array)) {
                    //     echo " Password Must Contain At Least 1 Number!<br>";
                    // }elseif (in_array("Password Must Contain At Least 1 Capital Letter!<br>", $error_array)) {
                    //     echo "Password Must Contain At Least 1 Capital Letter!<br>";
                    // }elseif (in_array("Password Must Contain At Least 1 Lowercase Letter!<br>", $error_array)) {
                    //     echo "Password Must Contain At Least 1 Lowercase Letter!<br>";
                    // }
                }
            
            ?>

                <input type="password" name="reg_confirmpassword" placeholder="Confirm password"><br>


                <?php 
                if (isset($error_array)) {
                    if (in_array("Confirm Password is empty<br>", $error_array)) {
                        echo "<div class='alert alert-danger'>Confirm Password is empty</div><br>";
                    }
                    // elseif (in_array("Confirm Password Must Contain At Least 8 Characters!<br>", $error_array)) {
                    //     echo "Confirm Password Must Contain At Least 8 Characters!<br>";
                    // }elseif (in_array("Confirm Password Must Contain At Least 1 Number!<br>", $error_array)) {
                    //     echo "Confirm Password Must Contain At Least 1 Number!<br>";
                    // }elseif (in_array("Confirm Password Must Contain At Least 1 Capital Letter!<br>", $error_array)) {
                    //     echo "Confirm Password Must Contain At Least 1 Capital Letter!<br>";
                    // }elseif (in_array("Confirm Password Must Contain At Least 1 Lowercase Letter!<br>", $error_array)) {
                    //     echo "Confirm Password Must Contain At Least 1 Lowercase Letter!<br>";
                    // }
                }
            
            ?>
                <input type="submit" name="reg_submitBtn" value="Register"><br>
                
            </form>
            <a href="#" id="signin" class="signin">Alway have an account? Login</a>
        </div>
</div>

     <!-- javascript -->
   
     <script src="asset/js/jquery.js"></script>
     <script src="asset/js/bootstrap.js"></script>
      <script src="asset\js\login_reg.js"></script>  

      <?php
        if (isset($_POST['reg_submitBtn'])) {
        echo '

            <script>
                $(document).ready( function() {
                $("#first_form").hide();
                $("#second_form").show();
        
                })
            </script>

        ';

        }
?>
</body>
</html>