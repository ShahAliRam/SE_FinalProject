<?php
$login = false; 
if (isset($_POST['email'])){
    $server = "localhost";
    $username = "root";
    $password = "";
    $databasename = "chefai";

    $con = mysqli_connect($server,$username,$password,$databasename);

    if(!$con){
        die("Connection to MySQL server failed due to ".mysqli_connect_error());
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
$sql = "SELECT * FROM customer WHERE email = '$email' and password = '$password'";
$result = $con->query($sql);

    if (mysqli_num_rows($result) == 1){
        echo "You have successfully logged in.";
        require("./dashboard.html");
        $login = true;
    }
    else{
        if($con->query($sql) == TRUE){
            echo "Email or Password Incorrect";
            require('./signin.html');
            $login = false;
        }
        else{
            echo "ERROR: $sql <br> $con->error";
            
            $login = false;
        }
    }
    $con->close();
}  
?>



