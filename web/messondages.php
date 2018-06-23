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

        if ($index % 3 == 0) {
            echo '<div class="row">';
        }
    ?>
        <div class="col-md-4">
            <form action="/web/repondre.php" method="get">
                <input type="hidden" name="id" value="<?php echo $sondage['id'] ?>">
                <div class="sondage">

                    <div class="row">
                        <div class="col-md-9"><div class="title"><?php echo $sondage['titre'] ?></div></div>
                        <div class="col-md-3">
                            <?php
                            if ($haveReponse) {
                                echo '<span class="label label-default">Répondu</span>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="container-sondage">
                        <div class="date"><span class="label label-default">Date d'ouverture : <?php echo $dateDebut->format("d/m/Y") ?></span></div>
                        <div class="date"><span class="label label-default">Date de cloture : <?php echo $dateFin->format("d/m/Y") ?></span></div>
                    </div>

                    <button class="btn btn-info btn-large btn-repondre">Répondre</button>

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