
$(function(){
    $('.modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});



$( "#signupform-type" ).change(function() {
    checkSelect("#signupform-type", ".field-signupform-doctor");
});
checkSelect("#signupform-type", ".field-signupform-doctor");



function checkSelect(idSelect, classNameSelect){
    if($( idSelect ).find("option:selected" ).text() == "Patient")
    {
        $(classNameSelect).css({'display': 'block'})
    }
    else
    {
        $(classNameSelect).css({'display': 'none'})
    }
}


