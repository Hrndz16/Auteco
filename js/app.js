const tablaMotos = document.getElementById("tablaMotos");
const tablaCategorias = document.getElementById("tablaCategorias");

const formAgregarMoto = document.getElementById("formAgregarMoto");
const formEditarMoto = document.getElementById("formEditarMoto");
const formAgregarCategoria = document.getElementById("formAgregarCategoria");
const formEditarCategoria = document.getElementById("formEditarCategoria");

const modalVerMoto = new bootstrap.Modal(document.getElementById("modalVerMoto"));
const modalEditarMoto = new bootstrap.Modal(document.getElementById("modalEditarMoto"));
const modalEliminarMoto = new bootstrap.Modal(document.getElementById("modalEliminarMoto"));

const modalVerCategoria = new bootstrap.Modal(document.getElementById("modalVerCategoria"));
const modalEditarCategoria = new bootstrap.Modal(document.getElementById("modalEditarCategoria"));
const modalEliminarCategoria = new bootstrap.Modal(document.getElementById("modalEliminarCategoria"));

const vistaMotos = document.getElementById("vistaMotos");
const vistaCategorias = document.getElementById("vistaCategorias");
const tituloVista = document.getElementById("tituloVista");
const btnAgregarMoto = document.getElementById("btnAgregarMoto");
const btnAgregarCategoria = document.getElementById("btnAgregarCategoria");

const sidebar = document.getElementById("sidebar");
document.getElementById("abrirSidebar").addEventListener("click", () => sidebar.classList.add("mostrar"));
document.getElementById("cerrarSidebar").addEventListener("click", () => sidebar.classList.remove("mostrar"));

document.querySelectorAll(".menu-item").forEach((btn) => {
    btn.addEventListener("click", function () {
        document.querySelectorAll(".menu-item").forEach((item) => item.classList.remove("active"));
        this.classList.add("active");

        const tab = this.dataset.tab;
        if (tab === "motos") {
            vistaMotos.classList.remove("d-none");
            vistaCategorias.classList.add("d-none");
            tituloVista.textContent = "Listado de Motos";
            btnAgregarMoto.classList.remove("d-none");
            btnAgregarCategoria.classList.add("d-none");
        } else {
            vistaCategorias.classList.remove("d-none");
            vistaMotos.classList.add("d-none");
            tituloVista.textContent = "Listado de Categorías";
            btnAgregarCategoria.classList.remove("d-none");
            btnAgregarMoto.classList.add("d-none");
        }

        sidebar.classList.remove("mostrar");
    });
});

function actualizarSelectCategorias(idCategoriaSeleccionada, nombreCategoria) {
    const selects = [document.getElementById("agregarIdCategoria"), document.getElementById("editIdCategoria")];

    selects.forEach((select) => {
        if (!select) return;

        if (nombreCategoria) {
            const existe = Array.from(select.options).some((option) => Number(option.value) === Number(idCategoriaSeleccionada));
            if (!existe) {
                const option = document.createElement("option");
                option.value = idCategoriaSeleccionada;
                option.textContent = nombreCategoria;
                select.appendChild(option);
            }
        }

        Array.from(select.options).forEach((option) => {
            if (Number(option.value) === Number(idCategoriaSeleccionada) && nombreCategoria) {
                option.textContent = nombreCategoria;
            }
        });
    });
}

function removerCategoriaDeSelects(idCategoria) {
    [document.getElementById("agregarIdCategoria"), document.getElementById("editIdCategoria")].forEach((select) => {
        if (!select) return;
        const option = Array.from(select.options).find((opt) => Number(opt.value) === Number(idCategoria));
        if (option) option.remove();
    });
}

formAgregarMoto.addEventListener("submit", function (e) {
    e.preventDefault();

    fetch("ajax/agregar.php", {
        method: "POST",
        body: new FormData(this),
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo agregar la moto");
                return;
            }

            tablaMotos.insertAdjacentHTML("beforeend", data.fila);
            bootstrap.Modal.getInstance(document.getElementById("modalAgregarMoto")).hide();
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
                document.getElementById("verCategoria").textContent = moto.categoria_nombre;
                modalVerMoto.show();
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
                document.getElementById("editIdCategoria").value = moto.id_categoria;
                modalEditarMoto.show();
            });
    }

    if (e.target.classList.contains("btn-eliminar")) {
        document.getElementById("eliminarMotoId").value = id;
        modalEliminarMoto.show();
    }
});

formEditarMoto.addEventListener("submit", function (e) {
    e.preventDefault();

    fetch("ajax/editar.php", {
        method: "POST",
        body: new FormData(this),
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
                fila.children[4].textContent = moto.categoria_nombre;
                fila.children[4].dataset.idCategoria = moto.id_categoria;
            }

            modalEditarMoto.hide();
        });
});

document.getElementById("confirmarEliminarMoto").addEventListener("click", function () {
    const datos = new FormData();
    datos.append("id", document.getElementById("eliminarMotoId").value);

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
            modalEliminarMoto.hide();
        });
});

formAgregarCategoria.addEventListener("submit", function (e) {
    e.preventDefault();

    fetch("ajax/agregar_categoria.php", {
        method: "POST",
        body: new FormData(this),
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo agregar la categoría");
                return;
            }

            tablaCategorias.insertAdjacentHTML("beforeend", data.fila);
            actualizarSelectCategorias(data.categoria.id_categoria, data.categoria.nombre);
            bootstrap.Modal.getInstance(document.getElementById("modalAgregarCategoria")).hide();
            this.reset();
        });
});

tablaCategorias.addEventListener("click", function (e) {
    const id = e.target.dataset.id;
    if (!id) return;

    if (e.target.classList.contains("btn-ver-categoria")) {
        fetch(`ajax/obtener_categoria.php?id=${id}`)
            .then((res) => res.json())
            .then((data) => {
                if (!data.ok) {
                    alert(data.mensaje || "No se pudo cargar la categoría");
                    return;
                }

                document.getElementById("verCategoriaId").textContent = data.categoria.id_categoria;
                document.getElementById("verCategoriaNombre").textContent = data.categoria.nombre;
                modalVerCategoria.show();
            });
    }

    if (e.target.classList.contains("btn-editar-categoria")) {
        fetch(`ajax/obtener_categoria.php?id=${id}`)
            .then((res) => res.json())
            .then((data) => {
                if (!data.ok) {
                    alert(data.mensaje || "No se pudo cargar la categoría");
                    return;
                }

                document.getElementById("editCategoriaId").value = data.categoria.id_categoria;
                document.getElementById("editCategoriaNombre").value = data.categoria.nombre;
                modalEditarCategoria.show();
            });
    }

    if (e.target.classList.contains("btn-eliminar-categoria")) {
        document.getElementById("eliminarCategoriaId").value = id;
        modalEliminarCategoria.show();
    }
});

formEditarCategoria.addEventListener("submit", function (e) {
    e.preventDefault();

    fetch("ajax/editar_categoria.php", {
        method: "POST",
        body: new FormData(this),
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo actualizar la categoría");
                return;
            }

            const categoria = data.categoria;
            const fila = document.getElementById(`categoria-${categoria.id_categoria}`);
            if (fila) {
                fila.children[1].textContent = categoria.nombre;
            }

            document.querySelectorAll("#tablaMotos tr").forEach((filaMoto) => {
                const celdaCategoria = filaMoto.children[4];
                if (!celdaCategoria) return;
                if (Number(celdaCategoria.dataset.idCategoria) === Number(categoria.id_categoria)) {
                    celdaCategoria.textContent = categoria.nombre;
                }
            });

            actualizarSelectCategorias(categoria.id_categoria, categoria.nombre);
            modalEditarCategoria.hide();
        });
});

document.getElementById("confirmarEliminarCategoria").addEventListener("click", function () {
    const datos = new FormData();
    datos.append("id_categoria", document.getElementById("eliminarCategoriaId").value);

    fetch("ajax/eliminar_categoria.php", {
        method: "POST",
        body: datos,
    })
        .then((res) => res.json())
        .then((data) => {
            if (!data.ok) {
                alert(data.mensaje || "No se pudo eliminar la categoría");
                return;
            }

            const fila = document.getElementById(`categoria-${data.id_categoria}`);
            if (fila) fila.remove();
            removerCategoriaDeSelects(data.id_categoria);
            modalEliminarCategoria.hide();
        });
});
