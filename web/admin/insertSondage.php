<?php
/**
 * Created by PhpStorm.
 * User: Clem
 * Date: 25/05/2018
 * Time: 04:01
 */
include("lib/accesBDD.php");

$erreur ='';

if(!empty($_POST))
{
    switch ($_POST)
    {
        case !isset($_POST['Titre']):
            $erreur += 'Pas de titre\n';
        break;
        case !isset($_POST["DateOuverture"]):
            $erreur += 'Pas de date d\'ouverture\n';
        break;
        case !isset($_POST["DateFermeture"]):
            $erreur += 'Pas de date de fermeture\n';
            break;
        case !isset($_POST["Question1"]):
            $erreur += 'La question 1 n\'existe pas\n';
            break;
        case !isset($_POST["Reponse1_1"]):
            $erreur += 'Renseignez la réponse 1 de la première question\n';
            break;
        case !isset($_POST['Reponse2_1']):
            $erreur += 'Renseignez la réponse 2 de la première question\n';
            break;



    }
}
if($erreur == '')
{
    $reqAjout =$bdd->prepare( "insert into sondage( titre, dateDebut,dateFin, description, token_url) 
      values( :titre, :dateDebut, :dateFin, 'toast', '')");

    try{
        $reqAjout->execute(array(

            'titre'=>$_POST["Titre"],
            'dateDebut'=>$_POST["DateOuverture"],
            'dateFin'=>$_POST["DateFermeture"]

        ));
        echo'<br/> le fichier a bien été enregistré !';
    }
    catch(PDOException $e)
    {
        die('Erreur : ' .$e->getMessage());
    }
    $idSondage = $bdd->lastInsertId();
    $iQuestion = 1;
    $iReponse = 1;
    $existe = true;
    echo "<br>";
    echo $_POST["Reponse".$iReponse."_".$iQuestion]."<br>";

    while($existe == true)
    {
        //S'il existe une qestion numéro i et qu'elle a au moins 2 réponses possible
        if(isset($_POST["Question".$iQuestion]) && isset($_POST["Reponse1_".$iQuestion]) && isset($_POST["Reponse2_".$iQuestion]))
        {
            $reqQuestion = $bdd->prepare("insert into question(titre, preference, idSondage) 
                  values( :titre, :preference, :idSondage)");
            try{
                $reqQuestion->execute(array(

                    'titre'=>$_POST["Question".$iQuestion],
                    'preference'=>$iQuestion,
                    'idSondage'=>1,

                ));
                echo'<br/> Question '.$iQuestion.' enregistrée !';
            }
            catch(PDOException $e)
            {
                die('Erreur : ' .$e->getMessage());
            }
            $idQuestion = $bdd->lastInsertId();
            echo "<h1>$idQuestion</h1>";
            while(isset($_POST["Reponse".$iReponse."_".$iQuestion]))
            {
                $reqReponse= $bdd->prepare("insert into reponse(libelle,  idQuestion) 
                  values( :libelle,  :idQuestion)");
                try{
                    $reqReponse->execute(array(

                        'libelle'=>$_POST["Reponse".$iReponse."_".$iQuestion],

                        'idQuestion'=>$idQuestion

                    ));
                    echo'<br/> Réponse '.$iReponse.' enregistrée !';
                }
                catch(PDOException $e)
                {
                    die('Erreur : ' .$e->getMessage());
                }
                $iReponse++;
            }
            $iQuestion ++;
            $iReponse = 1;
        }
        else
            $existe = false;
    }
}

?>
