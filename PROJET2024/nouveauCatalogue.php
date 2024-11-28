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
        <h1>Nouveau Catalogue :</h1></br></br>
        <body>
    
    <?php 
    //teste si on est bien connecté
    if(isset($_SESSION['conn']) && $_SESSION['conn'] == true): ?>  

    <!-- Formulaire pour la création d'un nouveau catalogue-->
<form  method="post" action="recupCatalogue.php">

<label for="nom">Nom du nouveau catalogue</label> : <input type="text" name="nom" required/></br><br>
<label for="description">Description du nouveau catalogue</label> : <input type="text" name="description" required/></br>
    <br><input type="submit" value="Envoyer" /> 
<?php else: ?> 
<p class="lead">Veuillez vous connecter pour continuer  :</p>
<?php endif; ?>
    


</body>
</html>