<?php
session_start();
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

//recupère les données du formulaire
$position = $_POST['position'];
$catalogue = $_POST['catalogue'];

//requete sql on prend son image id
$statement = $connexion->prepare("SELECT imageId FROM catalogimage WHERE position = ? AND catalogId = ?;");
$statement->bind_param("ss", $position, $catalogue);
$statement->execute();
$result = $statement->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    $imageId = $rows[0]['imageId'];
    
    $statement->close();

// destruction des labels attachées à l'image et au catalogue
$statement = $connexion->prepare("DELETE FROM label WHERE imageId= ? AND catalogId = ?;");
$statement->bind_param("ss", $imageId, $catalogue);
$statement->execute();
$statement->close();

// réarrangement des positions dans le catalogue
$statement = $connexion->prepare("UPDATE catalogimage SET position = position - 1 WHERE catalogId = ? AND position > ?;");
$statement->bind_param("ss", $catalogue,$position);
$statement->execute();
$statement->close();

//destruction de l'image
$statement = $connexion->prepare("DELETE FROM catalogimage WHERE imageId= ? AND catalogId = ?;");
$statement->bind_param("ss",$imageId,$catalogue);
$statement->execute();
$statement->close();

$connexion->close();

if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: imageCatalogue.php?catalogue=" . $catalogue);
    exit();
} else {
    header("Location: catalogue.php");
    exit();
}
?>