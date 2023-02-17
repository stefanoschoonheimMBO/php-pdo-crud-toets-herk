<?php
require('config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    if ($pdo) {
        // echo "Verbinding";
    } else {
        // echo "Interne error";
    }
} catch(PDOException $e) {
    $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Er is op het formulier knopje gedrukt";
    try {
        $sql = "UPDATE DureAuto
                SET Merk = :Merk,
                    Model = :Model,
                    Topsnelheid = :Topsnelheid,
                    Prijs = :Prijs
                
                WHERE Id = :Id";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':Id', $_POST['id'], PDO::PARAM_INT);
        $statement->bindValue(':Merk', $_POST['Merk'], PDO::PARAM_STR);
        $statement->bindValue(':Model', $_POST['Model'], PDO::PARAM_STR);
        $statement->bindValue(':Topsnelheid', $_POST['Topsnelheid'], PDO::PARAM_INT);
        $statement->bindValue(':Prijs', $_POST['Prijs'], PDO::PARAM_STR);

        $statement->execute();

        header('Refresh:3; url=index.php');
    } catch(PDOException $e) {
        echo 'Het record is niet geupdate, probeer het opnieuw.'; 
        header('Refresh:3; url=index.php');
    }
    exit();
} 

$sql = "SELECT Id
              ,Merk as ME
              ,Model as MO
              ,Topsnelheid as TS
              ,Prijs as PR

        FROM DureAuto
        WHERE Id = :Id";

$statement = $pdo->prepare($sql);

$statement->bindValue(':Id', $_GET['id'], PDO::PARAM_INT);

$statement->execute();

$result = $statement->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>PDO CRUD HER</title>
</head>
<body>
    <h3>Wijzig het record van de Auto</h3>

    <form action="update.php" method="post">
        <label for="Merk">Merk:</label><br>
        <input type="text" id="Merk" name="Merk" value="<?= $result->ME ?>"><br>
        <br>
        <label for="Merk">Model:</label><br>
        <input type="text" id="Model" name="Model" value="<?= $result->MO ?>"><br>
        <br>
        <label for="Merk">Topsnelheid:</label><br>
        <input type="number" id="Topsnelheid" name="Topsnelheid" value="<?= $result->TS ?>"><br>
        <br>
        <label for="Prijs">Prijs:</label><br>
        <input type="number" id="Prijs" name="Prijs" value="<?= $result->PR ?>"><br>
        <br>
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <input type="submit" value="Verstuur">

    </form>    
</body>
</html>