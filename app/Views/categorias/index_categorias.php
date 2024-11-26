
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="d-flex p-2 bd-highlight">
        <a href="<?= base_url('categorias/create') ?>" class="btn btn-sm btn-primary">CREATE</a>
    </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
<div class="alert alert-info" role="alert">
    <?= session()->getFlashdata('message') ?>
</div>
<?php endif; ?>


    <table id="expensesTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
		<th>Nombre</th>
		<th>Descripcion</th>
		<th>Fecha</th>
		<th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
   

<?= $this->endSection(); ?>

<?= $this->section("js"); ?>
<script>
$(document).ready(function() {
    $('#expensesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('Categorias/fetchExpenses'); ?>",
            type: "POST"
        },
        columns: [{
            data: "id", render: function(data, type, row, meta) { return meta.row + 1; } },
			{ data: "nombre" },
			{ data: "descripcion" },
			{ data: "fecha" }, {
            data: "id", // Usaremos el ID para las acciones
            render: function(data, type, row) {
                return `
                        <a href="<?= site_url('Categorias/read/') ?>${data}" class="btn btn-sm btn-primary">Read</a>
                        <a href="<?= site_url('Categorias/update/') ?>${data}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete(${data})">Delete</a>
                    `;
            },
            orderable: false, // Deshabilitar orden en esta columna
            searchable: false // Deshabilitar búsqueda en esta columna
        }]
    });

});

// Función para mostrar SweetAlert antes de borrar
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('Categorias/delete/') ?>" + id;
        }
    });
}


</script>
<?= $this->endSection(); ?>