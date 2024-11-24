<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Formulaire</title>
    <link rel="stylesheet" href="sommets.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
  </head>
  <body>

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

<form  method="post" action="recup.php">
<table id="tableau">
  <thead>
    <tr>
      <th>
        Formulaire de connexion :
    </th>
  </tr>
</thead>
<tbody>
    <tr>
      <td>
        <label for="pseudo">Votre Pseudo </label> : <input type="text" name="pseudo" /></br>
    </td>
  </tr>
  <tr>
    <td>
      <label for="pwd">Votre mot de passe </label> : <input type="password" name="pwd" /></br>
</td>
</tr>
</tbody>
<tfoot>
<tr>
  <td>
  <input type="submit" value="Connexion" /> 
</td>
</tr>
<tr>
  <td>
  </form><a href="formu_inscription.php" class="bouton">Inscription</a>
</td>
</tr>
</tfoot>
</table>

  
  </body>
</html>
