<?php
$fname = $_POST['fname']; 
$lname = $_POST['lname']; 
$email = $_POST['email']; 
$site = $_POST['site']; 
$agency = $_POST['agency']; 
$date = $_POST['date']; 
$address = $_POST['address']; 
$participants = $_POST['participants']; 
$hlthrecord = $_POST['hlthrecord']; 
$nutrassess = $_POST['nutrassess'];
$hsgrant = $_POST['hsgrant']; 
$notes = $_POST['notes']; 

if (!empty($fname) || !empty($lname) || !empty($email) || !empty($site) || !empty($agency) || !empty($date) || !empty($address) || !empty($participants)) {
    $host = "localhost";
    $dbusername = "root"; 
    $dbpassword = ""; 
    $dbname = "headstartspr2"; 

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
    } else {
        $SELECT = "SELECT email From sprint2logtest Where email = ? Limit 366";
        $INSERT = "INSERT Into sprint2logtest (fname, lname, email, site, agency, date, address, participants, hlthrecord, nutrassess, hsgrant, notes) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email); 
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0) {
         $stmt->close();
         
         $stmt = $conn->prepare($INSERT);
         $stmt->bind_param("sssssssissss", $fname, $lname, $email, $site, $agency, $date, $address, $participants, $hlthrecord, $nutrassess, $hsgrant, $notes);
         $stmt->execute(); 
         echo "New record inserted successfully";
        } else {
            echo "Email already registered/expired";
        }
        $stmt-> close(); 
        $conn-> close(); 
    }

} else {
    echo "All fields are required"; 
    die();
}
?> 