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
    <link rel="stylesheet" href="sommets.css">
</head>
<body>
   
    

    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="accueil.php">SOMMETS</a>
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
        <h1>Liste des catalogues :</h1></br></br>
<body>
    
    <?php 
    //teste si on est bien connecté
    if(isset($_SESSION['conn']) && $_SESSION['conn'] == true): ?>                     
    <?php 
    session_start();
    require('dbconfig.php'); 

    // Connexion à la base de données avec MySQL
    $connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
    if ($connexion->connect_error) {
        die("Connexion non établie : " . $connexion->connect_error);
    }
    // si l'utilisateur est en mode édition ou exécution
    if (isset($_SESSION['mode'])) {
       if(isset($_POST['mode'])){
        $_SESSION['mode'] = $_POST['mode'];
        }
    }else{
        $_SESSION['mode'] = 0;
    }
    
    // Préparation et exécution de la requête pour chercher tout les catalogues
    $statement = $connexion->prepare("SELECT name,id FROM catalog;");
    // Exécuter la requête
    $statement->execute(); 
    $result = $statement->get_result();
    // mettre la requête sous un format exploitable (tableau)
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $statement->close();
    $connexion->close();
    ?>

    <script>
        var rows = <?php echo json_encode($rows); ?>;
        // Boucle pour itérer sur le tableau de données
        for (var i = 0; i < rows.length; i++) {
            // création d'un bouton pour chaque catalogue pour le moment mais on peut faire autre chose
            // format get 
            const form = document.createElement('form');
            form.action = 'modif.php'; 
            form.method = 'get';       
            form.action = 'imageCatalogue.php'; 
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'catalogue';
            hiddenInput.value = rows[i].id; 
            const submitButton = document.createElement('input');
            submitButton.type = 'submit';
            submitButton.value = rows[i].name;    
            form.appendChild(hiddenInput);
            form.appendChild(submitButton);
            document.body.appendChild(form);
        }
    </script>
    <?php else: ?> 
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
<?php endif; ?>
    


</body>