<?php
    /**
     * Maak een verbinding met de mysql-server en database
     */

    // 1. Voeg een configuratiebestand toe
    require('config.php');

    // 2. Maak een data source name string
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

    try {
        // 3. Maak een pdo-object aan voor het maken van de verbinding
        $pdo = new PDO($dsn, $dbUser, $dbPass);
        if ($pdo) {
            // echo "Er is verbinding met de mysql-server en database";
        } else {
            echo "Interne server-error. Probeer het later nog eens";
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    // 4. Maak een select query voor het opvragen van de gegevens.
    $sql = "SELECT Id
            ,Merk

            FROM DureAuto
            ORDER BY Prijs";

    // 5. We bereiden de query voor met de method prepare()
    $statement = $pdo->prepare($sql);

    // 6. We vuren de query af op de mysql-database
    $statement->execute();

    // 7. We stoppen het resultaat van de query in de variabele $result
    $result = $statement->fetchAll(PDO::FETCH_OBJ);

    $rows = "";
    foreach ($result as $info) {
        $rows .= "<tr>
                    <td>$info->Id</td>
                    <td> 
                        <a href='update.php?id={$info->Id}'>
                            <img src='img/b_edit.png' alt='potlood'>
                        </a>
                    </td>
                  </tr>";
    }
?>

<h3>De vijf duurste auto's ter wereld</h3>
<br><br>
<table border="1">
    <thead>
        <th>Id</th>
        <th>Merk</th>
        <th></th>
        <th></th>   
    </thead>
    <tbody>
        <?= $rows; ?>   
    </tbody>
</table>