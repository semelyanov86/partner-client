$(document).ready(function(){
    $("#phone").mask("+7 (000) 000-0000", {placeholder: "+7 (___) ___-____"});

    function makePasswd() {
        var passwd = '';
        var chars = '0123456789abcdefghijklmnopqrstuvwxyz0123456789';
        for (i=1;i<8;i++) {
            var c = Math.floor(Math.random()*chars.length + 1);
            passwd += chars.charAt(c)
        }
        return passwd;
    };

    $(document).on('click','#generate-password',function(e) {
        let pass = makePasswd();
        $('#password').val(pass);
        $('#password-confirm').val(pass);
        return false;
    });
});


