<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'mysqldb';

// Establish a connection to the database
$connection = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$name = $_POST['name'];
$car = $_POST['cars'];
$email = $_POST['email'];
$taxi = $_POST['taxi'];
$extras = $_POST['extras'];
$date = $_POST['date'];
$pickupPl = $_POST['pickupPl'];
$dropoff = $_POST['dropoff'];
$ints = $_POST['ints'];
$password = $_REQUEST['pwd'];

// Convert extras to a comma-separated string
$extrasString = implode(',', $extras);

// Check if any required field is empty
if (empty($name) || empty($email) || empty($car) || empty($taxi) || empty($extras) || empty($date) || empty($pickupPl) || empty($dropoff) || empty($ints) || empty($password)) {
    echo "Fill All the Fields!<br>";
    echo '<a href="index.html">Go Back</a>';
} else {
    $extrasPassword = implode(',', $password);
    $extrasCars = implode(',', $car);
    $extrasTaxi = implode(',', $taxi);
    $sql = "INSERT INTO users (name, email, taxi, extras, date, pickupPl, dropoff, car, ints, password) VALUES ('$name', '$email', '$extrasTaxi', '$extrasString', '$date', '$pickupPl', '$dropoff', '$extrasCars', '$ints', '$extrasPassword')";
    
    if (mysqli_query($connection, $sql)) {
        echo "<script> alert('Data Inserted Successfully'); </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>
