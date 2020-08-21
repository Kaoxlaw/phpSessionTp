<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
</head>

<body>
  <h1>Inscription</h1>

  <form action="<?= $_SERVER['PHP_SELF'] ?> " method="post">
    Nom:
    <input type="text" name="nom" placeholder="Votre nom">
    <br>
    <br>
    Prènom:
    <input type="text" name="prenom" placeholder="Votre prenom">
    <br>
    <br>
    Pseudo:
    <input type="text" name="pseudo" placeholder="Votre prenom">
    <br>
    <br>
    Mot de passe:
    <input type="text" name="password" placeholder="Votre mot de passe">
    <br>
    <br>
    Adresse Mail:
    <input type="text" name="email" placeholder="Votre mail">
    <br>
    <br>

    <input type="submit" value="Valider">
    <br>
    <br>

  </form>

  <?php
  //Etape1 Inclusion des paramètres de connexion
  include_once("myparams.php");

  //Etape2 Connexion au serveur
  $createFact = new mysqli(HOST, USER, PASS, "northWind", PORT);

  if (!$createFact) {
    echo "Connexion impossible à la base";
    exit();
  } else {
    // On vérifie que tous les champs du formulaire sont renseignés, si un champs vide on met la variable $formValid à true
    $formValid = false;
    foreach ($_POST as $cle => $valeur) {
      if (empty($_POST[$cle])) {
        $formValid = true;
      } else {
        $nom = $createFact->escape_string($_POST['nom']);
        $prenom = $createFact->escape_string($_POST['prenom']);
        $pseudo = $createFact->escape_string($_POST['pseudo']);
        $password = $createFact->escape_string($_POST['password']);
        $email = $createFact->escape_string($_POST['email']);

        //hashage de mdp
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        $request = "INSERT INTO membres(nom, prenom, pseudo, password, email) VALUES ('$nom','$prenom',
          '$pseudo', '$pass_hash', '$email')";
        $result = mysqli_query($createFact, $request);
      }

      // if ($resulta) {
      //   echo "Bravo Account Created";
      //   echo "<br>";
      // } else {
      //   echo "Sorry not working bro";
      //   echo "<br>";
      // }

      $objet = "Comfirmation de votre création de compte sur l'application";
      $texte = "Nous avons bien creer votre compte \n";
      $texte .= "Votre nom est: " . $_POST['nom'] . "\n";
      $texte .= "Votre prénom est: " . $_POST['prenom'] . "\n";
      $texte .= "Votre pseudo est: " . $_POST['pseudo'] . "\n";
      $texte .= "Votre mots de passe est: " . $_POST['password'] . "\n";
      $texte .= "Votre adresse mail est: " . $_POST['email'] . "\n";
      $texte .= "Cordialement \n";
      $texte .= "L'équipe GEEK TEAM";

      //Entête
      $entete = "MIME-Version: 1.0 \n";
      $entete = "Content-Type: Text/html; charset = utf-8 \n";
      $entete = "From: Geek Team  <mickaeldelafpa@gmail.com>";
      $entete .= "cc: " . $_POST['email'] . "\n";

      if (mail($_POST['email'], $objet, $texte, $entete)) {
        echo "Votre message à bien été envoyé";
      } else {
        echo "Désolé Mail not Send!";


        $createFact->close();
        header('location: account.php');
      }
    }
  }
  echo "<br>";
  echo "Veuillez remplir tous les champs du formulaire !";
  ?>

  <br>
  <br>
  <a href="account.php">Go Account</a>
</body>

</html>