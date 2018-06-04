<?php

    extract($_POST);

    include ("lib/PdoDatabase.php");

    if (isset($_POST['connexion'])) {

        if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

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
    <script src="/js/sortable/Sortable.js"></script>
    <script src="/js/jquery/jquery-3.3.1.min.js"></script>
    <script src="/js/sortReponse.js"></script>
</head>

    <body>
        <div class="container">

            <form action="index.php" method="POST">
                <div class="input-group">
                    <label for="email">Adresse mail : </label>
                    <input type="text" name="email" value="" class="form-control">
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe : </label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="input-group">
                    <a href="inscription">Inscription</a>
                </div>

                <div class="input-group">
                    <input type="submit" name="connexion" value="Connexion" class="btn btn-info">
                </div>


            </form>

        </div>
    </body>

</html>


