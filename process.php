<?php
include_once('connection.php');

    if (isset($_POST['register'])) {
        $errors = array();
        
        if(!isset($_POST['email'])||($_POST['email'] == '')){
                 
            $errors[] =  urlencode('Email address is required');
            var_dump($errors);
        }
        elseif(!(strpos($_POST['email'], "@") > 0) || 
            preg_match("/[^a-zA-Z0-9.@_-]/", $_POST['email'])){
            $errors[] =  urlencode('Email is wrong');
            var_dump($errors);
        }
        else{
            $email = strip_tags(trim(htmlspecialchars($_POST['email'])));
        }


        if(!isset($_POST['username']) || $_POST['username'] == ''){
        
            $errors[] = urlencode('Username is required');
            var_dump($errors);
        
        } elseif(strlen($_POST['username']) < 5){
        
            $errors[] = urlencode('Username must be atleast 6 characters');
            var_dump($errors);
        
        } else{
        
            $username = strip_tags(trim(htmlspecialchars($_POST['username'])));
        }

        if(!isset($_POST['fname']) || $_POST['fname'] == ''){

            $errors[] = urlencode('First name is required');
            var_dump($errors);
        }
        elseif(!preg_match("/[a-zA-Z]/", $_POST['fname'])){
        
            $errors[] = urlencode('First name must contain only alphabets');
            var_dump($errors);
        
        } else{
        
            $firstname = strip_tags(trim(htmlspecialchars($_POST['fname'])));
        }

        if(!isset($_POST['lname']) || $_POST['lname'] == ''){
        
            $errors[] = urlencode('Last name is required');
            var_dump($errors);
        
        } elseif(!preg_match("/[a-zA-Z]/", $_POST['lname'])){
        
            $errors[]=urlencode('Last name must contain only alphabets');
            var_dump($errors);
        } else{
        
            $lastname = strip_tags(trim(htmlspecialchars($_POST['lname'])));
        }

        if(!isset($_POST['password']) || $_POST['password'] == ''){
        
            $errors[]=urlencode('Password is required');
            var_dump($errors);
        
        }
        elseif(strlen($_POST['password']) < 8){
        
            $errors[]=urlencode('Password is atleast 8 characters');
            var_dump($errors);
        
        }
        else{
        $pass= password_hash(strip_tags(trim($_POST['password'])), PASSWORD_DEFAULT);
        }

        if(!isset($_POST['confirmpassword']) || $_POST['confirmpassword'] == ''){
        
            $errors[]=urlencode('Confirm password is required');
            var_dump($errors);
              
        }else{
        $confirmpassword = password_hash(strip_tags(trim($_POST['confirmpassword'])), PASSWORD_DEFAULT);
        }
 
        if ($_POST["password"] != $_POST["confirmpassword"]) {

            $errors[]=urlencode('Passwords dont match');
            var_dump($errors);
        }
        
        $user_registered_date = date("d-m-Y");

        // $username=($_POST['username']);
        // $email=($_POST['email']);

        $query = $db_con->query("SELECT * FROM users WHERE username ='$username' OR email ='$email'");
    
        if($query->num_rows > 0){
            $errors[] = urlencode("There is already a user with those details!!");
            var_dump($errors);
        }

        if(!$errors){

            $sql = "INSERT INTO users(fname,lname,username,password,email,user_registered) VALUES('$firstname','$lastname','$username','$pass','$email','$user_registered_date')";

            if (mysqli_query($db_con, $sql)) {
             echo "New record created successfully";
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db_con);
            }
            mysqli_close($db_con);
        }
    }



