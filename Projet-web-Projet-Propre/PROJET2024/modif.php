<?php 
    session_start();
    //recupère les données get
    $catalogue = $_GET['catalogue'];
    $position = $_GET['position'];

    require('db/dbconfig.php'); 

    // Connexion à la base de données avec MySQL
    $connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
    if ($connexion->connect_error) {
            die("Connexion non établie : " . $connexion->connect_error);
        }

        //recupère le nom du catalogue ainsi que les positions des images dedans
        $statement = $connexion->prepare("SELECT catalog.name,position FROM catalogimage INNER JOIN catalog ON catalog.id = catalogimage.catalogId WHERE catalogId = ? ;");
        $statement->bind_param("s", $catalogue); // Lier le paramètre
        $statement->execute(); // Exécuter la requête
    
        $result = $statement->get_result();
        $rows1 = [];
        while ($row1 = $result->fetch_assoc()) {
            $rows1[] = $row1;
        }

    $nomCatalogue = $rows1[0]['name']; 
    $nombrePage = count($rows1);
    $statement->close();
    $connexion->close(); 
        
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sommets Edit</title>
        <link rel="stylesheet" href="css/sommets.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="accueil.php">SOMMETS</a>
            <a class="navbar-brand" href="bank.php">BANQUE IMAGE</a>
            <a class="navbar-brand" href="catalogue.php">CATALOGUES</a>
            <a class="navbar-brand" href="<?php echo 'imageCatalogue.php?catalogue=' . $catalogue; ?>"><?php echo $nomCatalogue; ?></a>
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
        <h1>Edition du catalogue <?php echo $nomCatalogue; ?> : page <?php echo $position; ?> / <?php echo $nombrePage; ?></h1></br></br>
<?php // teste toujours si on est connecté
    if(isset($_SESSION['conn']) && $_SESSION['conn'] == true): 
?>
<!-- Bouton pour supprimer le catalogue , l'image et modifier la position de l'image-->
<form action="recup_supcatalogue.php" method="post"> 
    <input type="hidden" id="hiddenId" name="pose" value="<?php echo $position; ?>">
    <input type="hidden" id="hiddenId" name="catalogue" value="<?php echo $catalogue; ?>">
    <input id="bouton_deleteC" type="submit" value="SUPPRIMER LE CATALOGUE"></form></br>

<form action="recup_supimage.php" method="post"> 
<input type="hidden" id="hiddenId" name="position" value="<?php echo $position; ?>">
<input type="hidden" id="hiddenId" name="catalogue" value="<?php echo $catalogue; ?>">
<input id="bouton_deleteI" type="submit" value="SUPPRIMER L'IMAGE"></form>

<form action="<?php echo 'recup_modifPosition.php?catalogue=' . $catalogue; ?>" method="post"></br>
<td><label>Changer la position de l'image :</label>
    <select name="newsPosition" id="newsP">
        <?php
        $max = 10; 
        for ($i = 1; $i <= $nombrePage; $i++) {
            echo "<option value=\"$i\">$i</option>";
        }
        ?>
    </select></td>
    <td><input type="hidden" id="hiddenId" name="pose" value="<?php echo $position; ?>"></td>
<input id="bouton_valider" type="submit" name="Envoyer" value="Valider"></form></br>

        <canvas id="canvas"></canvas>
        <table id="tableau_etiquette">
            <thead>
                <tr>
                    <th>Etiquette</th>
                    <th>Description</th>
                    <th>Tableau <input id="bouton_ligne" type="button" value="Ajouter une ligne"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <!-- Formulaire pour la création de l'étiquette -->
                      
                    <form  method="post" action="recup_modif.php?catalogue=<?php echo $catalogue; ?>&position=<?php echo $position; ?>">
                    <td><input type="text" name="nom_etiquette" placeholder="Nom de l'étiquette" required /></td>
                    <p id = "positionPoint" type="hidden" name="position_points" ></p></td>
                    <td><input type="text" name="description" placeholder="Description" /></td>
                    <td id="td_ligne"><input type="hidden" id="hiddenPoints" name="coord">
                    <input type="text" name="0" placeholder="paramètre" required>
                    <input type="text" name="1" placeholder="Valeur" required>
                <h1></h1>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <input id="boutton_envoyer" type="submit" name="Envoyer" value="Valider"></form>
                        <input id="bouton_tracer" type="button" value="Tracer">
                        <input id="bouton_reset" type="button" value="Reset"></td></tr>
            </tfoot>
        </table> 
        <script>
            
            // listener pour les boutons de l'étiquette, tracage et reset
            const bouton_tracer = document.getElementById('bouton_tracer');
            

            bouton_tracer.addEventListener("click", (event) => {
                if (points.length > 2){
                dessinerForme(points);
                afficherCoordonnees();
                }
            });
            const bouton_reset = document.getElementById('bouton_reset');
            bouton_reset.addEventListener("click", (event) => {
                location.reload();
            });

            const bouton_sup = document.getElementById('bouton_deleteC');
            bouton_sup.addEventListener("click", (event) => {
                location.reload();
            });

            let compteur = 2;
            const bouton_ligne = document.getElementById('bouton_ligne');
            bouton_ligne.addEventListener("click", (event) => {
            
            if (compteur <= 8){
            const newligne = document.getElementById("td_ligne");
            const input1 = document.createElement("input");
            const h = document.createElement("h1");
            input1.type = "text";
            input1.name = "tab" + compteur;
            input1.required = true;

            compteur++;

            const input2 = document.createElement("input");
            input2.type = "text";
            input2.name = "tab" + compteur;
            input2.required = true;

            // Ajouter les champs à la div
            newligne.appendChild(h);
            newligne.appendChild(input1);
            newligne.appendChild(input2);
            compteur++;
            } else {
                bouton_ligne.disabled  = true; 
            }
        });

    </script>
        </script>
    <?php else:?> 
        <p class="lead">Veuillez vous connecter pour continuer  :</p>
    <?php endif; ?>

<script src="js/sommets.js"></script>   
    

</body>
</html>