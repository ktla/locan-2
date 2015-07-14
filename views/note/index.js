$(document).ready(function () {

});

function supprimerNotation(idnotation) {
    $("<form>", {
        action: "notation/delete/" + idnotation,
        method: "post"
    }).appendTo('body').submit();
}

function editNotation(idnotation) {
    $("<form>", {
        action: "note/edit/" + idnotation,
        method: "post"
    }).appendTo('body').submit();
}

function impression(_id){
    var frm = $("<form>", {
        action: "./note/imprimer",
        target: "_blank",
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: "0004"
    })).append($("<input>", {
        name: "idnotation",
        type: "hidden",
        value: _id
    })).appendTo("body");

    frm.submit();
}
