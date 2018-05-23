$(function () {

    let listSort = document.getElementsByClassName("sort");

    console.log(listSort);

    [].forEach.call(listSort, function (list) {
        Sortable.create(list, {
            animation: 150,
            draggable: '.reponse'
        });
    });

});