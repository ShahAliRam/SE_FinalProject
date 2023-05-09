<?php
$signup = false;
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
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $orders = rand(0,30);
    $email = mysqli_real_escape_string($con, $_POST['email']);
$sql = "SELECT * FROM customer WHERE email = '$email'";
$result = $con->query($sql);


    if (mysqli_num_rows($result) > 0){
        echo "The Email Address is already taken. Please try again";
    }
    else{
        $sql = "INSERT INTO `chefai`.`customer` (`Email`, `Password`, `Address`, `State`, `City`, `ZipCode`,`num_of_orders`) 
        VALUES ('$email', '$password', '$address', '$state', '$city', '$zip','$orders');";
        

        if($con->query($sql) == TRUE){
            echo "Registered Successfully";
            require("./signin.html");
            $signup = true;
        }
        else{
            echo "ERROR: $sql <br> $con->error";
        }
    }
    $con->close();
}
?>

