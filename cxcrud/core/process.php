<?php
error_reporting(E_ALL & ~E_WARNING);
$ligat = new Cxcrud();
$result = array();

if (isset($_POST['generate'])) {
    // get form data
    $table_name = safe($_POST['table_name']);
    $jenis_tabel = safe($_POST['jenis_tabel']);
    $controller = safe($_POST['controller']);
    $model = safe($_POST['model']);

    if ($table_name <> '') {
        // set data
        $table_name = $table_name;
        $c = $controller <> '' ? ucfirst($controller) : ucfirst($table_name);
        $m = $model <> '' ? ucfirst($model) : ucfirst($table_name) . 'Models';
        $v_list = 'index_' . $table_name;
        $v_read = 'read_' . $table_name;
        $v_form = 'form_' . $table_name;


        // url
        $c_url = strtolower($c);

        // filename
        $c_file = $c . '.php';
        $m_file = $m . '.php';
        $v_list_file = $v_list . '.php';
        $v_read_file = $v_read . '.php';
        $v_form_file = $v_form . '.php';

        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;
        $directory = $target . "views/" . $c_url;

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }




        $pk = $ligat->primary_field($table_name);
        $non_pk = $ligat->not_primary_field($table_name);
        $all = $ligat->all_field($table_name);

        // generate
        include 'core/create_controller.php';
        include 'core/create_model.php';
        include 'core/create_view_list.php';
        include 'core/create_view_form.php';
        include 'core/create_view_read.php';

        $structure = 'views/layout';
        if (!file_exists('views/layout/')) {
            if (!mkdir($structure, 0777, true)) {
                die('Failed to create folders...');
            }
            //mkdir($target . "views/layout/", 0700); 
        }
        if (!is_dir($target . "views/layout/")) {
            !mkdir($target . "views/layout/", 0700);
            include 'core/create_view_layout_sidebar.php';
        } else {
            include 'core/create_view_layout_sidebar.php';
        }



        $result[] = $result_controller;
        $result[] = $result_model;
        $result[] = $result_view_list;
        $result[] = $result_view_form;
        $result[] = $result_view_read;
        $result[] = $result_view_layout_sidebar;
    } else {
        $result[] = 'No table selected.';
    }
}

if (isset($_POST['generateall'])) {

    $jenis_tabel = safe(isset($_POST['jenis_tabel']));

    $table_list = $ligat->table_list();
    foreach ($table_list as $row) {

        $table_name = $row['table_name'];
        $c = ucfirst($table_name);
        $m = ucfirst($table_name) . 'Model';
        $v_list = "index_" . $table_name;
        $v_read = "read_" . $table_name;
        $v_form = "form_" . $table_name;

        // url
        $c_url = strtolower($c);

        // filename
        $c_file = $c . '.php';
        $m_file = $m . '.php';
        $v_list_file = $v_list . '.php';
        $v_read_file = $v_read . '.php';
        $v_form_file = $v_form . '.php';

        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;
        if (!file_exists($target . "views/" . $c_url)) {
            mkdir($target . "views/" . $c_url, 0777, true);
        }

        $pk = $ligat->primary_field($table_name);
        $non_pk = $ligat->not_primary_field($table_name);
        $all = $ligat->all_field($table_name);

        // generate
        include 'core/create_controller.php';
        include 'core/create_model.php';
        include 'core/create_view_list.php';
        include 'core/create_view_form.php';
        include 'core/create_view_read.php';
        include 'core/create_views_layout_sidebar.php';



        $result[] = $result_controller;
        $result[] = $result_model;
        $result[] = $result_view_list;
        $result[] = $result_view_form;
        $result[] = $result_view_read;
        $result[] = $result_view_layout_sidebar;
    }
}
