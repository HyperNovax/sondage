<?php

    include 'header.html';
    include("../../lib/accesBDD.php");

?>

<div class="row">
    <div class="col-md-6">
        <div class="dashboard-sondage">
            <h2>Les sondages</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    /**
                     * On récupère tout les sondages.
                     */
                    $sql = "SELECT id, titre, DATE_FORMAT( dateDebut,  '%d/%m/%Y à %H:%i' ) AS dateDebut, DATE_FORMAT( dateFin,  '%d/%m/%Y à %H:%i' ) AS dateFin FROM sondage as s  ORDER BY dateDebut ASC ";
                    $query = $bdd->query($sql);

                    while($sondage = $query->fetch(PDO::FETCH_OBJ)) { ?>
                        <tr>
                            <td><?php echo $sondage->titre ?></td>
                            <td><?php echo $sondage->dateDebut ?></td>
                            <td><?php echo $sondage->dateFin ?></td>
                            <td><a href="statistiquesSondages.php?sondage=<?php echo $sondage->id ?>" class="btn btn-info btn-sondage">Statistiques</a></td>
                        </tr>
                <?php } ?>
                </tbody>

            </table>

            <div class="">
                <a href="newSondage.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Nouveau sondage</a>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <h2>Les utilisateurs</h2>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Adresse email</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php

                /**
                 * On récupère tout les utilisateurs.
                 */
                $query = $bdd->query("SELECT id, UPPER(nom) as 'nom', prenom, email FROM utilisateur ORDER BY email");

                while($utilisateur = $query->fetch(PDO::FETCH_OBJ)) { ?>
                    <tr>
                        <td><?php echo $utilisateur->email ?></td>
                        <td><a href="statistiquesUtilisateur.php?user='<?php echo $utilisateur->id ?>'" class="btn btn-info btn-sondage">Statistiques</a></td>
                    </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>
</div>



