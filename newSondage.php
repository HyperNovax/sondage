<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 22/05/2018
 * Time: 11:42
 */

    include 'headerAdmin.html';
?>
<form method="post" action="insertSondage">
    <input type="text" name="Titre" placeholder="Titre du sondage">
    <input type="datetime-local" name="DateOuverture">
    <input type="datetime-local" name="DateFermeture">
    <br>
    <br>

    <input type="text" name="Question1" placeholder="Libellé de la question 1" >
    <br>
    <input type="text" name="Reponse1_1" placeholder="Première réponse possible">
    <input type="text" name="Reponse2_1" placeholder="Deuxième réponse possible">
    <br>
    <br>

    <input type="text" name="Question2" placeholder="Libellé de la question 2" >
    <br>
    <input type="text" name="Reponse1_2" placeholder="Première réponse possible">
    <input type="text" name="Reponse2_2" placeholder="Deuxième réponse possible">
    <br>

    <button type="submit">Envoyer</button>
    <br>
    <button disabled onclick="">Ajouter une réponse</button>
    

</form>

<script>
    function addReponse()
    {

    }
    function emailFunction(){
        var r = document.createElement('span');
        var y = document.createElement("INPUT");
        y.setAttribute("type", "text");
        y.setAttribute("placeholder", "Email");
        var g = document.createElement("IMG");
        g.setAttribute("src", "delete.png");
        increment();
        y.setAttribute("Name", "textelement_" + i);
        r.appendChild(y);
        g.setAttribute("onclick", "removeElement('myForm','id_" + i + "')");
        r.appendChild(g);
        r.setAttribute("id", "id_" + i);
        document.getElementById("myForm").appendChild(r);
    }

</script>