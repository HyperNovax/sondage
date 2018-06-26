<?php

    extract($_POST);

    require ("lib/PdoDatabase.php");

    if (isset($_POST) && isset($_POST["inscription"])) {

        if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"]) && isset($_POST["check_password"]) && !empty($_POST["check_password"])) {
            $email = $_POST['email'];
            $password = $_POST["password"];
            $check_password = $_POST["check_password"];
            $type = "USER";
            $error = "";

            $bdd = PdoDatabase::getInstance()->getDbh();

            // Vérification de l'adresse email.
            $sql = "SELECT * FROM utilisateur WHERE email = :email";
            $query = $bdd->prepare($sql);
            $query->bindParam(":email", $email);
            $query->execute();

            if (!$query->fetch(PDO::FETCH_ASSOC)) {

                if ($password == $check_password) {
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
                } else {
                    $error = "Les mots de passe ne sont pas identiques.";
                }

            } else {
                $error = "Cette adresse email est déjà utilisée";
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
        <link rel="stylesheet" href="/css/global.css" />
        <link rel="stylesheet" href="/css/login.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    </head>

    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <div class="container-form">

                        <div class="title-login">
                            Sondage <span class="interrogation">?</span>
                        </div>

                        <form action="inscription.php" method="POST" class="form-login">
                            <div class="form-group">
                                <label for="email">Adresse mail :</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label form="password">Mot de passe :</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label form="check_password">Mot de passe :</label>
                                <input type="password" name="check_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="inscription" value="S'inscrire" class="btn btn-info btn-large btn-lg btn-inscription">
                            </div>

                            <?php
                                if (!empty($error)) {
                                    echo "<div class='alert alert-danger no-margin alert-dismissible'><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>".$error."</div>";
                                }
                            ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </body>

    <script src="/js/jquery/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
</html>
