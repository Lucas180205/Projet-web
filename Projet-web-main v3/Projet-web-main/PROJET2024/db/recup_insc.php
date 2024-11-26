<?php
session_start();
require('dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

// Récupération des données du formulaire inscription
$role = $_POST['mode'];
$firstname = $_POST['nom'];
$lastname = $_POST['prenom'];
$email = $_POST['courriel'];
$hashedPassword = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
$login = $_POST['pseudo'];



// Préparation de la requête 
$statement = $connexion->prepare("INSERT INTO useraccount (userRoleId, login, firstname, lastname, email, password) VALUES (?, ?, ?, ?, ?, ?)");



// Lier les valeurs aux points d'interrogation dans la requête
$statement->bind_param("ssssss", $role, $login , $firstname, $lastname, $email, $hashedPassword );

$statement->execute();

// Fermer la requête et la connexion
$statement->close();
$connexion->close();
header("Location: formu.php");
?>