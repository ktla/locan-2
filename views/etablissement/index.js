$(document).ready(function() {
   $("#persoTable").DataTable({
      "columns": [
          {"width": "5%"},
          null,
          null,
          {"width": "5%"},
          {"width": "7%"}
      ] 
   });
   $("#eleveTable").DataTable({
        "columns": [
          {"width": "7%"},
          null,
          null,
          {"width": "3%"},
          {"width": "5%"},
          {"width": "7%"}
      ] 
   });
});
function imprimer(){
    if($("select[name=code_impression]").val() === ""){
        return;
    }
    var frm = $("<form>", {
        action: "./etablissement/imprimer", 
        target: "_blank", 
        method: "post"
    }).append($("<input>", {
        name: "code",
        type: "hidden",
        value: $("select[name=code_impression]").val()
    })).appendTo("body");
   frm.submit();
}
