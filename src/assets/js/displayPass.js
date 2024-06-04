const displayPass = (pass, open, close) => {
    if (pass.type === "password") {
        pass.type = "text";
        open.style.display = "none";
        close.style.display = "inline-block";
    } else {
        pass.type = "password";
        open.style.display = "inline-block";
        close.style.display = "none";
    }
}

function showAndHidePass() {
    let pass = document.getElementById("Password");
    let [open, close] = document.querySelectorAll(".open-eye,.close-eye");
    displayPass(pass, open, close);
}

function showAndHidePass2() {
    let pass = document.getElementById("ConfirmPass");
    let [open, close] = document.querySelectorAll(".open-eye2,.close-eye2");
    displayPass(pass, open, close);
}

window.onload = () => {
    let icons = document.getElementsByTagName("i");
    if (icons.length==2) {
        [icons[0].style.fontSize, icons[1].style.fontSize] = ["19px", "19px"];
    }
    else {
        for (let i in icons){
            icons[i].style.fontSize = "19px";
        }
    }
}