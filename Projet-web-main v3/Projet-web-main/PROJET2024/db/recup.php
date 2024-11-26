<?php
session_start();
require('dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

// Récupération des données du formulaire inscription

$password = $_POST['pwd'];
$login = $_POST['pseudo'];


// Préparation de la requête 
$statement = $connexion->prepare("SELECT id,userRoleId,password FROM useraccount WHERE login = ?");

// Lier les valeurs aux points d'interrogation dans la requête
$statement->bind_param("s", $login);

// Exécuter la requête
$statement->execute();

// Obtenir le résultat de la requête
$result = $statement->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // Vérifie le mot de passe avec le hachage 
    if (password_verify($password, $row['password'])) {
        $_SESSION['conn'] = true;
        $_SESSION['utilisateur'] = $row['id'];
        $_SESSION['role'] = $row['userRoleId'];
        header("Location: accueil.php");
         exit; // Connexion réussie
    } else {
        echo "mot de passe incorrect";
        $_SESSION['conn'] = false; 
        // Mot de passe incorrect
    }
} else {
    echo "cet utilisateur n'existe pas";
    $_SESSION['conn'] = false; // Aucune ligne trouvée (login incorrect)
}

// Fermer la requête et la connexion
$statement->close();
$connexion->close();
?>
