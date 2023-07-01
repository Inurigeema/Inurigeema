<html>
<head>
  </head>
<body>
  <br>
<form action="store_data.php" method="post">
  
<!-- TEXT -->
<table>
  <tr>
    <td><label for="name">Name:</label></td>
   <td><input type="text" id="name" name="name" ></td>
</tr>
<tr>
   <td><label for="email">Email:</label></td>
  <td><input type="email" id="email" name="email"></td>
</tr>
<tr>
  <td><label for="phone_number">Phone Number:</label></td>
  <td><input type="tel" id="phone_number" name="phone_number"></td> 
  <td>(ex: +60182101568)</td>
</tr>
<tr>
  <td><label for="submission_date">Phone Number:</label></td>
  <td><input type="date" id="submission_date" name="submission_date"></td> 
</tr>
</table>
<!-- submit -->
<input class="button" type="submit" value="Submit">
</form>
</form>
</body>
<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'form';

// Establish a connection to the database
$connection = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $email = $phone_number = $submission_date = "";
$nameErr = $emailErr = $phone_numberErr = $submission_dateErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required.<br>";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required.<br>";
    } else {
        $email = test_input($_POST["email"]);
    }
    
    if (empty($_POST["phone_number"])) {
        $phone_numberErr = "Phone Number is required.<br>";
    } else {
        $phone_number = test_input($_POST["phone_number"]);
    }
    
    if (empty($_POST["submission_date"])) {
        $submission_dateErr = "Submission date is required.";
    } else {
        $submission_date = test_input($_POST["submission_date"]);
    }
}

if (empty($nameErr) && empty($emailErr) && empty($phone_numberErr) && empty($submission_dateErr)) {
    // Check if the form data has already been submitted
    $checkDuplicateQuery = "SELECT * FROM form_submissions WHERE name = '$name' AND email = '$email' AND phone_number = '$phone_number' AND submission_date = '$submission_date'";
    $result = mysqli_query($connection, $checkDuplicateQuery);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script> alert('Data has already been submitted.'); </script>";
    } else {
        // Insert the form data into the database
        $sql = "INSERT INTO form_submissions (name, email, phone_number, submission_date) VALUES ('$name', '$email', '$phone_number', '$submission_date')";
        if (mysqli_query($connection, $sql)) {
            echo "<script> alert('Data Inserted Successfully'); </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
} else {
    echo $nameErr . $emailErr . $phone_numberErr . $submission_dateErr;
}

// Close the database connection
mysqli_close($connection);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
