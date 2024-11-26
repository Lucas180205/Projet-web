<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <title>Formulaire</title>
    <link rel="stylesheet" href="sommets.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
  <!-- Navbar -->
<!-- bouton connexion et deconnexion -->
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
    <form  method="post" action="recup_insc.php">
    <table id="tableau">
      <thead>
        <tr>
          <th>Formulaire d'inscription</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <label for="nom">Votre Nom </label> : <input type="text" name="nom" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <label for="prenom">Votre Prenom </label> : <input type="text" name="prenom" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <label for="pseudo">Votre pseudo </label> : <input type="text" name="pseudo" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <label for="pwd">Votre mot de passe </label> : <input type="password" name="pwd" /></br>
          </td>
        </tr>
        <tr>
            <td>
              <label>Vous êtes :</label>
              <input type="radio" name="mode" id="1" value="1" required />
              <label for="1">Editeur</label>
              <input type="radio" name="mode" id="2" value="2" required />
              <label for="2">Non-éditeur</label><br>
            </td>
        </tr>
        <tr>
            <td>
              <label for="courriel">Votre adresse courriel </label> : <input type="email" name="courriel" value="exemple@gmail.com" /></br><br>
            </td>
        </tr>
      </tbody>
      <tfoot>
      <tr>
          <td><input type="submit" value="Inscription" /></td>
      </tr>
      <tr> 
          <td></form><a href="formu.php" id="redirection">Connexion</a> </td>
      </tr>
      </tfoot>
    </table>
  </body>

</html>
