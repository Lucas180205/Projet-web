
<?php 
    session_start();
    $bank = $_GET['bank']; 
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Banque d'images</title>
        <link rel="stylesheet" href="css/banqueimage.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/sommets.css">

    </head>

    <body>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="accueil.php">SOMMETS</a>
        <a class="navbar-brand" href="bank.php">BANQUE IMAGE</a>
        <a class="navbar-brand" href="catalogue.php">CATALOGUES</a>
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
        <h1>Banque d'images : </h1>
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
    // Récupérer le paramètre catalogue
    
    // Préparation et exécution de la requête pour chercher toutes les images liées au catalogue choisis
    $statement = $connexion->prepare("SELECT image.id,image.name,bank.dir FROM image  INNER JOIN bank ON bank.id = image.bankId WHERE bank.Id = ? ORDER BY image.name ASC;");
    $statement->bind_param("s", $bank); // Lier le paramètre
    $statement->execute(); // Exécuter la requête
 
     // Récupérer les résultats

    $result = $statement->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
         $rows[] = $row;
     }
    
    $rows2 = [];
    $maxImage = count($rows);
    for ($i = 0; $i < $maxImage ; $i++) {
        $rows2[$i]['name'] = str_replace(".jpg", "", $rows[$i]['name']);
        $rows2[$i]['file'] = "../images/" .$rows[$i]['dir'] ."/". $rows[$i]['name'] ;
        $rows2[$i]['position'] = $i;
    }
    $statement->close();
    $connexion->close();
    $json = json_encode($rows2, JSON_PRETTY_PRINT);
    echo "<script>
        const images = $json; 
        const bank = $bank;
      </script>";
    ?>

        <div class="image-liste"id="image-liste"></div>
        
        <script src="js/banqueimage.js"></script>
        <?php endif; ?>
    </body>

</html>