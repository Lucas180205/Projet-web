<?php
session_start();
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}

// Récupération des données du formulaire inscription
$newPosition = $_POST['newsPosition']; 
$catalogue = $_GET['catalogue'];
$pose = $_POST['pose'];



//recupère toute les positions et id des images du catalogue
$statement = $connexion->prepare("SELECT imageId,position FROM catalogimage WHERE catalogId=? ORDER BY position ASC;");
        $statement->bind_param("s", $catalogue); // Lier le paramètre
        $statement->execute(); // Exécuter la requête
    
        $result = $statement->get_result();
        $rows1 = [];
        while ($row1 = $result->fetch_assoc()) {
            $rows1[] = $row1;
        }

        //mets les positions dans un tableau
        $tableauPosition = [];
        for ($i = 0; $i < count($rows1); $i++) {
            array_push($tableauPosition, $rows1[$i]['imageId']);
        }
        
//passage avec réference 
// fonction reposition qui renvoie un tableau avec le nouveau ordre des positions dans le catalogue 
function reposition(array &$tab, $nombre, $newIndex) {
    // Trouver l'index actuel de l'élément
    $Index = array_search($nombre, $tab);
    if ($Index === false) {
        return false; 
        // L'élément n'existe pas dans le tableau
    }
    // Supprimer l'élément de sa position actuelle
    array_splice($tab, $Index, 1);
    // Réinsérer l'élément à la nouvelle position
    array_splice($tab, $newIndex, 0, $nombre);
    return true; // Succès
}
$max = (count($rows1)+1);




//lancement de la fonction pour avoir les nouvelles positions
reposition($tableauPosition, $pose, $newPosition-1);



//application des positions dans la bdd
for ($i = 1; $i < $max ; $i++) {
    $statement = $connexion->prepare("UPDATE catalogimage SET position = ? WHERE catalogId = ? AND imageId = ?;");
    $statement->bind_param("sss", $i ,$catalogue,$tableauPosition[$i-1]); 
    $statement->execute(); 
    $statement->close();
    $t = $tableauPosition[$i-1];
    echo "UPDATE catalogimage SET position = $i WHERE  imageId = $t ;";
    
}





$connexion->close();
header("Location: catalogue.php");

?>
