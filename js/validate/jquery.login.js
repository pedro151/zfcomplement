/**
 * plugin de validação do LOGIN usada no jQuery.validator
 *
 * @author pedro151
 */

jQuery.validator.addMethod("login", function (value, element) {
    var expReg = /^[A-Z0-9\.]+$/;

    if (value.match(expReg))
        return true;
    return false;
}, "Informe um Login valido"); // Mensagem
// padrão
