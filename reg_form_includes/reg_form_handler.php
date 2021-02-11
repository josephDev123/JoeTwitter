


<?php

if (isset($_POST['reg_submitBtn'])) {

    $reg_firstname =$_POST['reg_firstname'];
    $_SESSION['reg_firstname'] = $reg_firstname;

    $reg_lastname =$_POST['reg_lastname'];
    $_SESSION['reg_lastname'] = $reg_lastname;

    $reg_email =$_POST['reg_email'];
    $_SESSION['reg_email'] = $reg_email;

    $reg_password =$_POST['reg_password'];
    $reg_confirmpassword =$_POST['reg_confirmpassword'];
    $error_array =[];

    //firstname
    $reg_firstname = str_replace(' ', '', $reg_firstname); //remove space from name
    $reg_firstname = ucfirst(strtolower($reg_firstname)); //converts string to lowercase and the first letter to uppercase
    $reg_firstname = strip_tags($reg_firstname); //string html tag from name


    //lastname
    $reg_lastname = str_replace(' ', '', $reg_lastname); //remove space from name
    $reg_lastname = ucfirst(strtolower($reg_lastname)); //converts string to lowercase and the first letter to uppercase
    $reg_lastname = strip_tags($reg_lastname); //string html tag from name

    //password
    $reg_password = str_replace(' ', '', $reg_password); //remove space from name
    $reg_confirmpassword  = str_replace(' ', '', $reg_confirmpassword ); //remove space from name


    //validation firstname
    if(empty($reg_firstname)){
        array_push($error_array, "Firstname is empty<br>");
    }elseif (!preg_match("/^([a-zA-Z' ]+)$/", $reg_firstname)){
        array_push($error_array, "Invalid firstname given<br>");
    }

     //validation lastname
     if(empty($reg_lastname)){
        array_push($error_array, "Lastname is empty<br>");
    }elseif (!preg_match("/^([a-zA-Z' ]+)$/", $reg_lastname)){
        array_push($error_array, "Invalid lastname given<br>");
    }

      //validation email
      if(empty($reg_email)){
        array_push($error_array, "Email is empty<br>");
    }elseif (!filter_var( $reg_email, FILTER_VALIDATE_EMAIL)) {
        array_push($error_array, "Invalid email format<br>");
    }


       //validation password
       if(empty($reg_password)){
        array_push($error_array, "Password is empty<br>");
        }
        // elseif (strlen($reg_password) < 8) {
        //     array_push($error_array, "Password Must Contain At Least 8 Characters!<br>");
        // } 
        // elseif(!preg_match("#[0-9]+#", $reg_password)) {
        //     array_push($error_array, " Password Must Contain At Least 1 Number!<br>");
        // }
        //  elseif(!preg_match("#[A-Z]+#", $reg_password)) {
        //     array_push($error_array, "Password Must Contain At Least 1 Capital Letter!<br>");
        // } 
        // elseif(!preg_match("#[a-z]+#", $reg_password)) {
        //     array_push($error_array, "Password Must Contain At Least 1 Lowercase Letter!<br>");
        // }

    //validation confirmpassword
    if(empty($reg_confirmpassword)){
        array_push($error_array, "Confirm Password is empty<br>");
        }
        // elseif (strlen($reg_confirmpassword) < 8) {
        //     array_push($error_array, "Confirm Password Must Contain At Least 8 Characters!<br>");
        // } 
        // elseif(!preg_match("#[0-9]+#", $reg_confirmpassword)) {
        //     array_push($error_array, "Confirm Password Must Contain At Least 1 Number!<br>");
        // }
        // elseif(!preg_match("#[A-Z]+#", $reg_confirmpassword)) {
        //     array_push($error_array, "Confirm Password Must Contain At Least 1 Capital Letter!<br>");
        // }
        //  elseif(!preg_match("#[a-z]+#", $reg_confirmpassword)) {
        //     array_push($error_array, "Confirm Password Must Contain At Least 1 Lowercase Letter!<br>");
        // }

        //check password == confirmpassword
        if ($reg_confirmpassword !== $reg_password) {
            array_push($error_array, "Password not match");
        }

        if(empty($error_array)) {
            $reg_surname = $reg_firstname.'-'.$reg_lastname.mt_rand();
            $randImage = rand(1,2);
            if ($randImage == 1) {
                $profile_pic = "asset/images/profile_pic/download.png";
            }elseif($randImage == 2){
                $profile_pic = "asset/images/profile_pic/download.jpg";
            }
           
            // $reg_password = password_hash($reg_password, PASSWORD_DEFAULT);
            $reg_password = md5($reg_password);

            $sql="SELECT * FROM user_table WHERE reg_email = '$reg_email' OR reg_password = '$reg_password'";
            $selectFrmDb = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($selectFrmDb);

            if ($num > 0) {
            //   $fetchData= mysqli_fetch_assoc( $selectFrmDb);
            //     $database_email = $fetchData['reg_email'];
            //     $database_password = $fetchData['reg_password'];

            //     if ($database_email === $reg_email || $database_password === $reg_password) {
                   array_push($error_array, "you have already registered<br>");
                // }
                
            }else{
                $sql ="INSERT INTO user_table ( reg_firstname, reg_lastname, reg_email, reg_password, reg_surname, reg_date, profile_pic, num_posts, num_likes, account_closed) VALUES ('$reg_firstname', '$reg_lastname', '$reg_email', '$reg_password', '$reg_surname', now(), '$profile_pic', 0, 0, 'no')";
                $insertIntoDb = mysqli_query($conn, $sql);
                array_push($error_array, "Registration successful<br>");
          
            }


        }

}



?>