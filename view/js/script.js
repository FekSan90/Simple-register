function deleteRow(id) {
    $.post("controller/ajaxHandler.php",
        {
            action: "delete",
            id: id
        },
        function (result) {
            if (result === "Deleted") {
                $("#row-"+id).hide(1000);
                setTimeout(function () {
                    $("#row-"+id).remove();
                }, 1000);
            } else {
                showError("Hiba történt!");
            }
        });
}

function modifyRow(id) {

    var name = document.getElementById("name-"+id).innerText;
    var birthdate = document.getElementById("birthdate-"+id).innerText;

    document.getElementById("name-"+id).innerHTML =
        "<input id='input-name-" + id + "'  value='" + name.toString() + "' maxlength='30' />";

    document.getElementById("birthdate-"+id).innerHTML =
        "<input id='input-birthdate-" + id + "' type=\"date\" value=" + birthdate + " />";

    document.getElementById("gender-".concat(id)).innerHTML =
        "<select id='input-gender-" + id + "'  />" +
        "<option value=\"0\">Férfi</option>" +
        "<option value=\"1\">Nő</option>" +
        "</select>";

    document.getElementById("action-"+id).innerHTML =
        "<a id='send' href='#' onclick='sendRow(" + id + ")'></a>";

}

function sendRow(id) {

    var sendId = id;
    var sendName = document.getElementById("input-name-" + id).value;
    var sendBirthdate = document.getElementById("input-birthdate-" + id).value;
    var sendGender = document.getElementById("input-gender-" + id).value;

    $.post("controller/ajaxHandler.php",
        {
            action: "update",
            id: sendId,
            name: sendName,
            birthdate: sendBirthdate,
            gender: sendGender
        },
        function (result) {
            if (result === "Updated") {
                document.getElementById("name-" + id).innerHTML = sendName;
                document.getElementById("birthdate-" + id).innerHTML = sendBirthdate;
                document.getElementById("gender-" + id).innerHTML = sendGender === '1' ? "Nő" : "Férfi";
                document.getElementById("action-" + id).innerHTML =
                    "<a id='delete' href='#' onclick='deleteRow(" + id + ")'></a>\n" +
                    "<a id='modify' href='#' onclick='modifyRow(" + id + ")'></a>";
            } else if (result === "Exist") {
                showError("A személy már létezik!");
            } else {
                showError("Hiba történt!");
            }
          }
    );
}

function showError(str){
    $("#error").show();
    document.getElementById("error").innerHTML = str;
    $("#error").fadeOut(5000,function () {
        document.getElementById("error").innerHTML = "";
        $("#error").show();
    });
}

function insertRow(id) {

    var sendId = id;
    var sendName = document.getElementById("input-name-" + id).value;
    var sendBirthdate = document.getElementById("input-birthdate-" + id).value;
    var sendGender = document.getElementById("input-gender-" + id).value;

    if (sendName!=="") {
        $.post("controller/ajaxHandler.php",
            {
                action: "insert",
                id: sendId,
                name: sendName,
                birthdate: sendBirthdate,
                gender: sendGender
            },
            function (result) {

                if (result === "Inserted") {
                    addRow(id+1);
                    document.getElementById("name-" + id).innerHTML = sendName;
                    document.getElementById("birthdate-" + id).innerHTML = sendBirthdate;
                    document.getElementById("gender-" + id).innerHTML = sendGender === '1' ? "Nő" : "Férfi";
                    document.getElementById("action-" + id).innerHTML =
                        "<a id='delete' href='#' onclick='deleteRow(" + id + ")'></a>\n" +
                        "<a id='modify' href='#' onclick='modifyRow(" + id + ")'></a>";
                } else if (result === "Exist") {
                    showError("A személy már létezik!");
                }
                 else {
                    showError("Hiba történt!");
                }
            }
        );
    }
    else{
        showError("Nem lehet üres mező!");
    }
}


function addRow(id) {

    var today = new Date();

    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }

    today = yyyy + '-' + mm + '-' + dd;

    var input =
        "<tr id='row-"+id+"'>" +
        " <td id='id-"+id+"'>"+id+"</td>" +
        " <td id='name-"+id+"'><input id='input-name-"+id+"'  maxlength='30' /></td> " +
         "<td id='birthdate-"+id+"'><input id='input-birthdate-"+id+"'  value=\""+ today +"\" type=\"date\" /></td>" +
         "<td id='gender-"+id+"'>" +
        "<select id='input-gender-"+id+"'> " +
            "<option value=\"0\">Férfi</option>" +
            "<option value=\"1\">Nő</option>" +
        "</select>" +
        "</td>" +
        "<td id='action-"+id+"'>" +
            "<a id='insert' href='#' onclick='insertRow("+id+")'></a>" +
            "</td>" +
            "</tr>";

    $('.table1 tr:last').after(input);

}