<?php
/**
 * Elvégzi az adatbázis telepítését, valamint hiba esetén naplózza azt.
 */
require_once(__DIR__ . '\..\model\model.php');

$model = new model();
$read = file_get_contents(__DIR__ . '\install.sql');

try {
    $model->pdo->exec($read);
    echo "Az adatbázis telepités sikeres!";
} catch (PDOException $e) {
    file_put_contents(config::LOG_FILE, $e->getMessage() . PHP_EOL, FILE_APPEND);
}
