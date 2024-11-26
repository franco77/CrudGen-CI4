<?php
$string = "
<?= \$this->extend('layout/template'); ?>
<?= \$this->section('content'); ?>

<div class=\"row\">
    <div class=\"d-flex p-2 bd-highlight\">
        <a href=\"<?= base_url('$c_url/create') ?>\" class=\"btn btn-sm btn-primary\">CREATE</a>
    </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
<div class=\"alert alert-info\" role=\"alert\">
    <?= session()->getFlashdata('message') ?>
</div>
<?php endif; ?>


    <table id=\"expensesTable\" class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
    <thead>
        <tr>
        <th>No</th>";
foreach ($non_pk as $row) {
    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate'])) //meedun code selected
    {
        $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
    }
    if (isset($_POST['generateall'])) //meedun code selected filed
    {
        $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
    }
}
$string .= "\n\t\t<th>Action</th>";

$string .= "
        </tr>
    </thead>
         <tbody>
        </tbody>
    </table>
   

<?= \$this->endSection(); ?>

<?= \$this->section(\"js\"); ?>
<script>
$(document).ready(function() {
    $('#expensesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: \"<?= site_url('" . $c . "/fetchExpenses'); ?>\",
            type: \"POST\"
        },
        columns: [{
            data: \"id\", render: function(data, type, row, meta) { return meta.row + 1; } },";
foreach ($non_pk as $row) {
    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate'])) {
        if ($row['column_name'] === 'file') {
            $string .= " 
            \n\t\t\t{ data: \"file\", 
            \"render\": function(data, type, row) { 
                return '<img src=\"' + data + '\" alt=\"Image\" style=\"width:50px;height:50px;\"/>'; 
            } 
            },";
        } else {
            $string .= "\n\t\t\t{ data: \"" . $row['column_name'] . "\" },";
        }
    } elseif (isset($_POST['generateall'])) {
        if ($row['column_name'] === 'file') {
            $string .= " 
            \n\t\t\t{ data: \"file\", 
            \"render\": function(data, type, row) { 
                return '<img src=\"' + data + '\" alt=\"Image\" style=\"width:50px;height:50px;\"/>'; 
            } 
            },";
        } else {
            $string .= "\n\t\t\t{ data: \"" . $row['column_name'] . "\" },";
        }
    }
}

$string .= " {
            data: \"id\", 
            render: function(data, type, row) {
                return `
                        <a href=\"<?= site_url('" . $c . "/read/') ?>\${data}\" class=\"btn btn-sm btn-primary\">Read</a>
                        <a href=\"<?= site_url('" . $c . "/update/') ?>\${data}\" class=\"btn btn-sm btn-warning\">Edit</a>
                        <a href=\"#\" class=\"btn btn-sm btn-danger\" onclick=\"confirmDelete(\${data})\">Delete</a>
                    `;
            },
            orderable: false, 
            searchable: false 
        }]
    });

});

function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: \"¡No podrás revertir esto!\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = \"<?= site_url('" . $c . "/delete/') ?>\" + id;
        }
    });
}


</script>
<?= \$this->endSection(); ?>";

$result_view_list = createFile($string, $target . "views/" . $c_url . "/" . $v_list_file);
