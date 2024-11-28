<?php
session_start();
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

//recupère les données du formulaire 
$catalogue = $_POST['catalogue'];

//destruction de tout les labels attachés au catalogue
$statement = $connexion->prepare("DELETE FROM label WHERE catalogId = ?;");
$statement->bind_param("s", $catalogue);
$statement->execute();
$statement->close();

// destruction de tout le catalogue image
$statement = $connexion->prepare("DELETE FROM catalogimage WHERE catalogId = ?;");
$statement->bind_param("s", $catalogue);
$statement->execute();
$statement->close();

//destruction du catalogue
$statement = $connexion->prepare("DELETE FROM catalog WHERE Id = ?;");
$statement->bind_param("s", $catalogue);
$statement->execute();
$statement->close();


$connexion->close();

header("Location: catalogue.php");

?>