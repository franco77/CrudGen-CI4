<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<table class="table table-light table-striped table-sm">
    <tbody>
	<tr><th width="15%">Nombre</th><td>: 	<?php echo $data['nombre']; ?></td></tr>
	<tr><th width="15%">Email</th><td>: 	<?php echo $data['email']; ?></td></tr>
	<tr><th width="15%">Telefono</th><td>: 	<?php echo $data['telefono']; ?></td></tr>
	<tr><th width="15%">Direccion</th><td>: 	<?php echo $data['direccion']; ?></td></tr>
	<tr><th width="15%">Fecha Nacimiento</th><td>: 	<?php echo $data['fecha_nacimiento']; ?></td></tr>
	<tr><th width="15%">File</th><td>: 	<?php echo $data['file']; ?></td></tr>
</tbody>
</table>
    <div class="d-flex p-2 bd-highlight">
        <a class="btn btn-sm btn-danger" href="<?= \base_url('clientes') ?>">back</a>
    </div>
<?= $this->endSection(); ?>