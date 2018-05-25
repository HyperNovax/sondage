$(function () {

    let listSort = document.getElementsByClassName("sort");

    [].forEach.call(listSort, function (list) {
        Sortable.create(list, {
            animation: 150,
            draggable: '.reponse',
            onEnd: function (evt) {
                let reponses = evt.to.querySelectorAll(".reponse");

                [].forEach.call(reponses, function (reponse) {
                    let index = Array.prototype.indexOf.call(reponses, reponse);
                    $(reponse).find(".ordre").text((index+1));
                });
            }
        });
    });


    $('#submit').on('click', function (e) {
        let arrayReponse = [];

        /**
         * On récupère toutes les réponses du sondage.
         */
        $('.sort').find('.reponse').each(function (index) {
            let reponse = {
                id: $(this).attr("rel"),
                ordre: $(this).find(".ordre").text()
            };
            arrayReponse.push(reponse);
        });

        console.log(arrayReponse);

        /**
         * On récupère l'id du sondage.
         * @type {*|jQuery}
         */
        let idSondage = $('#idSondage').val();


        $.ajax({
            url: "/web/enregistrerreponse/",
            data: {array_Reponse:arrayReponse, idSondage:idSondage},
            method: "POST",
            dataType: "json"
        }).done(function (res) {
            $('#response').removeClass("hidden");
            $('#response').children().remove();
            $('#response').append("<div class='alert alert-success alert-dismissable'><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>"+res.status+"</div>");
        }).fail(function (res) {
            console.log('fail');
            console.log(res);
            $('.response').append(res);
            $('.response').append(res.responseText);
        });
    });

});