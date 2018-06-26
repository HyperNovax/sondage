<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 26/06/2018
 * Time: 02:08
 */


include '../header.html';

include("../lib/accesBDD.php");

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
    //echo "<td>$sondage->libelle</td>";

    ?>
        <td>
            <?php echo $sondage->nbChoix ?> sondé(s) sur <?php echo $sondage->nbParticipant ?> ont mis cette réponse à la place <?php echo $sondage->preference ?>.
        </td>
        <td>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?php echo $votants ?>%;" aria-valuenow="<?php echo $votants ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $votants ?>%</div>
            </div>
        </td>
    <?php

//CASE
//    WHEN (SELECT DISTINCT ur2.idUtilisateur FROM utilisateur_reponse ur2
//          where ur2.idReponse = ur.idReponse AND ur2.preference = ur.preference) = 3  THEN 'OK'
//    ELSE
//    NULL END as 'Vote'
}
echo "</table>";