/**
 * plugin de validação do Alnum usada no jQuery.validator
 *
 * @author pedro151
 */

jQuery.validator.addMethod("Alnum", function (value, element) {
    var expReg = /^[0-9A-z]+$/;

    if (value.match(expReg))
        return true;
    return false;
}, "contém caracteres que não são alfabéticos e nem dígito"); // Mensagem
// padrão
