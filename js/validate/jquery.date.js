/**
 * plugin de validação do Date usada no jQuery.validator
 *
 * @author pedro151
 */


jQuery.validator.addMethod("Date", function (value, element) {
    var expReg = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;

    if (value.match(expReg))
        return true;
    return false;
}, "Informe uma data válida"); // Mensagem
// padrão