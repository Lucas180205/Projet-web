<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Formulaire</title>
  </head>
  <body>

Formulaire d'inscription</br><br>


<form  method="post" action="recup_insc.php">

<label for="nom">Votre Nom </label> : <input type="text" name="nom" required/></br>
<label for="prenom">Votre Prenom </label> : <input type="text" name="prenom" required/></br>
<label for="pseudo">Votre pseudo </label> : <input type="text" name="pseudo" required/></br>
<label for="pwd">Votre mot de passe </label> : <input type="password" name="pwd" required/></br>
<label>Vous êtes :</label>
    <input type="radio" name="mode" id="1" value="1" required />
    <label for="1">Editeur</label>
    
    <input type="radio" name="mode" id="2" value="2" required />
    <label for="2">Non-editeur</label><br>
    <label for="courriel">Votre adresse courriel </label> : <input type="email" name="courriel" value="exemple@gmail.com" required/></br><br>
    <input type="submit" value="Envoyer" /> 
    </form><a href="formu.php" class="bouton">je souhaite me connecter</a> 


  
  </body>
</html>
