<?php
session_start();
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

//recuperation des données du formulaire
$id = $_POST['idlabel'];

//requete sql
$statement = $connexion->prepare("DELETE FROM label WHERE id = ?;");
$statement->bind_param("s", $id);
$statement->execute();
$statement->close();
$connexion->close();

if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    header("Location: accueil.html");
    exit();
}
?>