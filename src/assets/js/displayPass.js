function showAndHidePass() {
    let pass = document.getElementById("Password");
    let [open,close] = document.querySelectorAll(".open-eye,.close-eye");
    if(pass.type === "password") {
        pass.type = "text";
        open.style.display="none";
        close.style.display="inline-block";
    } else {
        pass.type = "password";
        open.style.display="inline-block";
        close.style.display="none";
    }
}