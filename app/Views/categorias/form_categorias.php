<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h4 style="margin-top:0px">Categorias <?php echo $content; ?></h4>
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
                        <label for="descripcion">Descripcion
                            <?php echo ('descripcion') ?></label>
                        <textarea class="form-control" rows="3" name="descripcion" id="descripcion"
                            placeholder="Descripcion"><?php echo $data['descripcion']; ?></textarea>
                            <?php if (isset(session('errors')['descripcion'])): ?> 
                                <span class="text-danger"><?= session('errors')['descripcion'] ?></span> 
                                <?php endif; ?>
                    </div>
	 <div class="form-group">
            <label for="fecha">Fecha
                <?php echo ('fecha') ?></label>
            <input type="text" class="form-control" autocomplete="off" name="fecha" id="fecha"
                placeholder="Fecha" value="<?php echo $data['fecha']; ?>" autocomplete="off"
            placeholder="Click Para Seleccionar la fecha" onclick="$('#fecha').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            }).datepicker('show');" />
             <?php if (isset(session('errors')['fecha'])): ?> 
                                <span class="text-danger"><?= session('errors')['fecha'] ?></span> 
                                <?php endif; ?>
        </div>
	 <input id="id" class="form-control" type="text" name="id" style="display:none;" value="<?= $data['id'] ?>"> 
	
    <div class="d-flex p-2 bd-highlight">
    <div class="form-group">
        <a class="btn btn-sm btn-danger" href="<?= base_url('categorias') ?>">Cencel</a>
        <button class="btn btn-sm btn-primary" type="submit">SAVE</button>
    </div>
    </div>
</form>



<?= $this->endSection(); ?>