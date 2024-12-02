<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - SOMMETS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sommets.css">
</head>
<body>
   
<!-- Navbar -->
<!-- bouton connexion et deconnexion -->
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

<!-- Main Content -->
<div class="container mt-5 text-center">
    <h1>Bienvenue sur SOMMETS</h1>
    
    <?php if(isset($_SESSION['role'])): ?>
        <?php if($_SESSION['role'] == 1): ?>
            <!-- Si l'utilisateur est est un editeur -->
            <p class="lead">Veuillez choisir un mode pour continuer :</p>
            <div class="d-flex justify-content-center mt-4">
                <form method="post" action="catalogue.php">
                    <button id="bouttonAccueil" type="submit" name="mode" value=0>Mode Exécution</button>
                    <button id="bouttonAccueil" type="submit"  name="mode" value=1>Mode Edition</button>
                </form>
            </div>
        <?php elseif($_SESSION['role'] == 2): ?>
            <!-- Si l'utilisateur est non-editeur -->
            <p class="lead">Veuillez choisir un mode pour continuer :</p>
            <div class="d-flex justify-content-center mt-4">
                <form method="post" action="catalogue.php">
                    <button type="submit" id="bouttonAccueil" name="mode" value=0>Mode Exécution</button>
                </form>
            </div>  
        <?php endif; ?>
    <?php else: ?> 
        <!-- Si l'utilisateur n'est pas encore connecté -->
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
    <?php endif; ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
