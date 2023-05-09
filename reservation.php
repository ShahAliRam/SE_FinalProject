<?php
$available = false;
if (isset($_POST['name'])){
    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server,$username,$password);

    if(!$con){
        die("Connection to MySQL server failed due to ".mysqli_connect_error());
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $comments = $_POST['comments'];

    $sql = "SELECT * FROM `chefai`.`reservation` WHERE `products`.`reservation`.`time` = '$time' and `products`.`reservation`.`date` = '$date';";

    $checkReservations = $con->query($sql);

    if (mysqli_num_rows($checkReservations) == 2){
        $available = false;
    }
    else{
        $sql = "INSERT INTO `chefai`.`reservation` (`Name`, `Phone`, `Time`, `Date`, `Comments`) 
        VALUES ('$name', '$phone', '$time', '$date', '$comments');";
        

        if($con->query($sql) == TRUE){
            echo "Reservation Booked Successfully";
            $available = true;
        }
        else{
            echo "ERROR: $sql <br> $con->error";
        }
    }
    if($available == false){
        $sql = 'select * from `chefai`.`reservation`;';
        $check = $con->query($sql);
        if (mysqli_num_rows($check) > 0){
            require("./reservationsSearch.html");
                
            
            // Convert the input date to the Unix timestamp
            $timestamp = strtotime($date);

            // Convert the Unix timestamp to the desired output format
            $output_date = date("d-m-y", $timestamp);

            $reservations = $con->query('SELECT `date`, `time` FROM `products`.`reservation`;');

            $start_time = "09:00:00";
            $end_time = "18:00:00";
           
            $time_slots = array();
            $available_slots = array();
            
            $start_timestamp = strtotime($start_time);
            $end_timestamp = strtotime($end_time);
            
            
          
            $counter = 0;
            for ($i = $start_timestamp; $i < $end_timestamp; $i += 1200) {
              $time_slots[$counter] = date("H:i:s", $i);
              $counter+=1;
            }
            $counter = 0; 

            foreach ($reservations as $reservation) {
                $booked_time = false;
                if ($reservation['date'] == $date) {
                    $reserved_time = $reservation['time'];
                    
                    foreach ($time_slots as $time_slot){
                        if ($reserved_time != $time_slot){
                            $booked_time = true;
                            $available_slots[$counter] = $time_slot;
                            $counter+=1;
                        }
                    }
                }
            }

            // Print the available time slots
            echo 'Available time slots for ' . $output_date . ':<br>';
            foreach ($available_slots as $available_time) {
                echo "                                                 $available_time" . '<br>';
            }

            if ($counter == 0){
                echo "No Time Available";
            }
        }
        else{
            echo "No Time Available";
        }
    }
}
$con->close();
?>

