$(document).ready(function () {
    $("select[name=comboClasses]").change(chargerEleves);
});

var chargerEleves = function () {
    if ($("select[name=comboClasses]").val() === "") {
        return;
    }

    $.ajax({
        url: "./ajaximpression",
        type: "POST",
        dataType: "json",
        data: {
            action: "chargerEleves",
            idclasse: $("select[name=comboClasses]").val()
        },
        success: function (result) {
            $("select[name=comboEleves]").html(result[0]);
        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
};

function impression() {
    removeRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
    if ($("select[name=comboClasses]").val() === "" || $("select[name=comboPeriodes]").val() === "") {
        addRequiredFields([$("select[name=comboClasses]"), $("select[name=comboPeriodes]")]);
        alertWebix("Veuillez remplir les champs obligatoires");
        return;
    }
    
    var frm = $("form[name=frmbulletin]");
    frm.submit();

}