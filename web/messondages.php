<?php

    session_start();

    include '../header.html';
    include("../lib/ManagerReponse.php");

    $idUtilisateur = $_SESSION['idUser'];

    /**
     * On récupère tout les sondages.
     */
    $bdd = PdoDatabase::getInstance()->getDbh();
    $query = $bdd->query("SELECT * FROM sondage as s WHERE s.dateFin > NOW() and s.dateDebut < NOW() ORDER BY dateFin ASC");

    $index = 0;
    ?>

    <?php
        while($sondage = $query->fetch(PDO::FETCH_ASSOC)) {

        $dateDebut = new DateTime($sondage['dateDebut']);
        $dateFin = new DateTime($sondage["dateFin"]);

        $haveReponse = ManagerReponse::userHaveReponse($idUtilisateur, $sondage['id']);

        $index++;
        if ($index == 1 || $index % 3 == 1) {
            echo '<div class="row">';
        }

    ?>
        <div class="col-md-4">
            <form action="/web/repondre.php" method="get">
                <input type="hidden" name="id" value="<?php echo $sondage['id'] ?>">
                <?php
                if (!is_null($sondage["couleur"])) echo '<div class="sondage" style="background-color:'.$sondage["couleur"].'">';
                    else echo '<div class="sondage">';
                ?>
                    <div class="row">
                        <div class="col-xs-8"><div class="title"><?php echo $sondage['titre'] ?></div></div>
                        <div class="col-xs-4 repondre">
                            <?php
                                if ($haveReponse) {
                                    echo '<span class="label label-sondage">Répondu</span>';
                                }
                            ?>
                        </div>
                    </div>

                    <div class="container-sondage">
                        <div class="container-date"><span class="label label-sondage">Date de cloture : <span class="date"><?php echo $dateFin->format("d/m/Y") ?></span></span></div>
                        <div class="container-date"><span class="label label-sondage">Date d'ouverture : <span class="date"><?php echo $dateDebut->format("d/m/Y") ?></span></span></div>
                    </div>

                    <button class="btn btn-info btn-large btn-repondre">Répondre</button>

                </div>
            </form>
        </div>
    <?php
        if ($index != 1 && $index % 3 == 0) {
            echo "</div>";
        }
    }
    ?>