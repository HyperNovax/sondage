<?php

    session_start();
    extract($_POST);

    include ('../lib/ManagerReponse.php');

    if (isset($_POST) && isset($_POST['array_Reponse']) && isset($_POST['idSondage'])) {
        $idSondage = $_POST['idSondage'];
        $arrayReponse = $_POST['array_Reponse'];
        $idUser = $_SESSION['idUser'];

        if (!ManagerReponse::userHaveReponse($idUser, $idSondage)) {
            foreach($arrayReponse as $reponse) {
                $sql = "INSERT INTO utilisateur_reponse (idUtilisateur, idReponse, preference) VALUES(:idUtilisateur, :idReponse, :ordre)";
                $bdd = PdoDatabase::getInstance()->getDbh();
                $query = $bdd->prepare($sql);
                $query->bindParam(':idUtilisateur', $idUser);
                $query->bindParam(':idReponse', $reponse['id']);
                $query->bindParam(':ordre', $reponse['ordre']);
                $query->execute();
            }

            echo json_encode(array('status' => 'Vos réponses ont bien été enregistrées !'));
        } else {
            foreach ($arrayReponse as $reponse) {
                $sql = "UPDATE utilisateur_reponse SET preference = :ordre WHERE idUtilisateur = :idUtilisateur AND idReponse = :idReponse";
                $bdd = PdoDatabase::getInstance()->getDbh();
                $query = $bdd->prepare($sql);
                $query->bindParam(':idUtilisateur', $idUser);
                $query->bindParam(':idReponse', $reponse['id']);
                $query->bindParam(':ordre', $reponse['ordre']);
                $query->execute();
            }

            echo json_encode(array('status' => 'Vos réponses ont bien été modifiées !'));
        }

    }

