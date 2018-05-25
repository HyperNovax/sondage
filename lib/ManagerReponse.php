<?php

require ('../lib/PdoDatabase.php');

class ManagerReponse
{

    public static function userHaveReponse ($idUtilisateur, $idSondage) {
        $bdd = PdoDatabase::getInstance()->getDbh();

        $sql = "SELECT COUNT(*) as nbReponse FROM utilisateur_reponse as ur INNER JOIN reponse as r ON ur.idReponse = r.id INNER JOIN question as q ON q.id = r.idQuestion AND q.idSondage = :idSondage AND ur.idUtilisateur = :idUtilisateur";

        $query = $bdd->prepare($sql);
        $query->bindParam(':idSondage', $idSondage);
        $query->bindParam(":idUtilisateur", $idUtilisateur);
        $query->execute();

        $count = $query->fetch(PDO::FETCH_ASSOC);

        if ($count["nbReponse"] > 0) return true;
        else return false;
    }

}