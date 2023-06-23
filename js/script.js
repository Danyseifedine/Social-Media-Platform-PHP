function ChangeMode() {
    let body = document.body;
    let button = document.getElementById("modeButton");
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
        button.innerHTML = '<i class="bi bi-moon fs-4" id="icon">';
        localStorage.setItem("mode", "dark");
    } else {
        button.innerHTML = '<i class="bi bi-sun"></i> ';
        localStorage.setItem("mode", "light");
    }
}

let savedmode = localStorage.getItem("mode");
if (savedmode === "dark") {
    document.body.classList.add("dark");
    document.getElementById("modeButton").innerHTML = '<i class="bi bi-moon fs-4" id="icon">';
} else {
    document.body.classList.remove("dark");
    document.getElementById("modeButton").innerHTML = '<i class="bi bi-sun"></i> ';
}



