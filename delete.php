<?php
//Require reservering data to use variable in this file
require_once "config.php";

if (isset($_POST['submit'])) {
    // DELETE DATA
    // Remove the reservation data from the database
    $query = "DELETE FROM reservations WHERE id = " . mysqli_escape_string($link, $_POST['id']);

    mysqli_query($link, $query) or die ('Error: '.mysqli_error($link));

    //Close connection
    mysqli_close($link);

    //Redirect to homepage after deletion & exit script
    header("Location: overzicht.php");
    exit;

} else if(isset($_GET['id'])) {
    //Retrieve the GET parameter from the 'Super global'
    $reservations = $_GET['id'];

    //Get the reservation from the database result
    $query = "SELECT * FROM reservations WHERE id = " . mysqli_escape_string($link, $reservations);
    $result = mysqli_query($link, $query) or die ('Error: ' . $query );

    if(mysqli_num_rows($result) == 1)
    {
        $reservations = mysqli_fetch_assoc($result);
    }
    else {
        // redirect when db returns no result
        header('Location: overzicht.php');
        exit;
    }
} else {
    // Id was not present in the url OR the form was not submitted

    // redirect to overzicht.php
    header('Location: overzicht.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="C:\xampp\htdocs\KKEC final\delete.css"/>
    <title>Delete - <?= $reservations['id'] . ' - ' . $reservations['naam'] ?></title>
</head>
<body>
<style>
    h2 {
        color: white;
    }
    .red-color {
        color: #e73a3f;
    }
</style>
<h2>Delete - <?= $reservations['id'] . ' - ' . $reservations['naam'] ?></h2>
<form action="" method="post">
    <p class="red-color">
        Are you sure you want to delete this reservation? "<?= htmlspecialchars($reservations['name'])?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $reservations['id'] ?>"/>
    <input type="submit" class="btn" name="submit" value="Verwijderen"/>
</form>
<form action="overzicht.php">
<input type="submit" class="btn" value="Ga terug naar reserveringslijst"/>
</form>
</body>
</html>
