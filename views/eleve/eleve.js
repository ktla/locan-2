var calendrier, caldatenaiss, caldateentree;
$(document).ready(function () {
    calendrier = getCalendar("date");
    caldatenaiss = getCalendar("datenaiss");
    caldateentree = getCalendar("dateentree");
    //Definir la date d'entree a la date du jour
    caldateentree.setValue(new Date());

    $("#ajout-responsable-dialog-form").dialog({
        autoOpen: false,
        height: 270,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                selectResponsable();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#ajout-responsable").button().on("click", function () {
        $("#ajout-responsable-dialog-form").dialog("open");
    });
    $("#responsabletable").DataTable({
        "paging": false,
        "bInfo": false,
        "scrollCollapse": true,
        "scrollY": 300,
        "searching": false,
        "columns": [
            {"width": "5%"},
            null,
             {"width": "5%"}
        ]
    });
});
/**
 * Utiliser sur le bouton ajouter de la page saisie eleve/onglet Responsable
 * @returns {undefined}
 */
function selectResponsable() {
    var frmeleve = $("form[name=frmeleve]");
    removeRequiredFields([$("input[name=nomel]"), $("#datenaiss")]);
    d = caldatenaiss.getValue();
    $("input[name=datenaiss]").val(d.split(' ')[0]);
    if ($("input[name=nomel]").val() === "" || $("input[name=datenaiss]").val() === "") {
        addRequiredFields([$("input[name=nomel]"), $("#datenaiss")]);
        onglets(1, 1, 3);
        alertWebix("Veuillez remplir les champs élève d'abord");
        return;
    }
   var resp = {
       "idresponsable" : $("#listeresponsable").val(),
       "parente" : $("#parenteextra").val(),
       "charges": $("input[name=chargeextra]:checked").map(function () {
                 return this.value;
            }).get()
   };
    $("input[name=responsable]").val(JSON.stringify(resp));
    
    $.ajax({
        url: "./ajaxsaisie/oldresponsable",
        type: "POST",
        data: frmeleve.serialize(),
        dataType: "json",
        success: function(result){
            $("input[name=ideleve]").val(result[0]);
            $("#responsable_content").html(result[1]);
            $("#listeresponsable").html(result[2]);
        },
        error: function(xhr, status, error){
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
   });
}



function saveResponsable() {
    var frmeleve = $("form[name=frmeleve]");
    removeRequiredFields([$("input[name=nomel]"), $("#datenaiss")]);
    d = caldatenaiss.getValue();
    $("input[name=datenaiss]").val(d.split(' ')[0]);
    if ($("input[name=nomel]").val() === "" || $("input[name=datenaiss]").val() === "") {
        onglets(1, 1, 3);
        alertWebix("Veuillez remplir les champs élève d'abord");
        addRequiredFields([$("input[name=nomel]"), $("#datenaiss")]);
        return;
    }
    //Verification des champs des responsables
    removeRequiredFields([$("input[name=nom]"), $("input[name=portable]")]);
    if ($("input[name=nom]").val() === "" || $("input[name=portable]").val() === "") {
        alertWebix("Veuillez remplir les champs obligatoires");
        addRequiredFields([$("input[name=nom]"), $("input[name=portable]")]);
        return;
    }
    var element = {
        "civilite": $("select[name=civilite]").val(),
        "nom": $("input[name=nom]").val(),
        "prenom": $("input[name=prenom]").val(),
        "adresse": $("input[name=adresse1]").val() + "#" + $("input[name=adresse2]").val() + "#" + $("input[name=adresse3]").val(),
        "telephone": $("input[name=telephone]").val(),
        "portable": $("input[name=portable]").val(),
        "email": $("input[name=email]").val(),
        "profession": $("input[name=profession]").val(),
        "parente": $("select[name=parente]").val(),
        "charge": $("input[name=charge]:checked").map(function () {
            return this.value;
        }).get(),
        "acceptesms": $("input[name=acceptesms]:checked").val(),
        "numsms": $("input[name=numsms]").val(),
        "bp": $("input[name=bp]").val()
    };
   
    $("input[name=responsable]").val(JSON.stringify(element));
    
    //Envoyer ce nouvel responsable dans la BD
    $.ajax({
        url: "./ajaxsaisie/responsable",
        type: "POST",
        data: frmeleve.serialize(),
        dataType: "json",
        success: function(result){
            $("input[name=ideleve]").val(result[0]);
            $("#responsable_content").html(result[1]);
        },
        error: function(xhr, status, error){
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
    resetResponsable();
}
//Soumet effectivement le formulaire des eleves au server
function soumettreFormEleve() {
    removeRequiredFields([$("input[name=nomel]"), $("#datenaiss")]);
    var frm = $("form[name=frmeleve]");
    var d = caldatenaiss.getValue();
    var dNaiss = $("<input type='hidden' name='datenaiss'/>");
    dNaiss.val(d.split(' ')[0]);
    d = caldateentree.getValue();
    var dEntree = $("<input type = 'hidden' name = 'dateentree' />");
    dEntree.val(d.split(' ')[0]);

    if ($("input[name=nomel]").val() === "" || dNaiss.val() === "") {
        alertWebix("Veuillez remplir les champs obligatoires");
        addRequiredFields([$("input[name=nomel]"), $("#datenaiss")]);
        onglets(1, 1, 3);
        return;
    }
    
    //add the date from webix datepicker

    frm.append(dEntree);
    frm.append(dNaiss);
    frm.submit();
}
function savePhotoEleve() {
    if ($("input[name=photo]").val() === "") {
        alertWebix("Veuillez sélectionner le fichier image");
        return;
    }
    var frmphoto = $("#frmphoto");
    var formData = new FormData(document.getElementById("frmphoto"));

    $.ajax({
        url: frmphoto.attr("action"),
        type: 'POST',
        enctype: 'multipart/form-data',
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            $("#btn_photo_action").html(result[0]);
            //cadre pour l'affichage de l'image uploader
            $("#photoeleve").html("<img style = 'width:200px;height:200px;' src ='" + result[1] + "' />");
            $(".errors").html(result[2]);
            //hidden photo contient le nom de la photo a sauvegarder et envoyer plutart au server
            $("input[name=photoeleve]").val(result[3]);
            //le input type file
            $("input[name=photo]").val("");
        },
        error: function (xhr, status, error) {
            alert("Veuillez vous reconnecté en rafraichissant la page");
        }
    });
}
function effacerPhotoEleve() {
    $.ajax({
        url: "./photo/" + $("input[name=photoeleve]").val(),
        type: 'POST',
        dataType: "json",
        data: $("#photoeleve").val(),
        success: function (result) {
            $("#btn_photo_action").html(result[0]);
            $("#photoeleve").html(result[1]);
            $(".errors").html(result[2]);
            $("input[name=photoeleve]").val(result[3]);
            $("input[name=photo]").val("");
        },
        error: function (xhr, status, error) {
            alert(error + " " + xhr + " " + status);
        }
    });
}
/**
 * Suppression d'un responsable dans la dataTable responsable
 * @param {type} id
 * @returns {undefined}
 */
function deleteResponsabilite(id){
    $.ajax({
        url: "./deleteResponsable",
        type: 'POST',
        dataType: "json",
        data: {
            "idresponsableeleve" : id,
            "ideleve" : $("input[name=ideleve]").val()
        },
        success: function (result) {
            $("#responsable_content").html(result[0]);
            $("#listeresponsable").html(result[1]);
        },
        error: function (xhr, status, error) {
            alert(error + " " + xhr + " " + status);
        }
    });
}

function resetResponsable() {
    document.forms['formresponsable'].reset();
}
