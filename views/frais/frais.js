var echeances, editecheances, idfrais;

$(document).ready(function(){
    
    $("#dataTable").DataTable({
       "bInfo": false
    });
    $("#comboClasses").change(chargerFrais);
    //Popup form
    $("#frais-dialog-form").dialog({
        autoOpen: false,
        height: 250,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Ajouter": function () {
                ajoutFrais();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#editfrais-dialog-form").dialog({
        autoOpen: false,
        height: 250,
        width: 350,
        modal: true,
        resizable: false,
        buttons: {
            "Modifier": function () {
                editFrais();
                $(this).dialog("close");
            },
            Annuler: function () {
                $(this).dialog("close");
            }
        }
    });
    echeances = getCalendar("echeances");
    editecheances = getCalendar("editecheances");
    
    //Bouton pour le popup
    $("#img-ajout").on("click",function(){ 
        $("#frais-dialog-form").dialog("open");
    });
    
    $("#fraisTable").DataTable({
        "bInfo": false,
        "scrollY": 200,
        "searching": false,
        "paging": false,
        "columns":[
            {"width": "55%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "5%"}
        ]
    });
});

function ajoutFrais(){
    removeRequiredFields([$("#comboClasses")]);
    if($("#comboClasses").val() === 0 || $("#comboClasses").val() === ""){
        alertWebix("Veuillez choisir d'abord une classe");
        addRequiredFields([$("#comboClasses")]);
        return;
    }
    var d = echeances.getValue();
    $("input[name=echeances]").val(d.split(' ')[0]);
    $.ajax({
       url : "./ajax/ajouter",
       type : "POST",
       dataType : "json",
       data:{
           "idclasse" : $("#comboClasses").val(),
           "description" : $("input[name=description]").val(),
           "montant": $("input[name=montant]").val(),
           "echeances": $("input[name=echeances]").val(),
       },
       success: function(result){
           $("#frais-content").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
}
function supprimerFrais(_id){
    $.ajax({
       url : "./ajax/supprimer",
       type : "POST",
       dataType : "json",
       data:{
           "idfrais" : _id,
           "idclasse" : $("#comboClasses").val()
       },
       success: function(result){
           $("#frais-content").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
}

/**
 * Charge la liste de scolarite pour une classe donnne dans la datatable
 * @returns {undefined}
 */
chargerFrais = function (){
    $.ajax({
       url : "./ajax/charger",
       type : "POST",
       dataType : "json",
       data:{
           "idclasse" : $("#comboClasses").val()
       },
       success: function(result){
           $("#frais-content").html(result[0]);
       },
       error: function(xhr, status, error){
           alert("Une erreur s'est produite " + xhr + " " + error);
       }
    });
};

function openEditForm(_id){
    $("#editfrais-dialog-form").dialog("open");
    idfrais = _id;
}
/**
 * Function utilser lorsqu'on clique sur Ajouter du formulaire
 * edit frais
 */
function editFrais(){
    var d = editecheances.getValue();
    $("input[name=echeances]").val(d.split(' ')[0]);
    $.ajax({
        url: "./ajax/edit",
        type: "POST",
        dataType: "json",
        data:{
            "idfrais": idfrais,
            "idclasse": $("#comboClasses").val(),
            "description": $("input[name=editdescription]").val(),
            "montant": $("input[name=editmontant]").val(),
            "echeances": $("input[name=echeances]").val()
        },
        success: function(result){
            $("#frais-content").html(result[0]);
        },
        error: function(xhr, status, error){
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}
