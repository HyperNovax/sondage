<?php

class PdoDatabase
{

    private $PdoInstance = null;

    private static $instance;

    private function __construct () {
        try
        {
            $this->PdoInstance = new PDO('mysql:host=localhost;dbname=sondage','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (Exception $e)
        {
            die('Erreur : ' .$e->getMessage());
        }
    }

    public static function getInstance () {
        if (self::$instance == null) {
            return self::$instance = new PdoDatabase();
        } else {
            return self::$instance;
        }
    }

    public function getDbh () {
        return $this->PdoInstance;
    }



}