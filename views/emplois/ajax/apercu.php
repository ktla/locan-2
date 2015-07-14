<style>
    .apercu-emplois{
        border-collapse: collapse;
        border: 1px solid #000;
        margin: auto;
        width: 100%;
    }
    .apercu-emplois th{
        
    }
    .apercu-emplois tbody td{
        border: 1px solid #000;
        width: 150px;
        height: 60px; 
        padding: 2px 6px 6px 0.5px;
        max-width: 150px;
        max-height: 60px;
        overflow: hidden;
    }
    .apercu-emplois tbody td:first-child {
        border: 1px solid #000;
        width: 45px;
        height: 60px; 
        padding: 0;
        max-width: 45px;
        max-height: 60px;
        overflow: hidden;
    }
    .heu{
        width: 100%;
        height: 100%;
        display: block;
        font-size: 13px;
        font-weight: bold;
        padding-left: 5px;
    }
    .heu .el1{
        top: 2px;
        position: relative;
        display: inline-block;
        left: 1px;
    }
    .heu .el2{
        position: relative;
        left: 1px;
        display: inline-block;
        top: 32px;
    }
    
    .heu label sup{
    
        position: relative;
        top: 3px;
    }
    
    .mat{
        position: relative;
        width: 100%;
        height: 100%;
        display: block;
        font-size: 12px;
        box-shadow: 3px 3px 0px #aaa; 
    }
    .mat .el1{
        background-color: red;
        display: inline-block;
        text-align: center;
        vertical-align: top;
        width: 100%;
        position: relative;
    }  
    .mat .el2{
        background-color: green;
        display: inline-block;
        text-align: center;
        position: relative;
        top: 8%;
        width: 100%;
    }
    
    .mat .el3{
        background-color: greenyellow;
        display: inline-block;
        text-align: center;
        position: relative;
        bottom: 0;
        width: 100%;
    }
</style>
<script type="text/javascript">
    var heur = {
        "08:00": 0,
        "09:00": 1,
        "10:00": 2,
        "11:00": 3,
        "12:00": 4,
        "13:00": 5,
        "13:55": 6,
        "14:55": 7,
        "16:00": 8,
        "17:00": 9
    };
    function initCell(elem, val) {
        for (var i = 0; i < val; i++) {
            elem = elem.nextSibling;
            elem.removeChild(elem.childNodes[1]);
        }
    }
    function format(m) {
        var tab1 = m.split(':');
        return tab1[0] + ':' + tab1[1];
    }
    function durer(t1, t2) {
        var tab1 = t1.split(':'), tab2 = t2.split(':'),
                h1 = parseInt(tab1[0]), m1 = parseInt(tab1[1]),
                h2 = parseInt(tab2[0]), m2 = parseInt(tab2[1]), m, h;
        if (m1 > m2) {
            m2 = m2 + 60;
            h2--;
        }
        m = m2 - m1;
        h = h2 - h1;
        return (h > 0) ? (m > 30) ? ++h : h : 1;
    }
    function addMat(mat, jor, intdeb, intfin) {
        var i = heur[format(intdeb)], j = jor, dure = durer(intdeb, intfin);
        var table = document.querySelectorAll("#table_corp tr");
        if (dure > 1 && !table.item(i).childNodes[j].hasAttribute("rowspan") && (10 - (i + 1)) > dure) {
            initCell(table.item(i), dure - 1);
            table.item(i).childNodes[j].setAttribute("rowspan", dure);
        }
        table.item(i).childNodes[j].innerHTML = mat;
    }
    function spanHeure(heurdeb, heurfin, i) {
        heurdeb = heurdeb.split(':'); heurfin = heurfin.split(':');
        document.querySelectorAll(".apercu-emplois tbody tr")[i].firstChild.innerHTML = "<span class='heu'><label class='el1'>" + heurdeb[0] + "<sup>"+ heurdeb[1] +"</sup></label><label class='el2'>" + heurfin[0] + "<sup>"+ heurfin[1] +"</sup></label></span>";
    }
    function spanMat(mat, prof, salle) {
        return"<span class='mat'><label class='el1'>" + mat + "</label><label class='el2'>" + prof + "</label></span>";
    }

    function addElement(mat, prof, salle, jour, hdeb, hfin) {
        mat = spanMat(mat, prof, salle);
        addMat(mat, jour, hdeb, hfin);
    }


</script>
<table class="apercu-emplois">
    <thead><th></th><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th><th>Samedi</th></thead>
<tbody id="table_corp">
    <?php
    for ($i = 0; $i < count($heure_de_cours); $i++) {
        echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
    }
    ?>
</tbody>
</table>

<?php
for ($i = 0; $i < count($heure_de_cours); $i++) {
    echo "<script>spanHeure('" . $heure_de_cours[$i][0] . "','" . $heure_de_cours[$i][1] . "', $i);</script>";
}
for ($i = 0; $i < count($enseignements); $i++) {
    echo "<script>addElement(\"" . $enseignements[$i]["LIBELLE"] . "\",\"" . $enseignements[$i]["CIVILITE"]." ".$enseignements[$i]["NOM"]."<br/>".$enseignements[$i]['PRENOM'] . "\",\"" . $idselect . "\"," . $enseignements[$i]["JOUR"] . ",\"" . $enseignements[$i]["HEUREDEBUT"] . "\",\"" . $enseignements[$i]["HEUREFIN"] . "\");</script>";
}
    

//var_dump($enseignements);
        
   