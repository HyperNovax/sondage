<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 24/05/2018
 * Time: 13:03
 */

class ManagerReponse
{

    public static function userHaveReponse () {
        $sql = "SELECT COUNT(*) FROM utilisateur_reponse as ur INNER JOIN reponse as r ON ur.idReponse = r.id INNER JOIN question as q ON q.id = r.idQuestion AND q.idSondage = 1";
    }

}