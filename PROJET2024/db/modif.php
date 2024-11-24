<?php 
    session_start();
    $catalogue = $_GET['catalogue'];
    $position = $_GET['position'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sommets Edit</title>
        <link rel="stylesheet" href="sommets.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="accueil.php">SOMMETS</a>
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

<?php // teste toujours si on est connecté
    if(isset($_SESSION['conn']) && $_SESSION['conn'] == true): 
?> 
        <canvas id="canvas"></canvas>
        <table id="tableau_etiquette">
            <thead>
                <tr>
                    <th>Etiquette</th>
                    <th>Points</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <!-- Formulaire pour la création de l'étiquette -->
                    <form  method="post" action="recup_modif.php?catalogue=<?php echo $catalogue; ?>&position=<?php echo $position; ?>">
                    <td><input type="text" name="nom_etiquette" placeholder="Nom de l'étiquette" required /></td>
                    <td><label >Position des points</label> : <p id = "positionPoint" name="position_points"></p></td>
                    <td><input type="text" name="description" placeholder="Description" /></td>
                    <td><input type="hidden" id="hiddenPoints" name="coord"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center;"><input id="boutton_envoyer" type="submit" name="Envoyer" value="Valider"></td></form>
                </tr>
            </tfoot>
        </table>
        <script src="sommets.js"></script>
        <?php else:?> 
            
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
        <?php endif; ?>

        
    </body>
</html>