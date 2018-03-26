$(function () {
    jQuery.extend(jQuery.validator.messages, {
        minlength: jQuery.validator.format("{0} characters min")
    });
});
