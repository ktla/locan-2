$(document).ready(function () {
    $("#ajout-emplois").on("click", function () {
        openAjoutForm();
    });
    $("#tableEmplois").DataTable({
        "bInfo": false,
        "columns": [
            {"width": "10%"},
            {"width": "7%"},
            {"width": "7%"},
            null,
            null,
            {"width": "5%"},
        ]
    });
    $("#ajout-emplois-dialog").dialog({
        autoOpen: false,
        height: 270,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                ajoutEmplois();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    //Selecteur des heure
    $('#heuredebut, #heurefin').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 30
    });
    //On change de comboClasses
    $("#comboClasses").change(chargerEmplois);
});



function openAjoutForm() {
    removeRequiredFields([$("#comboClasses")]);
    if ($("#comboClasses").val() === "") {
        alertWebix("Veuillez d'abord choisir une classe");
        addRequiredFields([$("#comboClasses")]);
        return;
    }
    $("#ajout-emplois-dialog").dialog("open");
}

chargerEmplois = function () {
    $.ajax({
        url: "./ajax/charger",
        dataType: "json",
        type: "POST",
        data: {
            "idclasse": $("#comboClasses").val()
        },
        success: function (result) {
            $("select[name=enseignement]").html(result[0]);
            $("#emplois-content").html(result[1]);
            $("#apercu-content").html(result[2]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function ajoutEmplois() {
    $.ajax({
        url: "./ajax/ajout",
        type: "POST",
        dataType: "json",
        data: {
            "jour": $("select[name=jour]").val(),
            "idenseignement": $("select[name=enseignement]").val(),
            "heuredebut": $("#heuredebut").val(),
            "heurefin": $("#heurefin").val(),
            "idclasse": $("#comboClasses").val()
        },
        success: function (result) {
            $("#emplois-content").html(result[1]);
            $("#apercu-content").html(result[2]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

function supprimerHoraire(idemplois){
    $.ajax({
        url: "./ajax/supprimer",
        type: "POST",
        dataType: "json",
        data: {
            "idemplois": idemplois,
            "idclasse": $("#comboClasses").val()
        },
        success: function (result) {
            $("#emplois-content").html(result[1]);
            $("#apercu-content").html(result[2]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}