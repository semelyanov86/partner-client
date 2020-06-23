$(document).ready(function(){
    $(".masked-phone").mask("+7 (000) 000-0000",  {placeholder: "+7 (___) ___-____"});
    $(":file").filestyle({
        text: 'Выбрать',
        btnClass: "btn btn-info"
    });
});
