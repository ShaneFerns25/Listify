function hideAndShowNavbar(event) {
    let listIcon, closeIcon;
    let sidebar = document.getElementById("sidebar");
    let main = document.querySelector(".main-inner");

    if (event.target.attributes[0].value == "nav-list-icon") {
        [listIcon, closeIcon] = [event.target, event.target.nextElementSibling];

        listIcon.style.clipPath = "circle(0%)";
        setTimeout(() => {
            listIcon.style.display = "none";
            closeIcon.style.display = "inline-flex";
            sidebar.style.transform = "translateX(0px)";
            main.style.transform = "translateX(0px)";
        }, 2000);
        setTimeout(() => {
            closeIcon.style.clipPath = "circle(150%)";
        }, 3000);
    } else {
        [closeIcon, listIcon] = [event.target, event.target.previousElementSibling];

        closeIcon.style.clipPath = "circle(0%)";
        setTimeout(() => {
            closeIcon.style.display = "none";
            listIcon.style.display = "inline-flex";
            sidebar.style.transform = "translateX(-300px)";
            main.style.transform = "translateX(-220px)";
        }, 1500);
        setTimeout(() => {
            listIcon.style.clipPath = "circle(150%)";
        }, 3000);
    }
}
