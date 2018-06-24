<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 22/05/2018
 * Time: 10:02
 */


include 'headerAdmin.html';
include("../../lib/accesBDD.php");
?>
<div class="row">
    <div class="col-md-6">
        <h1>Les sondages</h1>
        <br>
        <ul>
            <li><a href="newSondage.php">Nouveau sondage</a></li>
            <?php

            /**
             * On récupère tout les sondages.
             */
            $query = $bdd->query("SELECT id, titre, DATE_FORMAT( dateDebut,  '%d/%m/%Y à %H:%i' ) AS dateDebut, DATE_FORMAT( dateFin,  '%d/%m/%Y à %H:%i' ) 
        AS dateFin FROM sondage as s  ORDER BY dateDebut ASC ");

            while($sondage = $query->fetch(PDO::FETCH_OBJ)) {
                echo '<li><a href="statistiquesSondages.php?sondage='.$sondage->id.'">'.$sondage->titre.' du '.$sondage->dateDebut. ' au '. $sondage->dateFin.'</a></li>';


            }
            ?>

        </ul>

    </div>
    <div class="col-md-6">

        <h1>Les utilisateurs</h1>
        <br><br>
        <ul>

            <?php

            /**
             * On récupère tout les sondages.
             */
            $query = $bdd->query("SELECT id,UPPER(nom) as 'nom',prenom FROM utilisateur  ORDER BY  nom ");

            while($utilisateur = $query->fetch(PDO::FETCH_OBJ)) {
                echo '<li><a href="statistiquesUtilisateur.php?user='.$utilisateur->id.'">'.$utilisateur->nom. ' ' .$utilisateur->prenom.'</a></li>';


            }
            ?>

        </ul>

    </div>

</div>
</div>



