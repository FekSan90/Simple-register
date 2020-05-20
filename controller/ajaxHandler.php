<?php
/**
 * Ez a program a kliensről érkező kéréseket kezeli,
 * ami lehet: törlés, módosítás, beszúrás az adatbázisba.
 * Ezekre a kérésekre válaszol is.
 *
 */

include(__DIR__ . "\..\model\person.php");

if ($_POST['action'] == "delete") {

    $person = new person($_POST['id']);

    try {
        $person->delete();
        echo "Deleted";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if ($_POST['action'] == "update" || $_POST['action'] == "insert") {

    $person = new person($_POST['id']);
    $person->setName($_POST['name']);
    $person->setBirthdate($_POST['birthdate']);
    $person->setGender($_POST['gender']);

    try {
        if ($_POST['action'] == "update") {
            $person->update();
            echo "Updated";
        } else {
            if (($person->insert())) {
                echo "Inserted";
            } else {
                echo "Exist";
            }
        }
    } catch (PDOException $e) {

        if ($e->getCode() == 23505) {      // Ha az egyediséget megsérti
            echo "Exist";
        } else {
            echo $e->getMessage();
        }
    }
}

