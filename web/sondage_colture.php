<?php

    include '../header.html';

    include("../lib/PdoDatabase.php");

    /**
     * On récupère tout les sondages.
     */
    $bdd = PdoDatabase::getInstance()->getDbh();
    $query = $bdd->query("SELECT * FROM sondage as s WHERE s.dateFin < NOW() and s.dateDebut < NOW() ORDER BY dateFin ASC");

    $index = 0;
    ?>

    <?php
    while($sondage = $query->fetch(PDO::FETCH_ASSOC)) {

        $dateDebut = new DateTime($sondage['dateDebut']);
        $dateFin = new DateTime($sondage["dateFin"]);

        if ($index % 3 == 0) {
            echo '<div class="row">';
        }
        ?>
        <div class="col-md-4">
            <form action="#" method="get">
                <input type="hidden" name="id" value="<?php echo $sondage['id'] ?>">
                <div class="sondage">

                    <div class="title"><?php echo $sondage['titre'] ?></div>
                    <div class="container-sondage">
                        <div class="date"><span class="label label-default">Date d'ouverture : <?php echo $dateDebut->format("d/m/Y") ?></span></div>
                        <div class="date"><span class="label label-default">Date de cloture : <?php echo $dateFin->format("d/m/Y") ?></span></div>
                    </div>

                    <button class="btn btn-large btn-repondre">
                        <?php
                            echo "<a href=\"monSondage.php?sondage=".$sondage['id']."\">Consulter les statistiques</a>";
                        ?>

                    </button>

                </div>
            </form>
        </div>
        <?php
        if ($index != 0 && $index % 3 == 0) {
            echo "</div>";
        }
        $index++;
    }
?>