<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 25/05/2018
 * Time: 03:06
 */



    include 'headerAdmin.html';
    include("../../lib/accesBDD.php");
?>
<h1>Statistiques sur le sondage</h1>
<br>



    <?php

    /**
     * On récupère toutes les questions et réponses.
     */

    $idQuestion = 0;
    $query = $bdd ->query("SELECT Q.titre, Q.ordre, R.`id`,R.`libelle`, R.idQuestion, count(UR.idReponse) as nb FROM `reponse` R INNER JOIN question Q on R.idQuestion = Q.id 
            INNER JOIN utilisateur_reponse UR on UR.idReponse = R.id 
            WHERE Q.idSondage = ".$_GET["sondage"]."
            GROUP BY Q.titre, Q .ordre,R.id,R.Libelle, R.idQuestion 
            order by Q.ordre");
    while($sondage = $query->fetch(PDO::FETCH_OBJ)) {
        if($idQuestion != $sondage->idQuestion) {
            $idQuestion = $sondage->idQuestion;
            echo "<hr/><h3>$sondage->titre</h3><br/>";

        }

            echo "$sondage->nb personne.s ont répondu $sondage->libelle<br>";

    }

    ?>



