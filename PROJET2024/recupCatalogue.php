<?php
session_start();
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

// Récupération des données du formulaire inscription
$name = $_POST['nom'];
$description = $_POST['description'];
$userId = $_SESSION['utilisateur'];


// Préparation de la requête 
$statement = $connexion->prepare("INSERT INTO catalog (userAccoundId, name, description) VALUES (?, ?, ?)");



// Lier les valeurs aux points d'interrogation dans la requête
$statement->bind_param("iss", $userId, $name , $description);

$statement->execute();
 
$newId = $connexion->insert_id;

// Fermer la requête et la connexion
$statement->close();
$connexion->close();
header("Location: modifCatalogue.php?catalogue=" . $newId);

?>