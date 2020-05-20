<?php
/**
 * Ez az osztály eldönti a telepítés szükségességét.
 */
require_once(__DIR__ . '\..\model\model.php');
class controller
{
    public function __construct()
    {
        try {
            $try = new model();
            $try->pdo->query("SELECT * FROM ".config::PERSON_TABLE);
        }
        catch (PDOException $e)
        {
            require_once('install\install.php');
        }
        require_once('view/view.php');
    }
}