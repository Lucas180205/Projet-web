<?php
session_start();
session_unset(); //supprime les variables session
header("Location: accueil.php");  // renvoie à la page d'accueil
exit();
?>