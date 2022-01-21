<?php
require_once 'config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

/// Reservering toevoegen aan database zodra je op een button klikt.

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dates = $_POST['dates'];
    $sql = "INSERT INTO reservations (name, email, phone, dates) VALUES ('$name','$email', '$phone', '$dates')";

    if (mysqli_query($link, $sql)) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to KKEC's reservations system.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>

    <form action="welcome.php" method="post">
        Name: <input type="text" required value="" name="name"><br> 
        E-mail: <input type="text" required value="" name="email"><br>
        Telefoonnummer: <input type="text" required value="" name="phone"><br>

    <label for="meeting-time">Choose a time for your appointment:</label>
    <input type="datetime-local" required value="" dates="meeting-time"
         name="dates" value="2022-02-19T19:30"
         min="2022-02-07T00:00" ><br>

    <style> 
    label {
    display: block;
    font: 1rem 'Fira Sans', sans-serif;}

    input,
    label {
    margin: .4rem 0;}
    </style>

    <input type="submit" value="Verzenden" name="submit">
    </form>
</body>
</html>