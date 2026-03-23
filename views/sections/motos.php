<section id="vistaMotos" class="vista-tabla">
    <div class="table-tools mb-3">
        <input type="text" class="form-control table-search" id="buscarMotos" placeholder="Buscar en motos...">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="tablaMotosListado">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaMotos">
                <?php foreach ($motos as $moto): ?>
                    <?= renderMotoRow($moto); ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="table-pagination" id="paginacionMotos"></div>
</section>
