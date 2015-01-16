/**
 * plugin de validação do Digits usada no jQuery.validator
 *
 * @author pedro151
 */

jQuery.validator.addMethod("Digits", function (value, element) {
    var expReg = /^[0-9]+$/;

    if (value.match(expReg))
        return true;
    return false;
}, "deve conter apenas dígitos"); // Mensagem
// padrão
