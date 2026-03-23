const tablaMotos = document.getElementById("tablaMotos");
const tablaCategorias = document.getElementById("tablaCategorias");

const formAgregarMoto = document.getElementById("formAgregarMoto");
const formEditarMoto = document.getElementById("formEditarMoto");
const formAgregarCategoria = document.getElementById("formAgregarCategoria");
const formEditarCategoria = document.getElementById("formEditarCategoria");

// Se inicializan una sola vez para reutilizar los mismos modales durante toda la sesion.
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

function crearTablaPaginada({ tbody, buscador, paginacion, pageSize = 5 }) {
    const estado = { termino: "", paginaActual: 1 };

    function filtrarFilas() {
        return Array.from(tbody.querySelectorAll("tr")).filter((fila) => fila.textContent.toLowerCase().includes(estado.termino));
    }

    function renderPaginacion(totalPaginas) {
        paginacion.innerHTML = "";
        if (totalPaginas <= 0) return;

        const info = document.createElement("span");
        info.className = "page-info";
        info.textContent = `Pagina ${estado.paginaActual} de ${totalPaginas}`;

        const btnAnterior = document.createElement("button");
        btnAnterior.className = "btn btn-sm btn-outline-secondary";
        btnAnterior.textContent = "Anterior";
        btnAnterior.disabled = estado.paginaActual === 1;
        btnAnterior.addEventListener("click", () => {
            estado.paginaActual -= 1;
            render();
        });

        const btnSiguiente = document.createElement("button");
        btnSiguiente.className = "btn btn-sm btn-outline-secondary";
        btnSiguiente.textContent = "Siguiente";
        btnSiguiente.disabled = estado.paginaActual >= totalPaginas;
        btnSiguiente.addEventListener("click", () => {
            estado.paginaActual += 1;
            render();
        });

        paginacion.append(info, btnAnterior, btnSiguiente);
    }

    // La tabla se recalcula completa cada vez para mantener paginacion y filtro sincronizados.
    function render() {
        const filas = filtrarFilas();
        const totalPaginas = Math.ceil(filas.length / pageSize);

        if (totalPaginas === 0) {
            estado.paginaActual = 1;
        } else if (estado.paginaActual > totalPaginas) {
            estado.paginaActual = totalPaginas;
        }

        const inicio = (estado.paginaActual - 1) * pageSize;
        const fin = inicio + pageSize;
        const filasPagina = filas.slice(inicio, fin);

        Array.from(tbody.querySelectorAll("tr")).forEach((fila) => fila.classList.add("d-none"));
        filasPagina.forEach((fila) => fila.classList.remove("d-none"));

        renderPaginacion(totalPaginas);
    }

    buscador.addEventListener("input", () => {
        estado.termino = buscador.value.trim().toLowerCase();
        estado.paginaActual = 1;
        render();
    });

    return { render };
}

const tablaMotosControl = crearTablaPaginada({
    tbody: tablaMotos,
    buscador: document.getElementById("buscarMotos"),
    paginacion: document.getElementById("paginacionMotos"),
});

const tablaCategoriasControl = crearTablaPaginada({
    tbody: tablaCategorias,
    buscador: document.getElementById("buscarCategorias"),
    paginacion: document.getElementById("paginacionCategorias"),
});

tablaMotosControl.render();
tablaCategoriasControl.render();

document.querySelectorAll(".menu-item").forEach((btn) => {
    btn.addEventListener("click", function () {
        document.querySelectorAll(".menu-item").forEach((item) => item.classList.remove("active"));
        this.classList.add("active");

        const tab = this.dataset.tab;
        const mostrandoMotos = tab === "motos";

        vistaMotos.classList.toggle("d-none", !mostrandoMotos);
        vistaCategorias.classList.toggle("d-none", mostrandoMotos);
        tituloVista.textContent = mostrandoMotos ? "Listado de Motos" : "Listado de Categorias";
        btnAgregarMoto.classList.toggle("d-none", !mostrandoMotos);
        btnAgregarCategoria.classList.toggle("d-none", mostrandoMotos);

        if (mostrandoMotos) {
            tablaMotosControl.render();
        } else {
            tablaCategoriasControl.render();
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

async function enviarFormulario(url, formulario) {
    const respuesta = await fetch(url, {
        method: "POST",
        body: new FormData(formulario),
    });

    return respuesta.json();
}

async function obtenerJson(url) {
    const respuesta = await fetch(url);
    return respuesta.json();
}

formAgregarMoto.addEventListener("submit", async function (event) {
    event.preventDefault();

    const data = await enviarFormulario("actions/motos/agregar.php", this);
    if (!data.ok) {
        alert(data.mensaje || "No se pudo agregar la moto");
        return;
    }

    tablaMotos.insertAdjacentHTML("beforeend", data.fila);
    tablaMotosControl.render();
    bootstrap.Modal.getInstance(document.getElementById("modalAgregarMoto")).hide();
    this.reset();
});

tablaMotos.addEventListener("click", async function (event) {
    const id = event.target.dataset.id;
    if (!id) return;

    if (event.target.classList.contains("btn-ver")) {
        const data = await obtenerJson(`actions/motos/obtener.php?id=${id}`);
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
    }

    if (event.target.classList.contains("btn-editar")) {
        const data = await obtenerJson(`actions/motos/obtener.php?id=${id}`);
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
    }

    if (event.target.classList.contains("btn-eliminar")) {
        document.getElementById("eliminarMotoId").value = id;
        modalEliminarMoto.show();
    }
});

formEditarMoto.addEventListener("submit", async function (event) {
    event.preventDefault();

    const data = await enviarFormulario("actions/motos/editar.php", this);
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

    tablaMotosControl.render();
    modalEditarMoto.hide();
});

document.getElementById("confirmarEliminarMoto").addEventListener("click", async function () {
    const datos = new FormData();
    datos.append("id", document.getElementById("eliminarMotoId").value);

    const respuesta = await fetch("actions/motos/eliminar.php", {
        method: "POST",
        body: datos,
    });
    const data = await respuesta.json();

    if (!data.ok) {
        alert(data.mensaje || "No se pudo eliminar");
        return;
    }

    const fila = document.getElementById(`moto-${data.id}`);
    if (fila) fila.remove();
    tablaMotosControl.render();
    modalEliminarMoto.hide();
});

formAgregarCategoria.addEventListener("submit", async function (event) {
    event.preventDefault();

    const data = await enviarFormulario("actions/categorias/agregar.php", this);
    if (!data.ok) {
        alert(data.mensaje || "No se pudo agregar la categoria");
        return;
    }

    tablaCategorias.insertAdjacentHTML("beforeend", data.fila);
    actualizarSelectCategorias(data.categoria.id_categoria, data.categoria.nombre);
    tablaCategoriasControl.render();
    bootstrap.Modal.getInstance(document.getElementById("modalAgregarCategoria")).hide();
    this.reset();
});

tablaCategorias.addEventListener("click", async function (event) {
    const id = event.target.dataset.id;
    if (!id) return;

    if (event.target.classList.contains("btn-ver-categoria")) {
        const data = await obtenerJson(`actions/categorias/obtener.php?id=${id}`);
        if (!data.ok) {
            alert(data.mensaje || "No se pudo cargar la categoria");
            return;
        }

        document.getElementById("verCategoriaId").textContent = data.categoria.id_categoria;
        document.getElementById("verCategoriaNombre").textContent = data.categoria.nombre;
        modalVerCategoria.show();
    }

    if (event.target.classList.contains("btn-editar-categoria")) {
        const data = await obtenerJson(`actions/categorias/obtener.php?id=${id}`);
        if (!data.ok) {
            alert(data.mensaje || "No se pudo cargar la categoria");
            return;
        }

        document.getElementById("editCategoriaId").value = data.categoria.id_categoria;
        document.getElementById("editCategoriaNombre").value = data.categoria.nombre;
        modalEditarCategoria.show();
    }

    if (event.target.classList.contains("btn-eliminar-categoria")) {
        document.getElementById("eliminarCategoriaId").value = id;
        modalEliminarCategoria.show();
    }
});

formEditarCategoria.addEventListener("submit", async function (event) {
    event.preventDefault();

    const data = await enviarFormulario("actions/categorias/editar.php", this);
    if (!data.ok) {
        alert(data.mensaje || "No se pudo actualizar la categoria");
        return;
    }

    const categoria = data.categoria;
    const fila = document.getElementById(`categoria-${categoria.id_categoria}`);
    if (fila) {
        fila.children[1].textContent = categoria.nombre;
    }

    // Se sincroniza el nombre actualizado en la tabla de motos y en los selectores del formulario.
    document.querySelectorAll("#tablaMotos tr").forEach((filaMoto) => {
        const celdaCategoria = filaMoto.children[4];
        if (!celdaCategoria) return;
        if (Number(celdaCategoria.dataset.idCategoria) === Number(categoria.id_categoria)) {
            celdaCategoria.textContent = categoria.nombre;
        }
    });

    actualizarSelectCategorias(categoria.id_categoria, categoria.nombre);
    tablaCategoriasControl.render();
    tablaMotosControl.render();
    modalEditarCategoria.hide();
});

document.getElementById("confirmarEliminarCategoria").addEventListener("click", async function () {
    const datos = new FormData();
    datos.append("id_categoria", document.getElementById("eliminarCategoriaId").value);

    const respuesta = await fetch("actions/categorias/eliminar.php", {
        method: "POST",
        body: datos,
    });
    const data = await respuesta.json();

    if (!data.ok) {
        alert(data.mensaje || "No se pudo eliminar la categoria");
        return;
    }

    const fila = document.getElementById(`categoria-${data.id_categoria}`);
    if (fila) fila.remove();
    removerCategoriaDeSelects(data.id_categoria);
    tablaCategoriasControl.render();
    modalEliminarCategoria.hide();
});
