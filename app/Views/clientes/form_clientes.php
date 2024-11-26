<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h4 style="margin-top:0px">Clientes <?php echo $content; ?></h4>
<form action="<?= base_url($action) ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" autocomplete="off" name="nombre" id="nombre"
                placeholder="Nombre" value="<?php echo $data['nombre']; ?>" />
            <?php if (isset(session('errors')['nombre'])): ?> 
                <span class="text-danger"><?= session('errors')['nombre'] ?></span> 
            <?php endif; ?>
        </div>
	<div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" autocomplete="off" name="email" id="email"
                placeholder="Email" value="<?php echo $data['email']; ?>" />
            <?php if (isset(session('errors')['email'])): ?> 
                <span class="text-danger"><?= session('errors')['email'] ?></span> 
            <?php endif; ?>
        </div>
	<div class="form-group">
            <label for="telefono">Telefono</label>
            <input type="text" class="form-control" autocomplete="off" name="telefono" id="telefono"
                placeholder="Telefono" value="<?php echo $data['telefono']; ?>" />
            <?php if (isset(session('errors')['telefono'])): ?> 
                <span class="text-danger"><?= session('errors')['telefono'] ?></span> 
            <?php endif; ?>
        </div>
	 <div class="form-group">
                        <label for="direccion">Direccion
                            <?php echo ('direccion') ?></label>
                        <textarea class="form-control" rows="3" name="direccion" id="direccion"
                            placeholder="Direccion"><?php echo $data['direccion']; ?></textarea>
                            <?php if (isset(session('errors')['direccion'])): ?> 
                                <span class="text-danger"><?= session('errors')['direccion'] ?></span> 
                                <?php endif; ?>
                    </div>
	 <div class="form-group">
            <label for="fecha_nacimiento">Fecha Nacimiento
                <?php echo ('fecha_nacimiento') ?></label>
            <input type="text" class="form-control" autocomplete="off" name="fecha_nacimiento" id="fecha_nacimiento"
                placeholder="Fecha Nacimiento" value="<?php echo $data['fecha_nacimiento']; ?>" autocomplete="off"
            placeholder="Click Para Seleccionar la fecha" onclick="$('#fecha_nacimiento').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            }).datepicker('show');" />
             <?php if (isset(session('errors')['fecha_nacimiento'])): ?> 
                                <span class="text-danger"><?= session('errors')['fecha_nacimiento'] ?></span> 
                                <?php endif; ?>
        </div>
	<div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" autocomplete="off" name="file" id="file"
                placeholder="File" />
            <?php if (isset(session('errors')['file'])): ?> 
                <span class="text-danger"><?= session('errors')['file'] ?></span> 
            <?php endif; ?>
        </div>
	 <input id="id" class="form-control" type="text" name="id" style="display:none;" value="<?= $data['id'] ?>"> 
	
    <div class="d-flex p-2 bd-highlight">
    <div class="form-group">
        <a class="btn btn-sm btn-danger" href="<?= base_url('clientes') ?>">Cencel</a>
        <button class="btn btn-sm btn-primary" type="submit">SAVE</button>
    </div>
    </div>
</form>



<?= $this->endSection(); ?>