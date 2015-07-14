$(document).ready(function () {
    $("#comboClasses").change(chargerDonnees);
});

chargerDonnees = function () {
    if($("select[name=comboClasses]").val() === ""){
        return;
    }
    $.ajax({
        url: "./classe/ajaxclasse",
        type: "POST",
        dataType: "json",
        data: {
            "idclasse": $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("#onglet1").html(result[0]);
            $("#onglet2").html(result[1]);
            $("#onglet3").html(result[2]);
            $("#onglet4").html(result[3]);
            $("#prof-principal").html(result[4]);
            $("#cpe-principal").html(result[5]);
            $("#resp-admin").html(result[6]);
            $("#effectif").html(result[7]);
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
    var frm = $("<form>", {
        action: "./classe/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).append($("<input>", {
        name: "idclasse",
        type: "hidden",
        value: $("select[name=comboClasses]").val()
    })).appendTo("body");
    frm.submit();
}