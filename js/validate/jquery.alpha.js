/**
 * plugin de validação do Alnum usada no jQuery.validator
 *
 * @author pedro151
 */

jQuery.validator.addMethod("Alpha", function (value, element) {
    var expReg = /^[A-Za-zÀ-ú]+$/;

    if (value.match(expReg))
        return true;
    return false;
}, "contém caracteres que não são alfabéticos e nem dígito"); // Mensagem
// padrão
