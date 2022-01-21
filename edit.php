<?php
//Require database in this file & image helpers
require_once "config.php";


        //Update the reservation in the database
    $stmt = $link->prepare("UPDATE `reservations`
                  SET  `name` = ?, `phone` = ?, `email` = ? `dates` = ? 
                  WHERE `id` = ?");
    $stmt->bind_param("ssii", $name, $email, $phone, $Dates);

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $reservations   = mysqli_escape_string($link, $_POST['id']);
    $name           = mysqli_escape_string($link, $_POST['name']);
    $phone          = mysqli_escape_string($link, $_POST['email']);
    $email           = mysqli_escape_string($link, $_POST['phone']);
    $Dates           = mysqli_escape_string($link, $_POST['Dates']);

    function getErrorsForFields($name, $email, $phone, ) {
//Check if data is valid & generate error if not so
        $errors = [];
        if ($name == "") {
            $errors[] = 'your Name cannot be empty';
        }
        if ($email == "") {
            $errors[] = 'your phone number cannot be empty';
        }
        if ($phone == "") {
            $errors[] = ' your E-mail cannot be empty';
        }
        if ($phone == "") {
            $errors[] = ' the date cannot be empty';
        }
        }
        return $errors;
    
    $errors = getErrorsForFields($name, $email, $phone);

    $hasErrors = !empty($errors);

    //Save variables to array so the form won't break
    //This array is build the same way as the db result
    $reserveren = [
        'id'             => $name,
        'naam'           => $email,
        'telefoonnummer' => $phone,
        'date'           => $Dates,
    ];
    $stmt->execute();

    if (empty($errors)) {
            header('Location: overzicht.php');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($link);
        }


} else if(isset($_GET['id'])) {
    //Retrieve the GET parameter from the 'Super global'
    $reserverenId = $_GET['id'];

    //Get the record from the database result
    $query = "SELECT * FROM reserveringssysteem WHERE id = " . mysqli_escape_string($link, $reservations);
    $result = mysqli_query($link, $query);
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
    header('Location: overzicht.php');
    exit;
}

//Close connection
mysqli_close($link);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Edit - <?= $reservations['id'] . ' - ' . $reservations['naam'] ?></title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="C:\xampp\htdocs\KKEC final\edit.css"/>
</head>
<body>
<style>
    h1 {
        color: white;
    }
</style>
<h1>Edit - <?= $reservations['id'] . ' - ' . $reservations['naam'] ?></h1>
<?php if (isset($errors) && !empty($errors)) { ?>
    <ul class="errors">
        <?php for ($i = 0; $i < count($errors); $i++) { ?>
            <li><?= $errors[$i]; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<?php if (isset($success)) { ?>
    <p class="success">Je reservering is bijgewerkt in de database</p>
<?php } ?>


<form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="Uw Naam">Naam</label>
        <input id="naam" type="text" placeholder="Uw Naam" name="naam" value="<?= $reserveren['naam'] ?>" required/>
        <span class="errors"><?= (isset($errors['naam']) ? $errors['naam'] : '') ?></span>
    </div>
    <div class="data-field">
        <label for="Uw Telefoonnummer">Telefoonnummer</label>
        <input id="telefoonnummer" type="text" placeholder="Uw Telefoonnummer" name="telefoonnummer" value="<?= $reserveren['telefoonnummer'] ?>" required/>
        <span class="errors"><?= isset($errors['telefoonnummer']) ? $errors['telefoonnummer'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="Uw E-mail">Email</label>
        <input id="email" type="email" placeholder="Uw E-mail" name="mail" value="<?= $reserveren['mail'] ?>" required/>
        <span class="errors"><?= isset($errors['mail']) ? $errors['mail'] : '' ?></span>
    </div>
</form>
<form action="overzicht.php">
    <input type="submit" class="btn" value="Ga terug naar reserveringslijst"/>
</form>
</body>
</html>