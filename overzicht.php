<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once ("config.php");
$sql = "SELECT * FROM reservations";
$showresult = mysqli_query($link, $sql)
or die('Error: '.$sql);

//Loop through the result to create a custom array
$reservations = [];
while ($row = mysqli_fetch_assoc($showresult)) {
    $reservations[] = $row;
}
mysqli_close($link);


?>
<!doctype html>
<html lang="en">
<head>
    <title>Reserveringen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="C:\xampp\htdocs\KKEC final\overzicht.css"/>
</head>
<body>
<section>
<style>
    h1 {
        color: white;
    }
</style>
<h1>Inlijst Reserveringen</h1>
<table>
    <thead>
    <tr bgcolor="white">
        <th>#</th>
        <th>Name</th>
        <th>E-mail</th>
        <th>Phonenumber</th>
        <th>Dates</th>
       
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="10" bgcolor="white">&copy; KKEC</td>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($reservations as $reservations) { ?>
        <tr>
            <td><?= htmlspecialchars($reservations['id']); ?></td>
            <td><?= htmlspecialchars($reservations['name']); ?></td>
            <td><?= htmlspecialchars($reservations['phone']); ?></td>
            <td><?= htmlspecialchars($reservations['email']); ?></td>
            <td><?= htmlspecialchars($reservations['Dates']); ?></td>

            <td><a href="edit.php?id=<?= htmlspecialchars($reservations['id']); ?>">Edit</a></td>
            <td><a href="delete.php?id=<?= htmlspecialchars($reservations['id']); ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<form action="overzicht.php">
    <input type="submit" class="btn" value="Refresh Reservations"/>
</form>
<form action="logout.php">
    <input type="submit" class="btn" value="log out"/>
</form>
</section>
</body>
</html>