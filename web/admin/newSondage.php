<?php
    include 'headerAdmin.php';
?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="row">
            <form method="post" action="insertSondage.php">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titre">Titre du sondage</label>
                                <input type="text" name="titre" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="couleur">Couleur</label>
                            <div id="color" class="input-group colorpicker-component" title="Using input value">
                                <input type="text" class="form-control" name="couleur" value="#22a6b3"/>
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateDebut">Date de début</label>
                                <div class='input-group date' id='dateDebut'>
                                    <input type='text' class="form-control" name="dateDebut" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateDebut">Date de début</label>
                                <div class='input-group date' id='dateFin'>
                                    <input type='text' class="form-control" name="dateFin" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="zone-question" class="col-md-12">
                    <div class="question">
                        <div class="form-group form-question" rel="1">
                            <label for="question_1">Question 1</label>

                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span>
                                <input class="form-control" name="question_1" />
                            </div>

                            <div class="zone-reponse">
                                <div class="form-group form-reponse" rel="1">
                                    <label for="q_1_r_1">Réponse 1</label>
                                    <input class="form-control" name="q_1_r_1" />
                                    <!--<div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger delete-reponse" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                                        </div>
                                    </div>-->
                                </div>

                                <div class="form-group form-reponse" rel="2">
                                    <label for="q_1_r_2">Réponse 2</label>
                                    <input class="form-control" name="q_1_r_2" />
                                    <!--<div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger delete-reponse" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success add-reponse"><span class="glyphicon glyphicon-plus"></span> Ajouter une réponse</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="container-button">
                        <button id="add_question" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Ajouter une question</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="container-button">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="/web/admin/admin.php" class="btn btn-info btn-sondage">Annuler</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-info btn-sondage">Envoyer</button>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        $('#dateDebut').datetimepicker( {
            locale: 'fr'
        });
        $('#dateFin').datetimepicker({
            locale: 'fr'
        });

        $('#color').colorpicker({
            format: true
        });
    });

</script>