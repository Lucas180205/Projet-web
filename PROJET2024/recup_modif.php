
<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
require('dbconfig.php'); 

// test si il y a bien des balises html
function isHtml($string) {
    return $string !== strip_tags($string);
}
// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}


// Récupération des données de l'étiquette
$nom = $_POST['nom_etiquette'];
$points = $_POST['coord'];
$description = $_POST['description'];
$catalogId = $_GET['catalogue']; 
$position = $_GET['position'];

//if (isset($var1, $var2) && empty($var1) && empty($var2)) {
if (isset($_POST['html_direct']) && !empty($_POST['html_direct'])) {
    $dhtml = $_POST['html_direct'];

    if (isset($_POST[0], $_POST[1]) && empty($_POST[2]) && empty($_POST[3]) && empty($_POST[0]) && empty($_POST[1])) {
        if (isHtml($dhtml)) {
            $html = '</br><div style="text-transform: uppercase;font-weight: bold;">'.$nom.'</div>' . $dhtml;
            } else{
                $html = '</br><div style="text-transform: uppercase;font-weight: bold;">'.$nom.'</div>' . "pas de code html";
            }
       
        } else {
        
            for ($i = 0; $i <= 11; $i++) {
                if (isset($_POST[$i])) {
                    $tab[$i] = $_POST[$i]; // Ajoute la valeur de $_POST['i'] dans le tableau $tab
                } 
            }
            $nombreLigne = count($tab);
        
            // création d'un tableau exprimé en html, la colonne html étant pas claire dans le sujet, nous avons choisis de renvoyer un tableau comme dans l'exemple
        
        $html = '
            </br><div style="text-transform: uppercase;font-weight: bold;">'.$nom.'</div>
            
        <table id="tableau">
        <thead>
            <tr>
                <th>Paramètre</th>
                <th>Valeur</th>
            </tr>
        </thead>';
        for ($i = 0; $i < $nombreLigne; $i=$i+2) {
        $plus = "<tr>
            <td>" . $tab[$i] . "</td>
            <td>" . $tab[$i+1] . "</td>
            </tr>";
        $html = $html . $plus;
        }
        $html = $html . "</br><div>description : ".$dhtml."</div>";
        }
        
} else {

    if (isset($_POST[0], $_POST[1]) && empty($_POST[2]) && empty($_POST[3]) && empty($_POST[0]) && empty($_POST[1])) {
        $html = '</br><div style="text-transform: uppercase;font-weight: bold;">'.$nom.'</div>
                </br><div>'.$description.'</div>';
        } else {
        
            for ($i = 0; $i <= 11; $i++) {
                if (isset($_POST[$i])) {
                    $tab[$i] = $_POST[$i]; // Ajoute la valeur de $_POST['i'] dans le tableau $tab
                } 
            }
            $nombreLigne = count($tab);
        
            // création d'un tableau exprimé en html, la colonne html étant pas claire dans le sujet, nous avons choisis de renvoyer un tableau comme dans l'exemple
        
        $html = '
            </br><div style="text-transform: uppercase;font-weight: bold;">'.$nom.'</div>
            
        <table id="tableau">
        <thead>
            <tr>
                <th>Paramètre</th>
                <th>Valeur</th>
            </tr>
        </thead>';
        for ($i = 0; $i < $nombreLigne; $i=$i+2) {
        $plus = "<tr>
            <td>" . $tab[$i] . "</td>
            <td>" . $tab[$i+1] . "</td>
            </tr>";
        $html = $html . $plus;
        }
        $html = $html . "</br><div>description : ".$description."</div>";
        }
        

}






//requete pour avoir l'image id
$statement = $connexion->prepare("SELECT image.id FROM catalogimage INNER JOIN image ON catalogimage.imageId = image.id WHERE catalogimage.catalogId = ? AND position=? ;");
        $statement->bind_param("ss", $catalogId , $position); // Lier le paramètre
        $statement->execute(); // Exécuter la requête
    
        $result = $statement->get_result();
        $rows1 = [];
        while ($row1 = $result->fetch_assoc()) {
            $rows1[] = $row1;
        }
        
        $imageId = $rows1[0]['id'];
        $statement->close();



// Préparation de la requête pour le label
$statement = $connexion->prepare("INSERT INTO label (catalogId, imageId, name, description, points, html) VALUES ( ?, ?, ?, ?, ?,?)");

$statement->bind_param("ssssss", $catalogId, $imageId , $nom, $description, $points, $html);

$statement->execute();

$statement->close();
$connexion->close();

//renvoie à la page précédente après l'implémentation dans la base de donnée
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    header("Location: accueil.html");
    exit();
}
?>