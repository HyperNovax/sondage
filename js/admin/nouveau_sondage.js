$(function () {

    /**
     * Ajout d'une question.
     */
    $("#add_question").on('click', function (event) {
        event.preventDefault();

        // On récupère l'id de la dernière question.
        let idQuestion = $('.form-question').last().attr("rel");
        console.log(idQuestion);
        idQuestion++;

        let div = createQuestion(idQuestion);

        $("#zone-question").append(div);
    });

    /**
     * Ajout d'une réponse.
     */
    $('#zone-question').on('click', '.add-reponse', function (event) {
        event.preventDefault();

        let zoneReponse = $(this).parent().find(".zone-reponse");

        let idQuestion = $(zoneReponse).parent().attr("rel");
        let idReponse = $(zoneReponse).find('.form-reponse').last().attr('rel');
        if (idReponse == undefined) idReponse = 0;
        idReponse++;

        $(zoneReponse).append(createReponse(idQuestion, idReponse));
    });

    /**
     * Suppression d'un sondage.
     */
/*    $('#zone-question').on('click', '.delete-reponse', function (event) {
        event.preventDefault();

        let reponse = $(this).parents(".form-reponse");
        let zoneReponse = $(this).parents(".zone-reponse");

        $(reponse).remove();

        console.log(zoneReponse);
        let idQuestion = $(this).parents(".form-question").attr('rel');

        let child = $(zoneReponse).find(".form-reponse");
        let index  = 1;
        console.log(child);
        child.each(function (element) {
            console.log(element);
            element.attr('rel', index);
        });
    });*/

    /**
     * Création d'une question.
     * @param id
     * @returns {HTMLDivElement}
     */
    function createQuestion (id) {
        let nameInput = "question_"+id;

        let divQuestion = document.createElement('div');
        divQuestion.className = "question";

        let div = document.createElement('div');
        div.className = "form-group form-question";
        div.setAttribute("rel", id);

        let label = document.createElement('label');
        label.innerHTML = "Question "+id;
        label.setAttribute("for", nameInput);

        // Input group
        let divInput = document.createElement('div');
        divInput.className = "input-group";

        let spanAddon = document.createElement('span');
        spanAddon.className = "input-group-addon";

        let iconQuestion = document.createElement('span');
        iconQuestion.className  = "glyphicon glyphicon-question-sign";

        spanAddon.appendChild(iconQuestion);

        let input = document.createElement('input');
        input.name = nameInput;
        input.className = "form-control";

        divInput.appendChild(spanAddon);
        divInput.appendChild(input);

        // Zone contenant les réponses.
        let zoneReponse = document.createElement("div");
        zoneReponse.className = "zone-reponse";

        zoneReponse.append(createReponse(id, 1));
        zoneReponse.append(createReponse(id, 2));

        // Button d'ajout de réponse.
        let buttonReponse = document.createElement('button');
        buttonReponse.className = "btn btn-success add-reponse";

        let icon = document.createElement('span');
        icon.className = "glyphicon glyphicon-plus";

        let title = document.createTextNode(' Ajouter une réponse')

        buttonReponse.appendChild(icon);
        buttonReponse.appendChild(title);

        div.appendChild(label);
        div.appendChild(divInput);
        div.appendChild(zoneReponse);
        divQuestion.appendChild(div);
        divQuestion.appendChild(buttonReponse);

        return divQuestion;
    }

    /**
     * Créer une réponse.
     * @param idQuestion
     * @param idReponse
     * @returns {HTMLDivElement}
     */
    function createReponse (idQuestion, idReponse) {
        let nameInput = "q_"+idQuestion+"_r_"+idReponse;

        let div = document.createElement('div');
        div.className = "form-group form-reponse";
        div.setAttribute('rel', idReponse);

        let label = document.createElement('label');
        label.innerHTML = "Reponse "+idReponse;
        label.setAttribute("for", nameInput);

        let input = document.createElement("input");
        input.name = nameInput;
        input.className = "form-control";

/*        let divInput = document.createElement('div');
        divInput.className = "input-group";

        let divBtn = document.createElement('div');
        divBtn.className = "input-group-btn";

        let button = document.createElement('button');
        button.className = "btn btn-danger delete-reponse";

        let icon = document.createElement('span');
        icon.className = "glyphicon glyphicon-remove";

        button.appendChild(icon);
        divBtn.appendChild(button);
        divInput.appendChild(input);
        divInput.appendChild(divBtn);*/

        div.appendChild(label);
        div.appendChild(input);

        return div;
    }

});