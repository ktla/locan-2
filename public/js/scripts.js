//Loading external javascript files
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/jquery-ui.js"></script>');
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/jquery.dataTables.min.js"></script>');
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/codebase/webix.js"></script>');

$(document).ready(function () {
    var max = $(window).height() - 154;
    $("#menu").css({maxHeight: max});
    if ($(".titre").length === 0) {
        hTitre = -22;
    } else {
        hTitre = $(".titre").height();
    }

    if ($(".recapitulatif").length === 0) {
        hRecapitulatif = -18;
    } else {
        hRecapitulatif = $(".recapitulatif").height();
    }

    var h = $("#entete").height() + $(".navigation").height() + hRecapitulatif
            + $(".status").height() + hTitre;
    $(".page").css({height: $(window).height() - h - 97});



    $(document).ajaxStart(function () {
        $("#loading").show();
    }).ajaxStop(function () {
        $("#loading").hide();
    });
    //hauteur des dataTable
    var dHeight;
    if ($(".onglet").length !== 0) {
        dHeight = $(".page").height() - 140;
    } else {
        dHeight = $(".page").height() - 100;
    }

    $.extend($.fn.dataTable.defaults, {
        "aaSorting": [],
        "scrollCollapse": false,
        "scrollY": dHeight,
        "pageLength": 200,
        "paging": true,
        "searching": true,
        "bInfo": true,
        //"dom": '<"tableWrapper"fl>',
        "jQueryUI": true,
        "language": {
            "sProcessing": "Traitement en cours...",
            "sSearch": "Rechercher&nbsp;:",
            "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix": "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            },
            "oAria": {
                "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
        }
    });
    //default datatables


    /*
     * Fonction permettant d'afficher et cacher le menu.
     *
     */
    (function () {
        var p_el, i = 0;
        p_el = document.querySelectorAll("#menu-accordeon li > p");
        for (; i < p_el.length; i++) {
            p_el.item(i).addEventListener('click', function (e) {
                var p, lis;
                p = e.target.parentNode;
                lis = p.nextSibling.childNodes;
                if (getComputedStyle(lis[0], false).maxHeight === '240px') {
                    for (var j = 0; j < lis.length; j++)
                        lis[j].style.maxHeight = '0px';
                    p.style.backgroundImage = "-webkit-linear-gradient(top, #729EBF 50%, #333A40 100%)";
                    p.style.backgroundImage = "-o-linear-gradient(bottom, #729EBF 50%, #333A40 100%)";
                    p.style.backgroundImage = "-moz-linear-gradient(bottom, #729EBF 50%, #333A40 100%)";
                    p.style.backgroundImage = "linear-gradient(bottom, #729EBF 50%, #333A40 100%)";


                } else {

                    for (var j = 0; j < lis.length; j++)
                        lis[j].style.maxHeight = '240px';
                    p.style.backgroundImage = "-webkit-linear-gradient(left, white 30%, #729EBF 100%)";
                    p.style.backgroundImage = "-o-linear-gradient(left, white 30%, #729EBF 100%)";
                    p.style.backgroundImage = "-moz-linear-gradient(left, white 30%, #729EBF 100%)";
                    p.style.backgroundImage = "linear-gradient(left, white 30%, #729EBF 100%)";

                }
            }, false);

        }
    })();

    //Ajouter le scrolling en fonction de hauteur de la page visible
    //Definir la langue pour webix
    webix.i18n.setLocale("fr-FR");
});

webix.i18n.locales["fr-FR"] = {
    calendar: {
        monthFull: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
        dayFull: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        dayShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"]
    }
};

function deleteRow(_url, name) {
    webix.modalbox({
        title: "Suppression d'une ligne",
        buttons: ["Oui", "Non"],
        width: "300px",
        text: "Etes-vous certain de vouloir supprimer " + name,
        callback: function (result) {
            if (result == 0) {
                document.location = _url;
            }
        }
    });
}
/**
 * utiliser pour afficher les message
 * de warning a l'endroit de l'utilisateur
 * @param {type} sms
 * @returns {undefined}
 * 
 */

function alertWebix(sms) {
    webix.modalbox({
        title: "Alerte",
        buttons: ["Ok"],
        width: "300px",
        text: sms
    });
}
function editRow(_url) {
    document.location = _url;
}
/**
 * Readjuste les colonnes des table lorsqu'on clique sur un onglet
 * @param {array} elts
 * @returns {void}
 */
function reAdjustDataTableColumns(elts) {
    var i;
    for (i = 0; i < elts.length; i++) {
        var el = elts[i];
        if ($("#" + el).length) {
            if ($.fn.DataTable.isDataTable("#" + el)) {
                var table = $("#" + el).DataTable();
                table.columns.adjust().draw();
            }
        }
    }
}
function onglets(premier, actuel, nombre) {
    for (i = premier; i < nombre + 1; i++) {
        if (i === actuel) {
            document.getElementById('tab' + i).className = 'courant';
            document.getElementById('onglet' + i).style.display = 'block';
        } else {
            document.getElementById('tab' + i).className = 'noncourant';
            document.getElementById('onglet' + i).style.display = 'none';
        }
    }
    var array_of_dataTables = ["tab_mat", "tableEnseignants", "tableFinance", "persoTable",
        "tableEleves", "eleveTable", "responsabletable", "onglet2_table", "dataTable2", "dataTable",
        "connexionTable", "droitTable", "tableEnseignements", "tableAbsences1", "tableAbsences2", "tableAbsences3", 
    "tableAbsences4", "tableAbsences5", "justificationTable"];
    reAdjustDataTableColumns(array_of_dataTables);
}


/**
 * Permet d'ajouter un style particulier au champs obligatoires
 * @param {array} fields le tableau des champs obligatoires, a definir [champ1, champ2, etc...];
 * @returns {undefined}
 */
function addRequiredFields(fields) {
    for (i = 0; i < fields.length; i++) {
        if (fields[i].val() === "")
            fields[i].addClass("requiredFields");
    }
}
/**
 * Enleve le style appliquee aux champs obligatoire par la fonction requiredFields
 * @param {array} fields
 * @returns {undefined}
 */
function removeRequiredFields(fields) {
    for (i = 0; i < fields.length; i++) {
        fields[i].removeClass("requiredFields");
    }
}

function getCalendar(id) {
    if ($("#" + id).length) {
        calendar = webix.ui({
            view: "datepicker",
            id: id,
            name: id,
            container: id,
            width: 160,
            height: 25,
            placeholder: "JJ-MM-AAAA",
            format: "%D %d %M %Y",
            stringResult: true
        });
        return calendar;
    }
    return null;

}

function tooltip_on(e, ligne, dec) {
    dec = dec || false;

    var posx = 0;
    var posy = 0;
    if (!e)
        e = window.event;
    if (dec) {
        var top = 5;
    } else {
        var top = 110;
    }
    if (e.pageX || e.pageY) {
        posx = e.pageX - 210;
        posy = e.pageY - top;
    } else if (e.clientX || e.clientY) {
        posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft - 210;
        posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop - top;
    }
    document.getElementById('tooltip' + ligne).style.left = posx + 'px';
    document.getElementById('tooltip' + ligne).style.top = posy + 'px';
    document.getElementById('tooltip' + ligne).style.display = 'block';
}

function tooltip_off(ligne) {
    window.off = setTimeout(function () {
        document.getElementById('tooltip' + ligne).style.display = 'none';
    }, 200);
}

function tooltip_stop(ligne) {
    clearTimeout(window.off);
}
