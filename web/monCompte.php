<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 25/06/2018
 * Time: 20:35
 */

    session_start();

    include '../header.html';
    include("../lib/ManagerReponse.php");

    $idUtilisateur = $_SESSION['idUser'];

    /**
     * On récupère les informations de l'utilisateur
     */
    $bdd = PdoDatabase::getInstance()->getDbh();

if (isset($_POST['enregistrer'])) {
    $error ='';
    $reussite ='';

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $error = "Vous n'avez pas indiqué d'email!";
    }
    if(!isset($_POST["password1"]) || empty($_POST['password1']))
        $error = "Vous n'avez pas pas indiqué de mot de passe";
    if($_POST["password1"] != $_POST["password2"])
        $error = "Les mots de passe ne correspondent pas";

    //TO DO : Gérer les doublons d'adresse mail (voir requête inscription et filtrer grace idUtilisateur
    if($error == '')
    {
        $email = $_POST['email'];
        $password = $_POST['password1'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];

        $sql = "UPDATE utilisateur SET email = :email, password = :password, nom = :nom, prenom = :prenom";
        $query = $bdd->prepare($sql);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        $query->bindParam(":prenom", $prenom);
        $query->bindParam(":nom", $nom);
        $success = $query->execute();
        $reussite = 'OK';


    }

}


    $query = $bdd->query("SELECT nom, prenom, email FROM utilisateur  WHERE id =$idUtilisateur");
    $utilisateur = $query->fetch(PDO::FETCH_ASSOC);

    ?>

<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <div class="container-form">



            <form action="monCompte.php" method="POST" class="form-login">
                <div class="form-group">
                    <label for="nom">Nom: </label>
                    <input type="text" name="nom" value="<?php echo  $utilisateur['nom']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom: </label>
                    <input type="text" name="prenom" value="<?php echo  $utilisateur['prenom']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse mail : </label>
                    <input type="text" name="email" value="<?php echo  $utilisateur['email']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password2">Nouveau mot de passe : </label>
                    <input type="password" id = password1 name="password1" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password2">Vérifier votre mot de passe: </label>
                    <input type="password" id = "password2" name="password2" class="form-control" required ><!--onkeydown="verifPassword()" -->
                </div>
                <p id="verifPass"></p>


                <div class="form-group">
                    <input type="submit" id="enregistrer" name="enregistrer"  value="Enregistrer" class="btn btn-info btn-lg btn-large btn-connexion">
                </div>

                <?php
                if (!empty($error)) {
                    echo "<div class='alert alert-danger no-margin alert-dismissible'><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>".$error."</div>";
                }
                if (!empty($reussite)) {
                    echo "<div class='alert alert-success no-margin alert-dismissible'><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>Les modifications ont été enregistrées</div>";
                }
                ?>

            </form>

        </div>
    </div>
</div>
<script>
    function verifPassword()
    {
        var pass1 = document.getElementById("password1").value;
        var pass2 = document.getElementById("password2").value;
        if(pass1 != pass2) {
            console.log("faux");
            /*document.getElementById("enregistrer").setAttribute("disabled", "disabled");
            document.getElementById("verifPass").innerText = "Le mot de passe ne correspond pas à ce que vous avez renseigné";*/
        }
        else
        {
            console.log("vrai");
           // document.getElementById("enregistrer").removeAttribute(disabled);
            //document.getElementById("verifPass").innerText ='';
        }
    }
</script>
