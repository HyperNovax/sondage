<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenue sur PLS Amiens !</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!--<link href="css/bootstrap-select.css" rel="stylesheet">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <!--<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>-->
      <link rel="icon" 
      type="image/png" 
      href="images/favicon-16x16.png" />

    <![endif]-->
  </head>
  <body>
    

    
    <?php extract($_POST);?>
    
    <!-- Accès à la base de données !-->
    <?php
    include("includes/accesBDD.php");
    
        session_start();
        
        $req=$bdd->query("select count(*) as verif from utilisateur where login = '".$_COOKIE['login']."' and mdp ='".$_COOKIE['pass_hache']."'");
        $val = $req->fetch(PDO::FETCH_ASSOC);
        $verif=$val['verif'];
        if($verif == 1)
        {
          $req = $bdd->query("select role from utilisateur where login = '".$_COOKIE['login']."'");
         
          $ligne = $req->fetch(PDO::FETCH_OBJ);
          
          // --> OUVERTURE SESSION <--
          
          $_SESSION['login'] = $_COOKIE['login'];
          $_SESSION['role'] = $ligne->role;
        }
        if(!isset($_SESSION['login']))
        {
          session_destroy();
          
            include("includes/navbarConnexion.php");
        }
        else{
          //Pour retenir la dernière connexion de l'utilisateur
            date_default_timezone_set("Europe/Paris");
            $heure = (new \DateTime())->format('Y-m-d H:i:s');
            $req=$bdd->prepare("update utilisateur set connexion= '".$heure."' where  login ='".$_SESSION['login']."' ");
            try{
              $req->execute();
            }
            catch(PDOException $e)
            {
              die('Erreur : ' .$e->getMessage());
            }
        
            if($_SESSION['role']=='a'){
                include("includes/navbarAdmin.php");
                //LE header pour faire chier les admins
                //header("Location: https://www.youtube.com/watch?v=3q2MVCAYkj4");
            }
            elseif($_SESSION['role']=='c')
                include("includes/navbarContributeur.php");
            else
                include("includes/navbarEtudiant.php");
          
          echo'<div class="pull-right">';
          if($_SESSION['role']=='a'){
          
            echo'<select class="form-control">';
             
                    $requete=$bdd->query('select login, mail from utilisateur');
                    $inscrits =0;
                    while($lesPseudos =$requete->fetch(PDO::FETCH_OBJ))
                    {
                        
                        echo"<option >". $lesPseudos->login. " / ".$lesPseudos->mail."</option>";
                        $inscrits = $inscrits +1;
                        
                    }
                    echo"
            </select><strong>".$inscrits." inscrits /";
            
            $req=$bdd->query('SELECT login, COUNT( * ) 
                              FROM  `utilisateur` 
                              GROUP BY mail');
            $adresses=0;
            while($lesMails = $req->fetch(PDO::FETCH_OBJ))
              $adresses = $adresses +1;
            echo $adresses." adresses mails utilisées </strong><br/>";
            
          }
          ?><br/>
          <h4>Quoi de neuf sur PLS ?</h4>
          <select multiple class="form-control" onchange="window.open(this.value); ">
            <?php
              $req = $bdd->query("SELECT nomFichier, createur, lien
                    FROM  `fichier` 
                    ORDER BY id DESC 
                    LIMIT 0 , 10");
              while($datas=$req->fetch(PDO::FETCH_OBJ))
              {
                echo"<option value="."'$datas->lien'"."> $datas->createur a ajouté $datas->nomFichier </option>";
              }
              
            ?>
  
</select>
          <h4>Et sur le forum ?</h4>
          
          
          
          <select  multiple class="form-control" onchange="window.open(this.value); " >
            <?php  
          $req = $bdd->query("SELECT  idMessage,auteur ,  nomTopic , DATE_FORMAT( DATE,  '%d/%m/%Y' ) AS date, nomTopic
                            FROM  `messages` 
                            ORDER BY idMessage DESC 
                            LIMIT 0 , 10");
              while($datas=$req->fetch(PDO::FETCH_OBJ))
              {
                 $value = "topic?titre=".urlencode($datas->nomTopic)."#".$datas->idMessage;
                echo "<option value =$value> $datas->auteur a posté dans $datas->nomTopic le $datas->date </option>";
              }
          
          
          echo "</select>";
          }?>
          
          </div>
          <br/>
          <br/>
     
    
    <div class="container-fluid">
     
        <h1>Préparation Licence Santé</h1>
        <br/>
        <br/>
        <blockquote>
            <p>Un panel de fiches, QCMs, annales et autres questionnaires pour s'entraîner aux examens<br/> de L2-L3 médecine d'Amiens.</p>
        </blockquote>
        <p class="text-danger" ><strong>
          -<u>
            Pour tout éventuel report d'erreurs dans les annales, veuillez passer par le forum prévu à cet effet. Aucune demande privée ne sera traitée via Facebook ou autre !
            <br/><br/>
            </u>-
            <u>En cas de soucis de lecture, préférez google chrome ou firefox
          </u></strong>
        </p>
        

        <br/>
        <br/>
    
         
          
 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Semestre 3
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">

      <div class="row">

    
    <?php
        $index = 0;
            $req = $bdd->query("SELECT id, nomUe
                                            FROM ue where idSemestre = 3
                                            ");
                            
                           while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
            {
                $tab_id[$index] = $lesFichiers->id;
                $tab_nom[$index] = $lesFichiers->nomUe;
                $index ++;
            }
            $ind = 0;
            $num = 1;
        
        while($ind!=$index)
        {
          
            ?>
            
                <div class="col-md-4">
                    <?php echo '<span class="badge">'.$num.'</span> '.$tab_nom[$ind]; ?>
                </div>
               
                <div class="col-md-4">
                    <FORM>
                        <SELECT class="form-control" onchange="window.open(this.value); " >
                            <OPTION selected>Fiches</OPTION>
                    <?php
                            
                            $req = $bdd->query("SELECT nomFichier, lien, description, nom
                                            FROM fichier
                                            JOIN groupe ON fichier.idGroupe = groupe.id
                                            WHERE idUe =".$tab_id[$ind]." and idType = 4
                                            ORDER BY groupe.id , nomfichier asc");
                            $optGroup =NULL;
                           while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
                            {
                              if($optGroup == NULL && $lesFichiers->nom =="Non-classé" )
                                echo "<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                              else{
                                if($lesFichiers->nom!=$optGroup)
                                {
                                    if($optGroup!=NULL)
                                    {
                                        echo"</optgroup>";
                                    }
                                    $optGroup = $lesFichiers->nom;
                                    echo "<optgroup label =$optGroup>";
                                }
                                echo"<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                                
                            }}
                            
                            
                            ?>
                            
                            
                        </SELECT>
                    </FORM>
                </div>
                <?php
                  if(!isset($_SESSION['login']))
                  {
                    if($num ==1)
                    ?>
                      <div class="col-md-4">
                       <h4> Vous devez être connecté pour accéder aux annales</h4>
                      </div>
                      <?php
                  }
                  else{
                ?>
                <div class="col-md-4">
                    <FORM>
                      
                        <SELECT  class="form-control" onchange="window.open(this.value); " >
                            <OPTION selected>Annales</OPTION>
                   <?php
                            
                            $req = $bdd->query("SELECT nomFichier, lien, description, nom
                                            FROM fichier
                                            JOIN groupe ON fichier.idGroupe = groupe.id
                                            WHERE idUe =".$tab_id[$ind]." and idType = 3 
                                            ORDER BY groupe.id , nomfichier asc");
                            $optGroup =NULL;
                            while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
                            {
                              if($optGroup == NULL && $lesFichiers->nom =="Non-classé" )
                                echo "<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                              else{
                                if($lesFichiers->nom!=$optGroup)
                                {
                                    if($optGroup!=NULL)
                                    {
                                        echo"</optgroup>";
                                    }
                                    $optGroup = $lesFichiers->nom;
                                    echo "<optgroup label =$optGroup>";
                                }
                                echo"<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                                
                            }}
                            
                            
                            ?>
                            
                            
                        </SELECT>
                      
                    </FORM>
                </div>
                
            <?php }?>
                <br/>
                
            
            
            
            <?php
            $ind++;
            $num++;
        }
        ?>
        </div>
      
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Semestre 4
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
<div class="row">

    
    <?php
        $index = 0;
            $req = $bdd->query("SELECT id, nomUe
                                            FROM ue where idSemestre = 4
                                            ");
                            
                           while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
            {
                $tab_id[$index] = $lesFichiers->id;
                $tab_nom[$index] = $lesFichiers->nomUe;
                $index ++;
            }
            $ind = 0;
            $num = 1;
        
        while($ind!=$index)
        {
          
            ?>
            
                <div class="col-md-4">
                    <?php echo '<span class="badge">'.$num.'</span> '.$tab_nom[$ind]; ?>
                </div>
               
                <div class="col-md-4">
                    <FORM>
                        <SELECT class="form-control" onchange="window.open(this.value); " >
                            <OPTION selected>Fiches</OPTION>
                    <?php
                            
                            $req = $bdd->query("SELECT nomFichier, lien, description, nom
                                            FROM fichier
                                            JOIN groupe ON fichier.idGroupe = groupe.id
                                            WHERE idUe =".$tab_id[$ind]." and idType = 4
                                            ORDER BY groupe.id , nomfichier asc");
                            $optGroup =NULL;
                           while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
                            {
                              if($optGroup == NULL && $lesFichiers->nom =="Non-classé" )
                                echo "<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                              else{
                                if($lesFichiers->nom!=$optGroup)
                                {
                                    if($optGroup!=NULL)
                                    {
                                        echo"</optgroup>";
                                    }
                                    $optGroup = $lesFichiers->nom;
                                    echo "<optgroup label =$optGroup>";
                                }
                                echo"<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                                
                            }}
                            
                            
                            ?>
                            
                            
                        </SELECT>
                    </FORM>
                </div>
                <div class="col-md-4">
                <?php
                  if(!isset($_SESSION['login']))
                  {
                    if($num ==1)
                      ?>
                      
                       <h4> Vous devez être connecté pour accéder aux annales</h4>
                      </div>
                      <?php
                  }
                  else{
                ?>
                
                    <FORM>
                      
                        <SELECT class="form-control" onchange="window.open(this.value); " >
                            <OPTION selected>Annales</OPTION>
                   <?php
                            
                            $req = $bdd->query("SELECT nomFichier, lien, description, nom
                                            FROM fichier
                                            JOIN groupe ON fichier.idGroupe = groupe.id
                                            WHERE idUe =".$tab_id[$ind]." and idType = 3 
                                            ORDER BY groupe.id , nomfichier asc");
                            $optGroup =NULL;
                            while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
                            {
                              if($optGroup == NULL && $lesFichiers->nom =="Non-classé" )
                                echo "<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                              else{
                                if($lesFichiers->nom!=$optGroup)
                                {
                                    if($optGroup!=NULL)
                                    {
                                        echo"</optgroup>";
                                    }
                                    $optGroup = $lesFichiers->nom;
                                    echo "<optgroup label =$optGroup>";
                                }
                                echo"<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                                
                            }}
                            
                            
                            ?>
                            
                            
                        </SELECT>
                      
                    </FORM>
                </div>
                
            <?php }?>
                <br/>
                
            
            
            
            <?php
            $ind++;
            $num++;
        }
        ?>
        </div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Semestre 5
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
<div class="row">

    
    <?php
        $index = 0;
            $req = $bdd->query("SELECT id, nomUe
                                            FROM ue where idSemestre = 5 order by id
                                            ");
                            
                           while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
            {
                $tab_id[$index] = $lesFichiers->id;
                $tab_nom[$index] = $lesFichiers->nomUe;
                $index ++;
            }
            $ind = 0;
            $num = 1;
        
        while($ind!=$index)
        {
          
            ?>
            
                <div class="col-md-4">
                    <?php echo '<span class="badge">'.$num.'</span> '.$tab_nom[$ind]; ?>
                </div>
               
                <div class="col-md-4">
                    <FORM>
                        <SELECT class="form-control" onchange="window.open(this.value); " >
                            <OPTION selected>Fiches</OPTION>
                    <?php
                            
                            $req = $bdd->query("SELECT nomFichier, lien, description, nom
                                            FROM fichier
                                            JOIN groupe ON fichier.idGroupe = groupe.id
                                            WHERE idUe =".$tab_id[$ind]." and idType = 4
                                            ORDER BY groupe.id , nomfichier asc");
                            $optGroup =NULL;
                           while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
                            {
                              if($optGroup == NULL && $lesFichiers->nom =="Non-classé" )
                                echo "<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                              else{
                                if($lesFichiers->nom!=$optGroup)
                                {
                                    if($optGroup!=NULL)
                                    {
                                        echo"</optgroup>";
                                    }
                                    $optGroup = $lesFichiers->nom;
                                    echo "<optgroup label =$optGroup>";
                                }
                                echo"<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                                
                            }}
                            
                            
                            ?>
                            
                            
                        </SELECT>
                    </FORM>
                </div>
                <?php
                  if(!isset($_SESSION['login']))
                  {
                    if($num ==1)
                      ?>
                      <div class="col-md-4">
                       <h4> Vous devez être connecté pour accéder aux annales</h4>
                      </div>
                      <?php
                  }
                  else{
                ?>
                <div class="col-md-4">
                    <FORM>
                      
                        <SELECT  class="form-control" onchange="window.open(this.value); " >
                            <OPTION selected>Annales</OPTION>
                   <?php
                            
                            $req = $bdd->query("SELECT nomFichier, lien, description, nom
                                            FROM fichier
                                            JOIN groupe ON fichier.idGroupe = groupe.id
                                            WHERE idUe =".$tab_id[$ind]." and idType = 3 
                                            ORDER BY groupe.id , nomfichier asc");
                            $optGroup =NULL;
                            while($lesFichiers=$req->fetch(PDO::FETCH_OBJ))
                            {
                              if($optGroup == NULL && $lesFichiers->nom =="Non-classé" )
                                echo "<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                              else{
                                if($lesFichiers->nom!=$optGroup)
                                {
                                    if($optGroup!=NULL)
                                    {
                                        echo"</optgroup>";
                                    }
                                    $optGroup = $lesFichiers->nom;
                                    echo "<optgroup label =$optGroup>";
                                }
                                echo"<option data-toggle='tooltip' data-placement='left' title="."'$lesFichiers->description'"." value="."'$lesFichiers->lien'".">"."$lesFichiers->nomFichier"."</option>";
                                
                            }}
                            
                            
                            ?>
                            
                            
                        </SELECT>
                      
                    </FORM>
                </div>
                
            <?php }?>
                <br/>
                
            
            
            
            <?php
            $ind++;
            $num++;
        }
        ?>
        </div>
      </div>
    </div>
  </div>
</div>
 
 
      
        

    
  
        
        </div>
        <br/>
        <br/>
    <div class="navbar-left">
      <!--LIENS UTILES -->
      &nbsp;<strong><a target="blank" style="cursor: pointer;" onclick='window.open("liens utiles");'>Liens utiles</a></strong><br/>
      <?php if($_SESSION['role'] == 'a') {echo '&nbsp;<strong><a href="creerLien">Ajouter un lien</a></strong><br/>';} ?>
	  

          
          
          
          
    </div>
    <div class="navbar-right">
      
        <h6>2014 - 2016 © Copyright <u>Clément Das Neves</u>.<br/> Site administré par 
<u>Philippe Pulwermacher-Blanchard</u> et <u>Arnaud Morel.<br/></u> Titre honorifique : <u>Thomas Duquenne</u><br/>
Membre d'honneur : <u>Dudu</u><br/><br/>
        Contributeurs : Anna Potereau, Paul-Antoine Dairaine, Agnès Létrillart, &nbsp;<br/>
		Madalina Girba, Rémi Hébert, Guillaume Bouchez, Mathilde Lepers, &nbsp;<br/>
                Pierre Rivoalen, Julia Assayag, Emily McDonnell, Chloé Ntshaykolo, &nbsp;<br/>
                Clotilde Ammeux, Mathilde Burki, Bastien Kasch, Hugo Loriot-Pommelet &nbsp;<br/>
                Alexandre Mancheron, Lucas Bayart, Xavier Torio, Roxane Tibi, Mathilde Legrand &nbsp;<br/>
                Roxane Thiriart, Claire Fauvet, Clémence Cornet &nbsp;</h6>
      
    </div>        
    </div>

    
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>