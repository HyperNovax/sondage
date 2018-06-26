<?php

    include("../../lib/PdoDatabase.php");

    extract($_POST);

    $bdd = PdoDatabase::getInstance()->getDbh();
    $sql = "INSERT INTO sondage(titre, couleur, dateDebut, dateFin, description, token_url) values(:titre, :couleur, :dateDebut, :dateFin, :description, :token)";
    $query =$bdd->prepare($sql);

    try{
        $myDateTime = DateTime::createFromFormat('d/m/Y H:i', $_POST["dateDebut"]);
        $dateDebut = $myDateTime->format('Y-m-d H:i');

        $myDateTime = DateTime::createFromFormat('d/m/Y H:i', $_POST["dateFin"]);
        $dateFin = $myDateTime->format('Y-m-d H:i');

        $query->bindParam(":titre", $_POST['titre']);
        $query->bindParam(":couleur", $_POST['couleur']);
        $query->bindParam(":dateDebut", $dateDebut);
        $query->bindParam(":dateFin", $dateFin);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":token", $_POST["token"]);
        $query->execute();
    }
    catch(PDOException $e) {
        die('Erreur : ' .$e->getMessage());
    }

    $idSondage = $bdd->lastInsertId();
    $idQuestion;
    foreach ($_POST as $key => $value) {
        if (preg_match("/^question_([0-9])/", $key, $ordre)) {

            $sql = "INSERT INTO question(titre, ordre, idSondage) VALUES(:titre, :ordre, :idSondage)";
            $query = $bdd->prepare($sql);
            try{
                $query->bindParam(":titre", $value);
                $query->bindParam(":ordre", $ordre[1]);
                $query->bindParam(":idSondage", $idSondage);
                $query->execute();
                $idQuestion = $bdd->lastInsertId();
            }
            catch(PDOException $e) {
                die('Erreur : ' .$e->getMessage());
            }

        } else if (preg_match("/q_._r_(.)/", $key, $matches)) {

            $sql = "INSERT INTO reponse(libelle, idQuestion) VALUES(:libelle, :idQuestion)";
            $query= $bdd->prepare($sql);
            try{
                $query->bindParam(":libelle", $value);
                $query->bindParam(":idQuestion", $idQuestion);
                $query->execute();
            }
            catch(PDOException $e) {
                die('Erreur : ' .$e->getMessage());
            }
        }
    }

    header("location: /web/admin/admin.php");

?>
