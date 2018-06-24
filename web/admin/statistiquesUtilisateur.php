<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 23/06/2018
 * Time: 02:50
 */


include 'headerAdmin.html';
include("../../lib/accesBDD.php");

$query = $bdd ->query("SELECT UPPER(nom) as 'nom',prenom FROM utilisateur where id =". $_GET["user"]);
$user = $query->fetch(PDO::FETCH_OBJ);

echo "<h1>".$user->nom.' '.$user->prenom."</h1>";
?>

<h3>A répondu à ces sondages</h3>

<?php

$query = $bdd->query("SELECT idUtilisateur, s.titre,
(select count(*) from question q2 where q2.idSondage= s.id) as 'nbQuestion',q.titre as 'question',
(select count(*) from reponse r2 where r2.idQuestion= q.id) as 'nbReponse', r.libelle, ur.preference 
FROM utilisateur_reponse ur
JOIN reponse r on ur.idReponse = r.id
JOIN question q on r.idQuestion =q.id
JOIN sondage s on q.idSondage = s.id
WHERE idUtilisateur = ".$_GET["user"]."
ORDER BY s.id, q.ordre, ur.preference");
$firstSondage = false;
$sondage = null;
$question = null;
while($lesSondages = $query->fetch(PDO::FETCH_OBJ)) {
       if($sondage != $lesSondages->titre)
       {
           if($firstSondage ==true)
           {
               echo "</table><br>";
           }
           else
               $firstSondage = true;
           $sondage = $lesSondages->titre;
           echo "<table class=\"table table-striped\">";
           echo "<tr>";
           echo "<th colspan='3'>".$sondage."</th>";
           echo "</tr>";
           echo "<tr>";
       }

       if($question != $lesSondages->question) {
           $question = $lesSondages->question;

           echo "<td rowspan='".$lesSondages->nbReponse."'>" . $lesSondages->question . "</td>";

       }
       /*if($lesSondages->preference = "1")
           echo "<td class=\"success\">".$lesSondages->libelle."</td>";
       else*/
           echo "<td>".$lesSondages->preference." : ". $lesSondages->libelle."</td>";
           //echo "<td>... personnes ont mis cette réponse en preière position, soit ...% des sondés";
       echo "</tr>";
}
echo "</table>";

?>

</div>



