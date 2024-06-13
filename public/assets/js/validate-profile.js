$(document).ready(function () {
    $("#updateForm").on("submit", function (e) {

        let isValid = true;
        let name = $("#Name").val().trim();
        let email = $("#Email").val().trim();
        let retrieved_email = $("#Retrieved_Email").val().trim();
        let mobile_number = $("#Mobile_Number").val().trim();
        let dob = $("#Date_of_Birth").val().trim();
        let town_or_city = $("#Town_or_City").val().trim();
        let country = $("#Country").val().trim();
        let regName = /^[a-zA-Z\s'-]{1,100}$/;
        let regEmail = /^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let regMobNo = /^\d{10,15}$/;
        let regDOB = /^\d{2}-\d{2}-\d{4}$/;
        let regTownOrCity = /^[a-zA-Z\s\.'-]{2,50}$/;
        let regCountry = /^[a-zA-Z\s\.'-]{2,50}$/;
        let errorWrap = $(".clientSide");

        if (name == "" && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Name is required.";
        }

        if (name.length > 100 && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Name should be less than 100 characters.";
        }

        if (!(regName.test(name)) && isValid) {
            isValid = false;
            errorWrap.css("display", "block");
            errorWrap[0].childNodes[2].nodeValue = ": Name should only have alphabetic characters, spaces, hyphens, and apostrophes.";
        }

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
            if(email!=retrieved_email){
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
        }

        if (mobile_number != "" && isValid){
            if (!(regMobNo.test(mobile_number)) && isValid) {
                isValid = false;
                errorWrap.css("display", "block");
                errorWrap[0].childNodes[2].nodeValue = ": Mobile number must be numeric and between 10-15 digits.";
            }
        }

        if (dob != "" && isValid){
            if (!(regDOB.test(dob)) && isValid) {
                isValid = false;
                errorWrap.css("display", "block");
                errorWrap[0].childNodes[2].nodeValue = ": Date of birth must be in DD-MM-YYYY format.";
            }
        }

        if (town_or_city != "" && isValid){
            if ((town_or_city.length < 2 || town_or_city.length > 50) && isValid) {
                isValid = false;
                errorWrap.css("display", "block");
                errorWrap[0].childNodes[2].nodeValue = ": Town/City must be between 2-50 characters.";
            }

            if (!(regTownOrCity.test(town_or_city)) && isValid) {
                isValid = false;
                errorWrap.css("display", "block");
                errorWrap[0].childNodes[2].nodeValue = ": Town/City format is invalid.";
            }
        }

        if (country != "" && isValid){
            if ((country.length < 2 || country.length > 50) && isValid) {
                isValid = false;
                errorWrap.css("display", "block");
                errorWrap[0].childNodes[2].nodeValue = ": Country must be between 2-50 characters.";
            }

            if (!(regCountry.test(country)) && isValid) {
                isValid = false;
                errorWrap.css("display", "block");
                errorWrap[0].childNodes[2].nodeValue = ": Country format is invalid.";
            }
        }

        if (isValid) {
            errorWrap.css("display", "none");
            errorWrap[0].childNodes[2].nodeValue = "";
            $("#updateForm").attr('action', '');
        }
    });
});