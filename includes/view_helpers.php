<?php
function renderMotoRow(array $moto): string
{
    $id = (int) $moto["id"];
    $marca = htmlspecialchars($moto["marca"], ENT_QUOTES, "UTF-8");
    $modelo = htmlspecialchars($moto["modelo"], ENT_QUOTES, "UTF-8");
    $precio = htmlspecialchars((string) $moto["precio"], ENT_QUOTES, "UTF-8");
    $idCategoria = (int) $moto["id_categoria"];
    $categoriaNombre = htmlspecialchars($moto["categoria_nombre"], ENT_QUOTES, "UTF-8");

    return "
    <tr id='moto-{$id}'>
        <td>{$id}</td>
        <td>{$marca}</td>
        <td>{$modelo}</td>
        <td>{$precio}</td>
        <td data-id-categoria='{$idCategoria}'>{$categoriaNombre}</td>
        <td class='text-center acciones'>
            <button class='btn btn-sm btn-info text-white btn-ver' data-id='{$id}'>Ver</button>
            <button class='btn btn-sm btn-warning btn-editar' data-id='{$id}'>Editar</button>
            <button class='btn btn-sm btn-danger btn-eliminar' data-id='{$id}'>Eliminar</button>
        </td>
    </tr>";
}

function renderCategoriaRow(array $categoria): string
{
    $id = (int) $categoria["id_categoria"];
    $nombre = htmlspecialchars($categoria["nombre"], ENT_QUOTES, "UTF-8");

    return "
    <tr id='categoria-{$id}'>
        <td>{$id}</td>
        <td>{$nombre}</td>
        <td class='text-center acciones'>
            <button class='btn btn-sm btn-info text-white btn-ver-categoria' data-id='{$id}'>Ver</button>
            <button class='btn btn-sm btn-warning btn-editar-categoria' data-id='{$id}'>Editar</button>
            <button class='btn btn-sm btn-danger btn-eliminar-categoria' data-id='{$id}'>Eliminar</button>
        </td>
    </tr>";
}

function renderCategoriaOptions(array $categorias): string
{
    $options = '<option value="">Selecciona una categoria</option>';

    foreach ($categorias as $categoria) {
        $id = (int) $categoria["id_categoria"];
        $nombre = htmlspecialchars($categoria["nombre"], ENT_QUOTES, "UTF-8");
        $options .= "<option value='{$id}'>{$nombre}</option>";
    }

    return $options;
}
