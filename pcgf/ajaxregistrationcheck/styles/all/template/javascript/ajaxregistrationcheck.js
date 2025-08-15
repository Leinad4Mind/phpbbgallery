var pcgfAJAXRegistrationCheckUsername = $('#pcgf-ajaxregistrationcheck-username');
var pcgfAJAXRegistrationCheckEMail = $('#pcgf-ajaxregistrationcheck-email');
var pcgfAJAXRegistrationCheckPassword = $('#pcgf-ajaxregistrationcheck-password');
var pcgfAJAXRegistrationCheckConfirmPassword = $('#pcgf-ajaxregistrationcheck-confirm-password');

pcgfAJAXRegistrationCheckEMailRule = new RegExp(pcgfAJAXRegistrationCheckEMailRule, 'i');
pcgfAJAXRegistrationCheckUsernameRule = new RegExp(pcgfAJAXRegistrationCheckUsernameRule, 'i');

function setInvalid(message, messageField, field) {
    messageField.removeClass('valid').addClass('invalid');
    messageField.html(message);
    field.get(0).setCustomValidity(message);
}

function setValid(message, messageField, field) {
    messageField.removeClass('invalid').addClass('valid');
    messageField.html(message);
    field.get(0).setCustomValidity('');
}

function setLoading(message, messageField, field) {
    messageField.removeClass('invalid').removeClass('valid');
    messageField.html('<div class="loading-circle"><div class="circle1 circle"></div><div class="circle2 circle"></div><div class="circle3 circle"></div><div class="circle4 circle"></div><div class="circle5 circle"></div><div class="circle6 circle"></div><div class="circle7 circle"></div><div class="circle8 circle"></div><div class="circle9 circle"></div><div class="circle10 circle"></div><div class="circle11 circle"></div><div class="circle12 circle"></div></div>&nbsp;&nbsp;&nbsp;' + message);
    field.get(0).setCustomValidity('');
}

$(document).ready(function() {
    var passwordField = $('#new_password');
    var passwordConfirmationField = $('#password_confirm');
    pcgfAJAXRegistrationCheckConfirmPassword.insertAfter(passwordConfirmationField);
    passwordConfirmationField.on('keyup', function() {
        if ($(this).val() === passwordField.val()) {
            // The given passwords match
            setValid(pcgfAJAXRegistrationCheckConfirmPasswordValid, pcgfAJAXRegistrationCheckConfirmPassword, $(this));
        } else {
            // The given passwords don't match
            setInvalid(pcgfAJAXRegistrationCheckConfirmPasswordInvalid, pcgfAJAXRegistrationCheckConfirmPassword, $(this));
        }
    });
    passwordConfirmationField.trigger('keyup');
    pcgfAJAXRegistrationCheckPassword.insertAfter(passwordField);
    passwordField.on('keyup', function() {
        passwordConfirmationField.trigger('keyup');
        var value = $(this).val();
        var containsLowerCase = value.match(/[a-z]/g);
        var containsUpperCase = value.match(/[A-Z]/g);
        var containsNumber = value.match(/[0-9]/g);
        var containsSymbol = value.match(/[^a-zA-Z0-9]/g);
        var valid = false;
        if (value.length < pcgfAJAXRegistrationCheckPasswordMin || value.length > pcgfAJAXRegistrationCheckPasswordMax) {
            // The password is too short or too long
            setInvalid(pcgfAJAXRegistrationCheckPasswordInvalid, pcgfAJAXRegistrationCheckPassword, $(this));
        } else {
            if (pcgfAJAXRegistrationCheckPasswordRule <= 0) {
                // The password is allowed because it has no matching rules
                valid = true;
            } else if (containsLowerCase && containsUpperCase) {
                if (pcgfAJAXRegistrationCheckPasswordRule <= 10) {
                    // The password contains all needed characters
                    valid = true;
                } else if (containsNumber) {
                    if (pcgfAJAXRegistrationCheckPasswordRule <= 100) {
                        // The password contains all needed characters
                        valid = true;
                    } else if (containsSymbol) {
                        // The password contains all needed characters
                        valid = true;
                    } else {
                        // The password is incorrect because it has to contain at least also a symbol
                        setInvalid(pcgfAJAXRegistrationCheckPasswordInvalid, pcgfAJAXRegistrationCheckPassword, $(this));
                    }
                } else {
                    // The password is incorrect because it has to contain at least also a number
                    setInvalid(pcgfAJAXRegistrationCheckPasswordInvalid, pcgfAJAXRegistrationCheckPassword, $(this));
                }
            } else {
                // The password is incorrect because it has to contain at least upper and lower case characters
                setInvalid(pcgfAJAXRegistrationCheckPasswordInvalid, pcgfAJAXRegistrationCheckPassword, $(this));
            }
        }
        if (valid) {
            var percentage = 0;
            // Check password strength
            if (containsLowerCase) {
                // Password should contain at least 5 lower case characters
                percentage += (containsLowerCase.length > 5 ? 5 : containsLowerCase.length) * 5;
            }
            if (containsUpperCase) {
                // Password should contain at least 3 upper case characters
                percentage += (containsUpperCase.length > 3 ? 3 : containsUpperCase.length) * 7;
            }
            if (containsNumber) {
                // Password should contain at least 2 numbers
                percentage += (containsNumber.length > 2 ? 2 : containsNumber.length) * 10;
            }
            if (containsSymbol) {
                // Password should contain at least 2 symbols
                percentage += (containsSymbol.length > 2 ? 2 : containsSymbol.length) * 14;
            }
            if ((usernameField.val() === '' || value.indexOf(usernameField.val()) < 0) && (eMailField.val() === '' || value.indexOf(eMailField.val()) < 0)) {
                // Password should not contain username or E-Mail address
                percentage += 6;
            }
            if (pcgfAJAXRegistrationCheckPassword.hasClass('invalid')) {
                pcgfAJAXRegistrationCheckPassword.removeClass('invalid').addClass('password-strength');
                var securityHTML = '<span>' + pcgfAJAXRegistrationCheckPasswordStrength + '</span>';
                securityHTML += '<div class="progressbar"><div id="pcgf-ajaxregistrationcheck-security">&nbsp;</div></div>';
                securityHTML += '<span id="pcgf-ajaxregistrationcheck-strength"></span>';
                pcgfAJAXRegistrationCheckPassword.html(securityHTML);
            }
            // Set password status
            $(this).get(0).setCustomValidity('');
            var securityPB = $('#pcgf-ajaxregistrationcheck-security');
            var strengthText = $('#pcgf-ajaxregistrationcheck-strength');
            securityPB.stop().animate({width: percentage + '%', overflow: 'overflow'}, 800);
            if (percentage >= 95) {
                strengthText.html(pcgfAJAXRegistrationCheckPasswordVeryStrong);
                securityPB.removeClass().addClass('very-strong');
            } else if (percentage >= 85) {
                strengthText.html(pcgfAJAXRegistrationCheckPasswordStrong);
                securityPB.removeClass().addClass('strong');
            } else if (percentage >= 60) {
                strengthText.html(pcgfAJAXRegistrationCheckPasswordNormal);
                securityPB.removeClass().addClass('normal');
            } else if (percentage >= 45) {
                strengthText.html(pcgfAJAXRegistrationCheckPasswordWeak);
                securityPB.removeClass().addClass('weak');
            } else {
                strengthText.html(pcgfAJAXRegistrationCheckPasswordVeryWeak);
                securityPB.removeClass().addClass('very-weak');
            }
        } else {
            pcgfAJAXRegistrationCheckPassword.removeClass('password-strength');
        }
    });
    passwordField.trigger('keyup');
    var usernameField = $('#username');
    pcgfAJAXRegistrationCheckUsername.insertAfter(usernameField);
    usernameField.on('keyup', function() {
        passwordField.trigger('keyup');
        var value = $(this).val();
        if (value.length < pcgfAJAXRegistrationCheckUsernameMin || value.length > pcgfAJAXRegistrationCheckUsernameMax || value.match(pcgfAJAXRegistrationCheckUsernameRule) === null) {
            // Username doesn't match the naming guidelines
            setInvalid(pcgfAJAXRegistrationCheckUsernameInvalidBoundaries, pcgfAJAXRegistrationCheckUsername, $(this));
        } else {
            // Check username online
            setLoading(pcgfAJAXRegistrationCheckLoading, pcgfAJAXRegistrationCheckUsername, $(this));
            $.ajax({
                url: pcgfAJAXRegistrationCheckUsernameCheckLink,
                type: 'POST',
                data: {'search': value},
                success: function(result) {
                    if (result[0] === 'OK') {
                        // Username is allowed
                        setValid(result[1], pcgfAJAXRegistrationCheckUsername, usernameField);
                    } else if (result[0] === 'INVALID QUERY') {
                        // The query was invalid
                        setLoading(result[1], pcgfAJAXRegistrationCheckUsername, usernameField);
                    } else {
                        // Username not allowed for any reason
                        setInvalid(result[1], pcgfAJAXRegistrationCheckUsername, usernameField);
                    }
                }
            });
        }
    });
    usernameField.trigger('keyup');
    var eMailField = $('#email');
    pcgfAJAXRegistrationCheckEMail.insertAfter(eMailField);
    eMailField.on('keyup', function() {
        passwordField.trigger('keyup');
        var value = $(this).val();
        if (value.match(pcgfAJAXRegistrationCheckEMailRule) === null) {
            // The input is not a valid E-Mail address
            setInvalid(pcgfAJAXRegistrationCheckEMailInvalid, pcgfAJAXRegistrationCheckEMail, $(this));
        } else {
            setLoading(pcgfAJAXRegistrationCheckLoading, pcgfAJAXRegistrationCheckEMail, $(this));
            $.ajax({
                url: pcgfAJAXRegistrationCheckEMailCheckLink,
                type: 'POST',
                data: {'search': value},
                success: function(result) {
                    if (result[0] === 'OK') {
                        // The E-Mail address is allowed
                        setValid(result[1], pcgfAJAXRegistrationCheckEMail, eMailField);
                    } else if (result[0] === 'INVALID QUERY') {
                        // The query was invalid
                        setLoading(result[1], pcgfAJAXRegistrationCheckEMail, eMailField);
                    } else {
                        // The E-Mail address is not allowed for any reason
                        setInvalid(result[1], pcgfAJAXRegistrationCheckEMail, eMailField);
                    }
                }
            });
        }
    });
    eMailField.trigger('keyup');
});