<?php
function updateSidebarFile($newMenus, $filePath)
{
    // Leer el contenido actual del archivo
    $existingContent = file_exists($filePath) ? file_get_contents($filePath) : "";

    // Extraer el array de menús existente
    $menus = [];
    if (preg_match("/\\\$menus\s*=\s*\[(.*?)\];/s", $existingContent, $matches)) {
        // Convertir el contenido del array encontrado a líneas separadas
        $menuLines = explode("\n", trim($matches[1]));

        // Procesar cada línea para extraer los valores
        foreach ($menuLines as $line) {
            if (preg_match("/\['(.*?)',\s*'(.*?)'\]/", $line, $menuMatch)) {
                $menus[] = [$menuMatch[1], $menuMatch[2]];
            }
        }
    }

    // Agregar los nuevos menús al array existente
    foreach ($newMenus as $newMenu) {
        // Evitar duplicados
        if (!in_array($newMenu, $menus)) {
            $menus[] = $newMenu;
        }
    }

    // Crear la cadena de menús actualizada
    $newMenusString = array_reduce($menus, function ($carry, $menu) {
        return $carry . "    ['" . $menu[0] . "', '" . $menu[1] . "'],\n";
    }, "");

    // Construir el nuevo contenido del archivo
    $string = "<?php 
\$menus = [
$newMenusString];
?>";

    // Agregar el contenido del sidebar HTML
    $string .= "
<ul class=\"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion\" id=\"accordionSidebar\">
    <!-- Sidebar - Brand -->
    <a class=\"sidebar-brand d-flex align-items-center justify-content-center\" href=\"index.html\">
        <div class=\"sidebar-brand-icon rotate-n-15\">
            <i class=\"fas fa-laugh-wink\"></i>
        </div>
        <div class=\"sidebar-brand-text mx-3\">SB Admin <sup>2</sup></div>
    </a>
    <?php foreach (\$menus as \$m) : ?>
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"<?= base_url() . '/' . \$m[0] ?>\"><span> <?= \$m[1] ?></span></a>
        </li>
    <?php endforeach; ?>
</ul>";

    $string .= "\n\n\n\n<?php 
/* End of file views/layout/sidebar.php */
/* Location: ./app/views/layout */
/* Generated by CX-CRUD " . date('Y-m-d H:i:s') . " */
?>";

    // Escribir el contenido actualizado en el archivo
    file_put_contents($filePath, $string);
}

if (isset($_POST['generateall'])) {
    // Generar el archivo inicial con las tablas existentes
    $table_list = $ligat->table_list();
    $menus = [];
    foreach ($table_list as $table) {
        $menus[] = [$table['table_name'], $table['table_name']];
    }

    $targetFile = $target . "views/layout/sidebar.php";
    updateSidebarFile($menus, $targetFile);
} else {
    // Agregar un nuevo menú
    $newMenu = [[$c, $c]];
    $targetFile = $target . "views/layout/sidebar.php";
    updateSidebarFile($newMenu, $targetFile);
}
$result_view_layout_sidebar;
