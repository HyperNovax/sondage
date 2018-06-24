<?php

    extract($_GET);
    session_start();

    if (!isset($_GET['id'])) {
        header('location: messondages.php');
    }

    require ("../lib/ManagerReponse.php");
    include '../header.html';

    $idSondage = $_GET['id'];
    $idUtilisateur = $_SESSION['idUser'];

    $bdd = PdoDatabase::getInstance()->getDbh();
    $sql = "SELECT * FROM question as q WHERE q.idSondage = :idSondage ORDER BY q.ordre";
    $query = $bdd->prepare($sql);
    $query->execute(array(':idSondage' => $idSondage));
    $result = $query->fetchAll();

    $haveReponse = ManagerReponse::userHaveReponse($idUtilisateur, $idSondage);
?>
    <input type="hidden" id="idSondage" value="<?php echo $idSondage ?>">

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="alert alert-info">
                <strong>Veuillez ordonner vos différents choix en fonction de vos préférences !</strong>
            </div>
            <div class="questionnaire">

                <?php foreach ($result as $question) {?>
                    <div class="row question">
                        <div class="col-md-12"><div class="title"><?php echo $question['titre'] ?></div></div>

                        <?php if ($haveReponse) {
                            $sql = "SELECT * FROM utilisateur_reponse as ur INNER JOIN reponse as r ON r.id = ur.idReponse INNER JOIN question as q ON q.id = r.idQuestion WHERE q.id = :idQuestion AND ur.idUtilisateur = :idUtilisateur ORDER BY preference";
                            $query = $bdd->prepare($sql);
                            $query->bindParam(":idQuestion", $question['id']);
                            $query->bindParam(':idUtilisateur', $idUtilisateur);
                            $query->execute();
                            $result = $query->fetchAll();
                        ?>

                        <div class="col-md-12 sort">
                            <?php foreach ($result as $reponse) { ?>
                                <div class="reponse">
                                    <div class="row" rel="<?php echo $reponse['idReponse'] ?>">
                                        <div class="col-xs-2 ordre"><?php echo $reponse['preference'] ?></div>
                                        <div class="col-xs-10"><?php echo $reponse['libelle'] ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php
                        } else {
                            $sql = "SELECT * FROM reponse as r WHERE r.idQuestion = :idQuestion";
                            $query = $bdd->prepare($sql);
                            $query->execute(array(':idQuestion' => $question['id']));
                            $result = $query->fetchAll();

                            $ordre = 1;

                            ?>
                            <div class="col-md-12 sort">
                                <?php foreach ($result as $reponse) { ?>

                                    <div class="reponse" rel="<?php echo $reponse['id'] ?>">
                                        <div class="col-xs-2 ordre"><?php echo $ordre ?></div>
                                        <div class="col-xs-10">
                                            <?php echo $reponse['libelle'] ?>
                                        </div>
                                    </div>

                                    <?php
                                    $ordre++;
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>


                    </div>
                <?php } ?>

                <div class="row button">
                    <div class="col-xs-6">
                        <button id="submit" class="btn btn-lg btn-repondre">Enregistrer</button>
                    </div>
                    <div class="col-xs-6">
                        <a href="messondages.php" class="btn btn-lg btn-repondre">Retour</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="response" class="hidden"></div>
                </div>
            </div>

        </div>
    </div>




</body>

</html>




