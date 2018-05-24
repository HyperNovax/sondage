<?php

    extract($_POST);

    include ('../lib/accesBDD.php');

    $arrayReponse = $_POST['array_Reponse'];

    var_dump($arrayReponse);

    $idUser = 1;

    foreach($arrayReponse as $reponse) {
        $sql = "INSERT INTO utilisateur_reponse (idUtilisateur, idReponse, ordre) VALUES(:idUtilisateur, :idReponse, :ordre)";
        $query = $bdd->prepare($sql);
        $query->bindParam(':idUtilisateur', $idUser);
        $query->bindParam(':idReponse', $reponse['id']);
        $query->bindParam(':ordre', $reponse['ordre']);
        $query->execute();
    }