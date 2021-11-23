function fieldReq(field) {
    $('#'+field).addClass('is-invalid');
    $('#'+field).focus();
}

function onInput(field) {
    $('#'+field).on('input',function(){
        $(this).removeClass('is-invalid');
    });
}

