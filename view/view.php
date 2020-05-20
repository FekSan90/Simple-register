<?php
/*
 * Az adatbázis rekordjainak táblázatba szedi,
 * valamint egy plusz beviteli sort ad hozzá a táblázathoz.
 */

require_once(__DIR__ . '\..\model\person.php');
$table = person::fetchAll();
?>
<div id='error'></div>
<table class="table1">
    <tr>
        <th id='id'>ID</th>
        <th id='name'>Név</th>
        <th id='birthdate'>Születési dátum</th>
        <th id='gender'>Neme</th>
        <th id='action'>Művelet</th>
    </tr>
    <?php
    if (is_countable($table)) {
        foreach ($table as $row) {
            $gender = $row->getgender() ? "Nő" : "Férfi";

            echo "<tr id='row-" . $row->getid() . "'>
                <td id='id-" . $row->getid() . "'>" . $row->getid() . "</td>
                <td id='name-" . $row->getid() . "'>" . $row->getname() . "</td>
                <td id='birthdate-" . $row->getid() . "'>" . $row->getbirthdate() . "</td>
                <td id='gender-" . $row->getid() . "'>" . $gender . "</td>
                <td id='action-" . $row->getid() . "'>
                    <a id='delete' href='#' onclick='deleteRow(" . $row->getid() . ")'></a>
                    <a id='modify' href='#' onclick='modifyRow(" . $row->getid() . ")'></a>
                </td>
            </tr>";
        }
    }

    $nextId = person::nextId();

    echo "<script>addRow(" . $nextId . ");</script>";
    ?>

</table>


