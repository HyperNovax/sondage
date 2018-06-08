<?php

    include '../header.html';

    include("../lib/accesBDD.php");


    /**
     * On récupère tout les sondages.
     */
    $query = $bdd->query("SELECT * FROM sondage as s WHERE s.dateFin > NOW() and s.dateDebut < NOW() ORDER BY dateFin DESC");
    ?>

    <div class="container-sondage">
    <?php while($sondage = $query->fetch(PDO::FETCH_ASSOC)) { ?>
        <?php
            $dateDebut  = new DateTime($sondage['dateDebut']);
            $dateFin = new DateTime($sondage["dateFin"]);
        ?>
        <div class="row">
            <div class="col-md-offset-2 col-md-7">
                <form action="/web/repondre.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $sondage['id'] ?>">
                    <div class="row sondage">

                        <div class="col-xs-4 title"><h4><?php echo $sondage['titre'] ?></h4></div>
                        <div class="col-xs-2"><span class="label label-default"><?php echo $dateDebut->format("d/m/Y") ?></span></div>
                        <div class="col-xs-2"><span class="label label-default"><?php echo $dateFin->format("d/m/Y") ?></span></div>
                        <div class="col-xs-4 repondre">
                            <button class="btn btn-primary">Répondre</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
    </div>

