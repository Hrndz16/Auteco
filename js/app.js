const tablaMotos = document.getElementById("tablaMotos");
const formAgregar = document.getElementById("formAgregar");
const formEditar = document.getElementById("formEditar");

const modalVer = new bootstrap.Modal(document.getElementById("modalVer"));
const modalEditar = new bootstrap.Modal(document.getElementById("modalEditar"));
const modalEliminar = new bootstrap.Modal(document.getElementById("modalEliminar"));

formAgregar.addEventListener("submit", function (e) {
    e.preventDefault();

    const datos = new FormData(this);

    fetch("ajax/agregar.php", {
        method: "POST",
        body: datos,
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo agregar la moto");
                return;
            }

            tablaMotos.insertAdjacentHTML("beforeend", data.fila);
            bootstrap.Modal.getInstance(document.getElementById("modalAgregar")).hide();
            this.reset();
        });
});

tablaMotos.addEventListener("click", function (e) {
    const id = e.target.dataset.id;
    if (!id) return;

    if (e.target.classList.contains("btn-ver")) {
        fetch(`ajax/obtener.php?id=${id}`)
            .then((res) => res.json())
            .then((data) => {
                if (!data.ok) {
                    alert(data.mensaje || "No se pudo cargar el detalle");
                    return;
                }

                const moto = data.moto;
                document.getElementById("verId").textContent = moto.id;
                document.getElementById("verMarca").textContent = moto.marca;
                document.getElementById("verModelo").textContent = moto.modelo;
                document.getElementById("verPrecio").textContent = moto.precio;
                modalVer.show();
            });
    }

    if (e.target.classList.contains("btn-editar")) {
        fetch(`ajax/obtener.php?id=${id}`)
            .then((res) => res.json())
            .then((data) => {
                if (!data.ok) {
                    alert(data.mensaje || "No se pudo cargar la moto");
                    return;
                }

                const moto = data.moto;
                document.getElementById("editId").value = moto.id;
                document.getElementById("editMarca").value = moto.marca;
                document.getElementById("editModelo").value = moto.modelo;
                document.getElementById("editPrecio").value = moto.precio;
                modalEditar.show();
            });
    }

    if (e.target.classList.contains("btn-eliminar")) {
        document.getElementById("eliminarId").value = id;
        modalEliminar.show();
    }
});

formEditar.addEventListener("submit", function (e) {
    e.preventDefault();

    const datos = new FormData(this);

    fetch("ajax/editar.php", {
        method: "POST",
        body: datos,
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo actualizar");
                return;
            }

            const moto = data.moto;
            const fila = document.getElementById(`moto-${moto.id}`);
            if (fila) {
                fila.children[1].textContent = moto.marca;
                fila.children[2].textContent = moto.modelo;
                fila.children[3].textContent = moto.precio;
            }

            modalEditar.hide();
        });
});

document.getElementById("confirmarEliminar").addEventListener("click", function () {
    const id = document.getElementById("eliminarId").value;

    const datos = new FormData();
    datos.append("id", id);

    fetch("ajax/eliminar.php", {
        method: "POST",
        body: datos,
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo eliminar");
                return;
            }

            const fila = document.getElementById(`moto-${data.id}`);
            if (fila) fila.remove();
            modalEliminar.hide();
        });
});
