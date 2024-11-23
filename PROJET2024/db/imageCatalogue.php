
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - SOMMETS</title>
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


    <?php 
    session_start();
    require('dbconfig.php'); 

    // Connexion à la base de données avec MySQL
    $connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
    if ($connexion->connect_error) {
        die("Connexion non établie : " . $connexion->connect_error);
    }

    $catalogue = $_GET['catalogue']; // Récupérer le paramètre catalogue

    
     // Préparation et exécution de la requête
     $statement = $connexion->prepare("SELECT catalogimage.imageId,image.name,catalogimage.position,bank.dir FROM catalogimage INNER JOIN image ON catalogimage.imageId = image.id INNER JOIN bank ON bank.id = image.bankId WHERE catalogimage.catalogId = ? ORDER BY catalogimage.position ASC;");
     $statement->bind_param("s", $catalogue); // Lier le paramètre
     $statement->execute(); // Exécuter la requête
 
     // Récupérer les résultats
     $result = $statement->get_result();
     $rows = [];
     while ($row = $result->fetch_assoc()) {
         $rows[] = $row;
     }
     //première image du catalogue
    $image0 = "../images/".$rows[0]['dir'] ."/". $rows[0]['name']; 
     //nombre d'image dans le catalogue
     $maxImage = count($rows); 
     $statement->close();
     

    if (isset($_GET['image'])) {
        $image = $_GET['image']; //récupérer le paramètre image
        $position = $_GET['position']; // Récupérer le paramètre position
    }elseif(isset($_GET['position']) && (!isset($_GET['image']))){
        $position = $_GET['position'];
        $statement = $connexion->prepare("SELECT image.name,bank.dir FROM catalogimage INNER JOIN image ON catalogimage.imageId = image.id INNER JOIN bank ON bank.id = image.bankId WHERE catalogimage.catalogId = ? AND position=? ;");
        $statement->bind_param("ss", $catalogue , $position); // Lier le paramètre
        $statement->execute(); // Exécuter la requête
    
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
        echo '<script>
        const currentUrl = window.location.href; 
        const urlImage = "image=' . $image0 . '";
        const urlPosition = "position=1";
        if (!currentUrl.includes("image=")) {
            window.location.href = currentUrl + "&" +  urlPosition + "&" + urlImage;
        }
    </script>';
    }

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
?>

<div class="container mt-5 text-center">
    <h1>Catalogue page :</h1></br></br>
    <canvas id="canvas"></canvas>
        <table id="tableau_etiquette">
            <thead>
                <tr>
                     
                    <th><input type="submit" name="image" id="gauche" value="<"></td>  <input type="submit" id="droite" name="image" value=">"></td></th>
                </tr>
            </thead>
        </table>
        <script src="image.js"></script>
        
        <script>
            var catalogue = "<?php echo $catalogue; ?>";
            var suivant = "<?php echo $suivant; ?>";
            var precedent = "<?php echo $precedent; ?>";
        document.getElementById('gauche').addEventListener('click', function() {
            const newUrl = window.location.origin + window.location.pathname + "?catalogue="+catalogue+""+"&position="+precedent+"";
            window.location.href = newUrl; 
        });

        document.getElementById('droite').addEventListener('click', function() {
            const newUrl = window.location.origin + window.location.pathname + "?catalogue="+catalogue+""+"&position="+suivant+"";
            window.location.href = newUrl; 
        });
    </script>
</body>