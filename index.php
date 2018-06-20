<?php

    extract($_POST);

    include ("lib/PdoDatabase.php");

    if (isset($_POST['connexion'])) {

        if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $error = "";

            $bdd = PdoDatabase::getInstance()->getDbh();
            $sql = "SELECT * FROM utilisateur WHERE email = :email AND password = :password";
            $query = $bdd->prepare($sql);
            $query->bindParam(":email", $email);
            $query->bindParam(":password", $password);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result != false && isset($result['id'])) {
                session_start();
                $_SESSION['idUser'] = $result['id'];
                header("Location: /web/messondages.php");
                exit();
            } else {
                $error = "Identifiants incorrect !";
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
    <script src="/js/jquery/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
    <script src="/js/sortable/Sortable.js"></script>
    <script src="/js/sortReponse.js"></script>
</head>

    <body>
        <div class="container">

            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <div class="container-form">

                        <div class="title-login">
                            Sondage <span class="interrogation">?</span>
                        </div>

                        <form action="index.php" method="POST" class="form-login">

                            <div class="form-group">
                                <label for="email">Adresse mail : </label>
                                <input type="text" name="email" value="" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe : </label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <a href="inscription">Inscription</a>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="connexion" value="Connexion" class="btn btn-info btn-lg btn-large btn-connexion">
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

</html>


