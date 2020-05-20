<?php
/*
 * Az adatbázis kapcsolatot teszi lehetővé.
 * A használathoz szükséges a php.ini-ben
 * a extension=pdo_pgsql sor elött kitörölni a pontosveszőt.
 * */

require_once(__DIR__.'\..\config.php');
class model
{
    public $pdo;

    public function __construct()
    {
        $pdo=null;
        $dsn = config::DB_LIB . ":host=" . config::DB_HOST . ";dbname=" . config::DB_NAME;
        try {
            $this->pdo = new PDO($dsn, config::DB_USER, config::DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}