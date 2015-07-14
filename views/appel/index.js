$(document).ready(function () {
    $("#tableAbsences").DataTable({
        bInfo: false,
        paging: false,
        columns: [
            {"width": "5%"},
            null,
            {"width": "15%"},
            {"width": "15%"},
            {"width": "7%"},
            {"width": "7%"},
            {"width": "7%"}
        ]
    });

    $("select[name=comboPeriodes]").change(chargerDistributions);
    $("select[name=comboDistributions]").change(chargerDonnees);
});


var chargerDonnees = function () {
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        $("select[name=comboDistributions]")[0].selectedIndex = 0;
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
        alertWebix("Veuillez d'abord remplir les champs obligatoires");
        return;
    }

    if ($("select[name=comboDistributions]").val() === "") {
        return;
    }

    $.ajax({
        url: "./appel/ajaxindex",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "periode": $("select[name=comboPeriodes]").val(),
            "distribution": $("select[name=comboDistributions]").val(),
            "action": "chargerDonnees"
        },
        success: function (result) {
            $("#absence-content").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });

};

var chargerDistributions = function () {

    if ($("select[name=comboPeriodes]").val() === "") {
        return;
    }

    removeRequiredFields([$("select[name=comboClasses]")]);
    if ($("select[name=comboClasses]").val() === "") {
        $("select[name=comboPeriodes]")[0].selectedIndex = 0;
        addRequiredFields([$("select[name=comboClasses]")]);
        alertWebix("Veuillez d'abord choisir une classe");
        return;
    }
    $.ajax({
        url: "./appel/ajaxindex",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val(),
            "periode": $("select[name=comboPeriodes]").val(),
            "action": "chargerDistributions"

        },
        success: function (result) {
            $("select[name=comboDistributions]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};


function imprimer() {
    if ($("select[name=code_impression]").val() === "") {
        return;
    }
    removeRequiredFields([$("select[name=comboDistributions]")]);
    if ($("select[name=comboDistributions]").val() === "") {
        $("select[name=code_impression]")[0].selectedIndex = 0;
        addRequiredFields([$("select[name=comboDistributions]")]);
        alertWebix("Veuillez d'abord choisir une distribution");
        return;
    }
    var frm = $("<form>", {
        action: "./appel/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "distribution",
        type: "hidden",
        value: $("select[name=comboDistributions]").val()
    })).append($("<input>", {
        name: "periode",
        type: "hidden",
        value: $("select[name=comboPeriodes]").val()
    })).append($("<input>", {
        name: "idclasse",
        type: "hidden",
        value: $("#comboClasses").val()
    })).appendTo("body");
    frm.submit();
}
