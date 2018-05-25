<?php

    extract($_POST);

    require ("lib/PdoDatabase.php");

    if (isset($_POST) && isset($_POST["inscription"])) {

        if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"]) && isset($_POST["check_password"]) && !empty($_POST["check_password"])) {
            $email = $_POST['email'];
            $password = $_POST["password"];
            $type = "USER";

            $bdd = PdoDatabase::getInstance()->getDbh();
            $sql = "INSERT INTO utilisateur (email, password, type) VALUES(:email, :password, :type)";
            $query = $bdd->prepare($sql);
            $query->bindParam(":email", $email);
            $query->bindParam(":password", $password);
            $query->bindParam(":type", $type);
            $success = $query->execute();

            if ($success) {
                header("Location: index.php");
                exit();
            }

        }

    }

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>Sondage</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/sondage.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    </head>

    <body>

        <div class="container">
            <form action="inscription.php" method="POST">
                <div class="form-group">
                    <label for="email">Adresse mail :</label>
                    <input type="text" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label form="password">Mot de passe :</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label form="check_password">Mot de passe :</label>
                    <input type="password" name="check_password" class="form-control">
                </div>

                <input type="submit" name="inscription" value="Envoyer">

            </form>
        </div>

    </body>
</html>
