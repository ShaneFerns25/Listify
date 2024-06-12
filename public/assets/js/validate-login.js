$(document).ready(function () {
    $("#loginForm").on("submit", function (e) {

        let isValid = true;
        let email = $("#Email").val().trim();
        let password = $("#Password").val();
        let regEmail = /^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let regPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,128}$/;
        let errorWrap = $(".clientSide");

        if (email == "" && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Email is required.";
        }

        if ((email.length < 6 || email.length > 254) && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Email should be between 6-254 characters.";
        }

        if (!(regEmail.test(email)) && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Please enter a valid Email";
        }
        
        if (regEmail.test(email) && isValid){
            $.ajax({
                url: "/Listify/email-availability",
                type: 'post',
                dataType: "json",
                data: { Email: email},
                success: function(response) {
                    console.log(response);
                    if (response.status=="error"){
                        isValid = false;
                        errorWrap.css("display", "block");
                        errorWrap[0].childNodes[2].nodeValue = `: ${response.message}`;
                    }
                },
                error: function(error) {
                    console.error(error.responseJSON);
                    isValid = false;
                    errorWrap.css("display", "block");
                    errorWrap[0].childNodes[2].nodeValue = `: ${error.responseJSON.message}`;
                }
            });
        }

        if (password == "" && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Password is required.";
        }

        if ((password.length < 8 || password.length > 128) && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Password should be between 8-128 characters.";
        }

        if (!(regPass.test(password)) && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Password should include an uppercase letter, a lowercase letter, a digit, and a special character.";
        }

        if (isValid) {
            errorWrap.css("display", "none");
            errorWrap[0].childNodes[2].nodeValue = "";
            $("#loginForm").attr('action', '');
        }
    });
});