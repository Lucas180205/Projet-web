<?php
session_start();
require('db/dbconfig.php'); 

// Connexion à la base de données avec MySQL
$connexion = new mysqli($dbConn['host'], $dbConn['user'], $dbConn['pass'], $dbConn['name']);
if ($connexion->connect_error) {
    die("Connexion non établie : " . $connexion->connect_error);
}
    //recuperation des éléments du formulaire
    $id = $_POST['id'];
    $idcatalog = $_POST['catalog'];

    // préparation de la requete pour vérifier si l'image est déja dans le catalogue ou non
    $statement = $connexion->prepare("SELECT id FROM catalogimage WHERE imageId = ? AND catalogId = ?;");
    $statement->bind_param("ss", $id,$idcatalog); // Lier le paramètre
    $statement->execute(); // Exécuter la requête
 
     // Récupérer les résultats

    $result = $statement->get_result();
    $rows3 = [];
    while ($row3 = $result->fetch_assoc()) {
         $rows3[] = $row3;
     }
     $statement->close();
     ?>
    <?php if(empty($rows3)): ?> 

<?php
    //requete pour avoir la dernière page dans le catalogimage
    $statement = $connexion->prepare("SELECT MAX(position) AS max_position  FROM catalogimage WHERE catalogId = ?;");
    $statement->bind_param("s", $idcatalog); // Lier le paramètre
    $statement->execute(); // Exécuter la requête
 
    $result = $statement->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
         $rows[] = $row;
     }

     $statement->close();
    
    if(isset($rows[0]['max_position'])){
    $position = $rows[0]['max_position'];
    $position = $position+1;
    }else{
        $position = 1;
    }
    // Préparation de la requête pour insérer l'image en dernière position
    $statement = $connexion->prepare("INSERT INTO catalogimage (catalogId, imageId, position) VALUES (?, ?, ?)");



    // Lier les valeurs aux points d'interrogation dans la requête
    $statement->bind_param("sss", $idcatalog, $id,$position);

    $statement->execute();

    // Fermer la requête et la connexion
    //message alert envoyé en js pour dire que l'image est ajoutée
    $message = "Image Ajoutée";
    $statement->close();
    $connexion->close();

if (isset($_SERVER['HTTP_REFERER'])) {
    $newurl = $_SERVER['HTTP_REFERER'];
} else {
    $newurl ="accueil.html";
}

echo "<script>
    alert('$message');
    window.location.href = '$newurl';
</script>";
exit();
?>

<?php else: ?> 
    <?php 
    $connexion->close();
 
    $message = ("Image déjà dans le catalogue");
    if (isset($_SERVER['HTTP_REFERER'])) {
        $newurl = $_SERVER['HTTP_REFERER'];
    } else {
        $newurl ="accueil.html";
    }

    echo "<script>
    alert('$message');
    window.location.href = '$newurl';
    </script>";
    exit();
    
    ?>
    <?php endif; ?>
   



