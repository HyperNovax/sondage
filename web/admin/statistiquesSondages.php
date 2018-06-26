<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 25/05/2018
 * Time: 03:06
 */



    include 'headerAdmin.html';
    include("../../lib/accesBDD.php");


    /**
     * On récupère toutes les questions et réponses.
     */

    $idQuestion = 0;
    $query = $bdd->query("select distinct s.titre, q.titre as 'question',r.libelle, ur.preference,
(select count(ur2.idReponse) from utilisateur_reponse ur2 where ur2.preference = ur.preference and ur2.idReponse = ur.idReponse) as 'nbChoix',
(select count(ur3.idUtilisateur) from utilisateur_reponse ur3
 	JOIN reponse r2 on r2.id = ur3.idReponse
 	JOIN question q2 on q2.id= r2.idQuestion
	where q2.idSondage = ".$_GET["sondage"]." and ur3.idReponse = ur.idReponse) as 'nbParticipant',
 (select count(distinct ur2.preference) from utilisateur_reponse ur2
	where  ur2.idReponse = ur.idReponse) as 'nbPreference'
from sondage s
JOIN question q on q.idSondage = s.id
JOIN reponse r on r.idQuestion = q.id
JOIN utilisateur_reponse ur on r.id = ur.idReponse
JOIN utilisateur u on ur.idUtilisateur = U.id
Where s.id = ".$_GET["sondage"]." order by question, r.libelle,  preference");
    $question = null;
    $reponse = null;
    $votants = 0;
    $bFirstTurn = true;

    while ($sondage = $query->fetch(PDO::FETCH_OBJ)) {
        if($bFirstTurn == true)
        {
            echo "<h1>Statistiques sur le sondage \"$sondage->titre\"</h1><br>";
            echo "<table class=\"table table-striped\">";
            $bFirstTurn = false;
        }
        $votants = round(($sondage->nbChoix / $sondage->nbParticipant) *100,2);
        echo "<tr>";
        if($question != $sondage->question)
        {
            echo "<tr class=\"success\">";
            $question = $sondage->question;
            echo "<td colspan='2'><p class=\"text-center\">$sondage->question</p></td>";
            echo "<td>Pourcentage</td>";
            echo "</tr><tr>";
        }
        /*else
            echo"<tr>";*/
        if($reponse != $sondage->libelle) {
            $reponse = $sondage->libelle;
            echo "<td rowspan='$sondage->nbPreference'>$sondage->libelle</td>";

        }

        ?>

            <td>
                <?php echo $sondage->nbChoix ?> sondé(s) sur <?php echo $sondage->nbParticipant ?> ont mis cette réponse à la place <?php echo $sondage->preference ?>.
            </td>
            <td>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $votants ?>%;" aria-valuenow="<?php echo $votants ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $votants ?>%</div>
                </div>
            </td>
        </tr>
        <?php

    }
    echo "</table>";



   /* $query = $bdd ->query("SELECT Q.titre, Q.ordre, R.`id`,R.`libelle`, R.idQuestion, count(UR.idReponse) as nb FROM `reponse` R INNER JOIN question Q on R.idQuestion = Q.id
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

/*$query = $bdd->query("select s.titre, q.titre as 'question',r.libelle, ur.preference,
(select count(ur2.idReponse) from utilisateur_reponse ur2 where ur2.preference = ur.preference and ur2.idReponse = ur.idReponse) as 'nbChoix',
(select count(ur3.idUtilisateur) from utilisateur_reponse ur3
 	JOIN reponse r2 on r2.id = ur3.idReponse
 	JOIN question q2 on q2.id= r2.idQuestion
	where q2.idSondage = ".$_GET["sondage"]." and ur3.idReponse = ur.idReponse) as 'nbParticipant',
    ((select count(ur4.idReponse) from utilisateur_reponse ur4 where ur4.preference = ur.preference and ur4.idReponse = ur.idReponse)
     / (select count(ur5.idUtilisateur) from utilisateur_reponse ur5
 	JOIN reponse r3 on r3.id = ur5.idReponse
 	JOIN question q3 on q3.id= r3.idQuestion
	where q3.idSondage = ".$_GET["sondage"]." and ur3.idReponse = ur.idReponse)) *100  as 'votant',
u.id
from sondage s
JOIN question q on q.idSondage = s.id
JOIN reponse r on r.idQuestion = q.id
JOIN utilisateur_reponse ur on r.id = ur.idReponse
JOIN utilisateur u on ur.idUtilisateur = U.id
Where s.id = ".$_GET["sondage"]);

   $question = null;
    echo "<table class=\"table table-striped\">";
    while ($sondage = $query->fetch(PDO::FETCH_OBJ)) {
        echo "<tr>";
            $bFirstQuestion = true;
        if($question != $sondage->question)
        {
            $question = $sondage->question;
            echo "<td rowspan='2'>$sondage->question</td>";
        }
        echo "<td>$sondage->nbChoix sur $sondage->nbParticipant ont mis cette réponse à la place $sondage->preference. Soit $sondage->votant % des sondés</td>";
        echo "</tr>";


    }
    echo "</table>";
   */

    ?>



