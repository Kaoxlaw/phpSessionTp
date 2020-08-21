<?php
session_start();
if (isset($_SESSION['pseudo']) && isset($_SESSION['id_membre'])) {
  $id_membre = $_SESSION['id_membre'];
  $nom = $_SESSION['nom'];
  $prenom = $_SESSION['prenom'];
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
  </head>

  <body>
    <h1>Your Account</h1>

    <?php
    echo "Welcome " . $_SESSION['pseudo'];
    ?>
    <br><br>

    <br>
    <a href="recherche.php">Faire une Recherche</a>
    <br>

    <br>
    <a href="deconnexion.php">Se Deconnecter</a>
    <br>

    <?php
    if ($_SESSION['pseudo'] == 'admin' && $_SESSION['id_membre'] == 9) {
      echo "<a href=\"inscription.php\">Creer un nouveau compte</a> <br>";
    }
    ?>

  </body>

  </html>
<?php
} else {
  echo "You're not allowed to access to this page!";
  echo "<br/><a href=\"connexion.php\">Go to Login</a>";
};

?>