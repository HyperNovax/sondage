<?php

    include '../header.html';

    include("../lib/accesBDD.php");


    /**
     * On récupère tout les sondages.
     */
    $query = $bdd->query("SELECT * FROM sondage as s WHERE s.dateFin > NOW() and s.dateDebut < NOW() ORDER BY dateFin DESC");

    while($sondage = $query->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="row">
            <div class="col-md-12">
                <form action="/web/repondre.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $sondage['id'] ?>">
                    <div>
                        <?php echo $sondage['titre'] ?>
                    </div>
                    <div>
                        <button class="btn btn-primary">Répondre</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

