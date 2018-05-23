<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=sondage','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                                                                                     PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    #Ne pas oublier de changer le nom du host et l'acc�s
    
}
catch (Exception $e)
{
    die('Erreur : ' .$e->getMessage());
}
?>