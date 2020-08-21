<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
</head>

<body>
  <h1>Connexion</h1>

  <form action="<?= $_SERVER['PHP_SELF'] ?> " method="post">
    <input type="text" name="pseudo" placeholder="Votre pseudo">
    <input type="text" name="password" placeholder="Votre mot de passe">
    <input type="submit" value="Connexion">
  </form>

  <?php

  //Etape1 Inclusion des paramètres de connexion
  include_once("myparams.php");

  //Etape2 Connexion au serveur
  $createFact = new mysqli(HOST, USER, PASS, "northWind", PORT);

  if (!$createFact) {
    echo "Connexion impossible";
    exit(); //On arrete tout, on sort du script
  }

  if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {

    // session_start();
    $pseudo = $createFact->escape_string($_POST['pseudo']);
    $password = $createFact->escape_string($_POST['password']);

    $request = "SELECT password, id_membre FROM membres WHERE pseudo = '$pseudo'";

    $result = mysqli_query($createFact, $request);

    $coord = $result->fetch_row();

    if ($coord && password_verify($_POST['password'], $coord[0])) {
      session_start();

      $_SESSION['id_membre'] = $coord[1];
      $_SESSION['pseudo'] = $_POST['pseudo'];

      //page when login ok
      header('location: account.php');
    }
    $createFact->close();
  } else {
    echo "<br>";
    echo "Please LogIn!";
  }
  ?>
</body>

</html>