<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<table class="table table-light table-striped">
    <tbody>
	    <tr><th width="15%">Nombre</th><td>: 	<?php echo $data['nombre']; ?></td></tr>
	    <tr><th width="15%">Descripcion</th><td>: 	<?php echo $data['descripcion']; ?></td></tr>
	    <tr><th width="15%">Fecha</th><td>: 	<?php echo $data['fecha']; ?></td></tr>
</tbody>
</table>
    <div class="d-flex p-2 bd-highlight">
        <a class="btn btn-sm btn-danger" href="<?= \base_url('categorias') ?>">back</a>
    </div>
<?= $this->endSection(); ?>