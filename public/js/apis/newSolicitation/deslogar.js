$("#deslog").on("click", function (e) {
    e.preventDefault();
    var modal = document.getElementById("myModal8");
    modal.style.display = "flex";
    modal.style.flexWrap = "wrap";
    modal.style.alignContent = "space-around";
})

function modalClose8() {
    var modal = document.getElementById("myModal8");
    modal.style.display = "none";
}
