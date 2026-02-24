document.getElementById("formAgregar").addEventListener("submit", function (e) {
    e.preventDefault();

    const datos = new FormData(this);

    fetch("ajax/agregar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            document.getElementById("tablaMotos").insertAdjacentHTML("beforeend", data.fila);
            bootstrap.Modal.getInstance(document.getElementById("modalAgregar")).hide();
            this.reset();
        }
    });
});