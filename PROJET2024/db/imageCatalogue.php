
<?php 
    session_start();
    $_SESSION['mode'] = 1;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images caatalogue - SOMMETS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sommets.css">
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

    <?php // teste si on est bien connecté sur le site
        if(isset($_SESSION['conn']) && $_SESSION['conn'] == true):  
    ?> 

    <?php 
    require('dbconfig.php'); 

    // Connexion à la base de données avec MySQL
    $connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
    if ($connexion->connect_error) {
        die("Connexion non établie : " . $connexion->connect_error);
    }
    // Récupérer le paramètre catalogue
    $catalogue = $_GET['catalogue']; 

    // Préparation et exécution de la requête pour chercher toutes le simages liées au catalogue choisis
    $statement = $connexion->prepare("SELECT catalogimage.imageId,image.name,catalogimage.position,bank.dir,label.points FROM catalogimage  INNER JOIN image ON catalogimage.imageId = image.id INNER JOIN label ON label.imageId = image.id INNER JOIN bank ON bank.id = image.bankId WHERE catalogimage.catalogId = ? ORDER BY catalogimage.position ASC;");
    $statement->bind_param("s", $catalogue); // Lier le paramètre
    $statement->execute(); // Exécuter la requête
 
     // Récupérer les résultats
    $result = $statement->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
         $rows[] = $row;
     }
     //première image du catalogue, celle qui s'affichera en premier
    $image0 = "../images/".$rows[0]['dir'] ."/". $rows[0]['name']; 
     //nombre d'image dans le catalogue
    $maxImage = count($rows); 
    $statement->close();
     
     // si on a pas d'image on affiche la première image du catalogue
     // si on a pas d'image mais qu'on a une position donnée alors on cherche l'image à telle position dans le catalogue et on l'affighe
    if (isset($_GET['image'])) {
        $image = $_GET['image']; //récupérer le paramètre image
        $position = $_GET['position']; // Récupérer le paramètre position
    }elseif(isset($_GET['position']) && (!isset($_GET['image']))){
        // affiche l'image en fonction d'une position
        $position = $_GET['position'];
        $statement = $connexion->prepare("SELECT image.name,bank.dir FROM catalogimage INNER JOIN image ON catalogimage.imageId = image.id INNER JOIN bank ON bank.id = image.bankId WHERE catalogimage.catalogId = ? AND position=? ;");
        $statement->bind_param("ss", $catalogue , $position); 
        // Exécuter la requête
        $statement->execute(); 
    
        $result = $statement->get_result();
        $rows1 = [];
        while ($row1 = $result->fetch_assoc()) {
            $rows1[] = $row1;
        }
    
        $image1 = "../images/".$rows[$position-1]['dir'] ."/". $rows1[0]['name']; 
        echo '<script>
        const currentUrl = window.location.href; 
        const urlImage = "image=' . $image1 . '";
        if (!currentUrl.includes("image=")) {
            window.location.href = currentUrl + "&" + urlImage;
        }
        </script>';
        $statement->close();
        $connexion->close();  
        }else {  
            // affiche la première image car il n'y a pas de position
        echo '<script>
        const currentUrl = window.location.href; 
        const urlImage = "image=' . $image0 . '";
        const urlPosition = "position=1";
        if (!currentUrl.includes("image=")) {
            window.location.href = currentUrl + "&" +  urlPosition + "&" + urlImage;
        }
    </script>';
    }
    // initialisation des variables pour changer de page dans le catalogue (suivant/precedent)
    //position suivante
    if ($position == count($rows)){
        $suivant = $position;
    }else{
        $suivant = $position+1;
    }
    //position precedente
    if ($position <= 1){
        $precedent = $position;
    }else{
        $precedent = $position-1;
    }



    $points = $rows[0]['points'];
    
    
?>
<!-- création des boutons pour tourner la page du catalogue et éventuellement un bouton edition si l'utilisateur est en mode edition-->
<div class="container mt-5 text-center">
    <h1>Catalogue page :</h1></br></br>
        <canvas id="canvas"></canvas>
            <table id="tableau_etiquette">
                <thead>
                    <tr>
                        <th>
                            </td>
                                <input type="submit" name="image_precedent" id="gauche" value="<">
                                    <?php if (isset($_SESSION['mode']) && $_SESSION['mode'] == 1): ?>
                                <input type="submit" name="bouton_edit" id="edit" value="Edition">
                                    <?php endif; ?>
                                <input type="submit" id="droite" name="image_suivante" value=">">
                            </td>
                        </th>
                    </tr>
                </thead>
            </table>
    <script src="image.js"></script> 
         
        <script>
            //script pour les boutons page suivante,precedent et edition
            // renvoie chacun vers une page + addition de variable pour les récupérer en $_get
            var catalogue = "<?php echo $catalogue; ?>";
            var suivant = "<?php echo $suivant; ?>";
            var precedent = "<?php echo $precedent; ?>";
            var image = "<?php echo $image ?>";
            var position = "<?php echo $position ?>";
        document.getElementById('gauche').addEventListener('click', function() {
            const newUrl1 = window.location.origin + window.location.pathname + "?catalogue="+catalogue+""+"&position="+precedent+"";
            window.location.href = newUrl1; 
        });

        document.getElementById('droite').addEventListener('click', function() {
            const newUrl2 = window.location.origin + window.location.pathname + "?catalogue="+catalogue+""+"&position="+suivant+"";
            window.location.href = newUrl2; 
        });

        document.getElementById('edit').addEventListener('click', function() {
            const newUrl3 = "modif.php?catalogue=" + catalogue + "&position=" + position + "&image=" + image;
            window.location.href = newUrl3; 
        });

        //recupère la chaine de points de la bdd et la mets sous forme de tableau
        var chainePoints = "<?php echo $points ?>";
        var points = chainePoints.split(":");
        var tab = [];
        for (var i = 0; i < points.length; i++) {
            var coord = points[i].split(",");
            tab.push([parseInt(coord[0]), parseInt(coord[1])]);
        }
        //afficher les points dans la console 
        for (var j = 0; j < tab.length; j++) {
        console.log(tab[j][0],tab[j][1]);
        }

    </script>
    <?php else: ?> 
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
<?php endif; ?>
    
</body>