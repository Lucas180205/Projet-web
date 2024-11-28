<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalogue- SOMMETS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   
    

    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="accueil.php">SOMMETS</a>
        <a class="navbar-brand" href="catalogue.php">CATALOGUE</a>
        <a class="navbar-brand" href=".php">AJOUTER DES IMAGES</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['conn']) && $_SESSION['conn'] == true): ?>    
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                    </li>        
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="formu.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formu_inscription.php">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
    <div class="container mt-5 text-center">
        <h1>Edition du catalogue </h1></br></br>
<body>
    
    <?php 
    //teste si on est bien connecté
    if(isset($_SESSION['conn']) && $_SESSION['conn'] == true): ?>   

    
<?php 
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}
// Récupérer les paramètres 

$catalogue = $_GET['catalogue'];

if (isset($_SESSION['utilisateur'])) {
     $user = $_SESSION['utilisateur'];
 }else{
    header("Location: formu.php");
 }

// Préparation et exécution de la requête (vérification que le modifieur du catalogue est bien le créateur)
$statement = $connexion->prepare("SELECT name from catalog WHERE id = ? AND userAccoundId = ?");
$statement->bind_param("ss", $catalogue, $user); // Lier le paramètre
$statement->execute(); // Exécuter la requête


 // Récupérer les résultats
$result = $statement->get_result();
$statement->close();
$connexion->close();

$rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }


if (count($rows) == 0 ){
echo ("vous ne pouvez pas modifiez ce catalogue");
} else{

}









?>


<?php else:?> 
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
    <?php endif; ?>
    <script src="js/catalogue.js"></script> 
</body>
</html>