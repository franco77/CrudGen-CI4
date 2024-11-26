<?php 
$menus = [
    ['Clientes', 'Clientes'],
    ['Categorias', 'Categorias'],
];
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>
    <?php foreach ($menus as $m) : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url() . '/' . $m[0] ?>"><span> <?= $m[1] ?></span></a>
        </li>
    <?php endforeach; ?>
</ul>



<?php 
/* End of file views/layout/sidebar.php */
/* Location: ./app/views/layout */
/* Please DO NOT modify this information : */
/* Generated by Ligatcode Codeigniter 4 CRUD Generator 2024-11-26 11:43:57 */
?>