$(function () {
    var form = $("#registration_form").show();

    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex > newIndex) {
                return true;
            }
            form.validate().settings.ignore = ':disabled, :hidden';
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ':disabled';
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            alert("Submitted");
        }
    }).validate({
        errorPlacement: function errorPlacement (error, element) {
            element.before(error);
        },
        rules: {
            fname: {
                required: true,
                minlength: 2
            // },
            // mname: {
            //     required: true,
            //     minlength: 2
            // },
            // lname: {
            //     required: true,
            //     minlength: 2
            // },
            // weight: {
            //     required: true,
            //     number: true
            // },
            // height: {
            //     required: true,
            //     number: true
            // },
            // email: {
            //     required: true,
            //     email: true
            // },
            // birthdate: {
            //     required: true,
            //     date: true
            // },
            // gender: {
            //     required: true
            // },
            // cellnumber: {
            //     required: true,
            //     digits: true
            // },
            // ename: {
            //     required: true,
            //     minlength: 8
            // },
            // econtact: {
            //     required: true,
            //     digits: true
            // },
            // relationship: {
            //     required: true
            }
        }
    });
});
