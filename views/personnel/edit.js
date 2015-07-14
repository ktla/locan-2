function submitForm() {
    if ($("input[name=nom]").val() === "" || $("input[name=portable]").val() === "") {
        alertWebix("Veuillez remplir les champs obligatoires");
        addRequiredFields([$("input[name=nom]"), $("input[name=portable]"), $("select[name=function]")]);
        return;
    }
    date = calendrier.getValue(), dates = date.split(' ');
    document.getElementById("datenaiss").value = dates[0];
    document.forms[0].submit();
}
