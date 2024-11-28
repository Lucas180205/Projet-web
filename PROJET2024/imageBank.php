
<?php 
    session_start();
    $position = $_GET['position'];
    //page similaire a imagecatalog mais pour afficher la bank cette fois
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images caatalogue - SOMMETS</title>
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

    <?php // teste si on est bien connecté sur le site
        if(isset($_SESSION['conn']) && $_SESSION['conn'] == true):  
    ?> 

    <?php 
    require('db/dbconfig.php'); 

    // Connexion à la base de données avec MySQL
    $connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
    if ($connexion->connect_error) {
        die("Connexion non établie : " . $connexion->connect_error);
    }
    // Récupérer le paramètre catalogue
    $bank = $_GET['bank']; 
    
    // Préparation et exécution de la requête pour chercher toutes les images liées au catalogue choisis
    $statement = $connexion->prepare("SELECT image.id,bank.name as bname,image.name,bank.dir FROM image  INNER JOIN bank ON bank.id = image.bankId WHERE bank.Id = ? ORDER BY image.name ASC;");
    $statement->bind_param("s", $bank); // Lier le paramètre
    $statement->execute(); // Exécuter la requête
 
     // Récupérer les résultats

    $result = $statement->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
         $rows[] = $row;
     }
     //première image du catalogue, celle qui s'affichera en premier
    $image0 = "images/".$rows[0]['dir'] ."/". $rows[0]['name']; 
     //nombre d'image dans la bank
    $maxImage = count($rows);
    $statement->close();
    

    // Préparation et exécution de la requête pour chercher tout les catalogues
    $statement = $connexion->prepare("SELECT name,id FROM catalog;");
    // Exécuter la requête
    $statement->execute(); 
    $result = $statement->get_result();
    // mettre la requête sous un format exploitable (tableau)
    $rows2 = [];
    while ($row2 = $result->fetch_assoc()) {
        $rows2[] = $row2;
    }

    $statement->close();
    $connexion->close();

    
     // si on a pas d'image on affiche la première image du catalogue
     // si on a pas d'image mais qu'on a une position donnée alors on cherche l'image à telle position dans le catalogue et on l'affighe
     if (isset($_GET['image'])) {
        $image = $_GET['image']; //récupérer le paramètre image
         // Récupérer le paramètre position
         
         
    }elseif(isset($_GET['position']) && (!isset($_GET['image']))){
        

        $image1 = "images/".$rows[$position]['dir'] ."/". $rows[$position]['name']; 

        echo '<script>
        const currentUrl = window.location.href; 
        const urlImage = "image=' . $image1 . '";
        if (!currentUrl.includes("image=")) {
            window.location.href = currentUrl + "&" + urlImage;
        }
        </script>';
        }else {  
            // affiche la première image car il n'y a pas de position
        echo '<script>
        const currentUrl = window.location.href; 
        const urlImage = "image=' . $image0 . '";
        const urlPosition = "position=0";
        if (!currentUrl.includes("image=")) {
            window.location.href = currentUrl + "&" +  urlPosition + "&" + urlImage;
        }
    </script>';
    }
    
    if ($position == count($rows)-1){
        $suivant = $position;
    }else{
        $suivant = $position+1;
    }
    //position precedente
    if ($position <= 0){
        $precedent = $position;
    }else{
        $precedent = $position-1;
    }

            

   
?>
<!-- création des boutons pour tourner la page du catalogue et éventuellement un bouton edition si l'utilisateur est en mode edition-->
<div class="container mt-5 text-center">
    <h1>image : banque <?php echo $rows[0]['bname']?></h1></br></br>
        <canvas id="canvas"></canvas>
            <table id="tableau_etiquette">
                <thead>
                    <tr>
                        <th id="tdd">
                            </td>
                                <input type="submit" name="image_precedent" id="gauche" value="<">
                                <input type="submit" id="droite" name="image_suivante" value=">"></br>
                                <?php if (isset($_SESSION['mode']) && $_SESSION['mode'] == 1): ?>
                                    <input id="add" type="button" value="Ajouter à un Catalogue">
                                <?php endif; ?>
                            </td>
                        </th>
                    </tr>
                </thead>
            </table>
    <script src="js/image.js"></script> 
         
        <script>
            //script pour les boutons page suivante,precedent et edition
            // renvoie chacun vers une page + addition de variable pour les récupérer en $_get
            var suivant = "<?php echo $suivant; ?>";
            var precedent = "<?php echo $precedent; ?>";
            var image = "<?php echo $image ?>";
            var position = "<?php echo $position ?>";
            var bank = "<?php echo $bank?>";
        document.getElementById('gauche').addEventListener('click', function() {
            const newUrl1 = window.location.origin + window.location.pathname + "?bank="+bank+""+"&position="+precedent+"";
            window.location.href = newUrl1; 
        });

        document.getElementById('droite').addEventListener('click', function() {
            const newUrl2 = window.location.origin + window.location.pathname + "?bank="+bank+""+"&position="+suivant+"";
            window.location.href = newUrl2; 
        });
        
        //bouton ajouter au catalogue 
        const addButton = document.getElementById('add');
        if (addButton) {
        document.getElementById('add').addEventListener('click', function() {
        var rows2 = <?php echo json_encode($rows2); ?>;
        var rows = <?php echo json_encode($rows); ?>;
        addButton.disabled = true;
        // Boucle pour itérer sur le tableau de données
        for (var i = 0; i < rows2.length; i++) {
            // création d'un bouton pour chaque catalogue pour le moment mais on peut faire autre chose
            // format get 
            const form = document.createElement('form');
            form.method = 'post';       
            form.action = 'recup_Addcatalogue.php'; 
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'id';
            hiddenInput.value = rows[position].id;
            const hiddenInput2 = document.createElement('input');
            hiddenInput2.type = 'hidden';
            hiddenInput2.name = 'catalog';
            hiddenInput2.value = rows2[i].id;
            console.log(rows2[i].id);
            const submitButton = document.createElement('input');
            submitButton.type = 'submit';
            submitButton.value = rows2[i].name;    
            form.appendChild(hiddenInput);
            form.appendChild(hiddenInput2);
            form.appendChild(submitButton);
            document.body.appendChild(form);
        } })};
    
</script>
       
        
   
 <?php else: ?> 
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
<?php endif; ?>
    
</body>