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

<form action="index.php" method="POST">
    <input type="text" name="email" value="">
    <input type="password" name="password">

    <input type="submit" name="connexion" value="Connexion">
    <a href="inscription">Inscription</a>
</form>


