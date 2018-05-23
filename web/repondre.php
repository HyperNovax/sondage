<?php

    extract($_GET);

    if (empty($_GET['id'])) {
        header('location: messondages.php');
    }

    include '../header.html';

    include("../lib/accesBDD.php");

    $idSondage = $_GET['id'];

    $sql = "SELECT * FROM question as q WHERE q.idSondage = :idSondage ORDER BY q.ordre";
    $query = $bdd->prepare($sql);
    $query->execute(array(':idSondage' => $idSondage));
    $result = $query->fetchAll();

    foreach ($result as $question) {?>
        <div class="row">
            <div class="col-md-12">
                <?php echo $question['titre'] ?>
            </div>
            <?php
                $sql = "SELECT * FROM reponse as r WHERE r.idQuestion = :idQuestion";
                $query = $bdd->prepare($sql);
                $query->execute(array(':idQuestion' => $question['id']));
                $result = $query->fetchAll();
            ?>
            <div class="col-md-12 sort">
                <?php foreach ($result as $reponse) { ?>

                    <div class="reponse">
                        <div class="col-md-12">
                            <?php echo $reponse['libelle'] ?>
                        </div>
                    </div>

                <?php } ?>
            </div>

        </div>
    <?php } ?>

    <button>Enregistrer</button>

<script src="/js/sortReponse.js"></script>

</body>

</html>




