<?php
//error_reporting(0);
require_once 'core/cxcrud.php';
require_once 'core/helper.php';
require_once 'core/process.php';
?>
<!doctype html>
<html>

<head>
    <title>Cx-Crud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: red;
            color: white;
            cursor: pointer;
            padding: 6px;
            border-radius: 40px 40px 4px 4px
        }

        #myBtn:hover {
            background-color: #555
        }

        .result {
            background: black;
            color: #fff;
            padding: 10px 5px;
            margin: 15px 0px;
        }

        .result p {
            margin: 0 0 0 0px;
        }
    </style>
</head>

<body style="margin-top: 2rem;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron" style="padding: 18px 18px;">
                    <h3 class=" text-center"><i class="fa-solid fa-database fa-2xl" style="color: #008bf5;"></i> Cx Crud Codeigniter 4 </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="index.php" method="POST" id="myform" name="myform">
                            <div class="alert alert-success">
                                <div class="form-group">
                                    <label>Select Table - <a href="<?php echo $_SERVER['PHP_SELF'] ?>">Refresh</a></label>
                                    <select id="table_name" name="table_name" class="form-control" onchange="setname()">
                                        <option value="">Please Select</option>
                                        <?php
                                        $table_list = $ligat->table_list();
                                        $table_list_selected = isset($_POST['table_name']) ? $_POST['table_name'] : '';
                                        foreach ($table_list as $table) {
                                        ?>
                                            <option value="<?php echo $table['table_name'] ?>" <?php echo $table_list_selected == $table['table_name'] ? 'selected="selected"' : ''; ?>><?php echo $table['table_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!--Show Field-->
                            <div class="form-group">
                                <span id="checkshow" class="btn btn-sm btn-info" style="display:none;" href="#">Show All Field</span>
                                <span id="uncheckshow" class="btn btn-sm btn-danger" style="display:none;" href="#">Uncheck All Field</span></br>
                                <div id="myresponse">
                                    <?php
                                    if (isset($_POST['table_name'])) {
                                        echo "<div class='alert alert-info'>";
                                        echo "<b>List Filed Of Table " . $_POST['table_name'] . "</b><br> <small>Please select the fields to be displayed<br>This feature only affects the <code>Generator</code> button, <br>ignored in <code>Generate All</code></small><hr>";
                                        $table_all_field = isset($_POST['table_name']) ? $ligat->all_field($_POST['table_name']) : '';
                                        foreach ($table_all_field as $field) {
                                            $fieldKey = 'field_' . $field['column_name'];
                                            $check = isset($_POST[$fieldKey]) && $_POST[$fieldKey] == '1' ? "checked" : '';
                                            if (isset($_POST['field_' . $field['column_name']])) {
                                                echo '
                                            <label>
                                            <input type="checkbox"  onclick="check()" class="field" name="field_' . $field['column_name'] . '" value="1" ' . $check . '>
                                            ' . $field['column_name'] . ' <code>{' . $field['data_type'] . '}</code>
                                            </label></br>
                                        ';
                                            } else {
                                                echo '
                                        <label>
                                        <input type="checkbox" onclick="check()" class="field" name="field_' . $field['column_name'] . '" value="1" ' . $check . '>
                                        ' . $field['column_name'] . ' <code>{' . $field['data_type'] . '}</code>
                                        </label></br>
                                        ';
                                            }
                                        }
                                        echo '<hr>
                                </div>';
                                    }  ?>

                                </div>
                            </div>



                            <div class="alert alert-success">
                                <div class="form-group">
                                    <label>Custom Controller Name</label>
                                    <input type="text" id="controller" name="controller" value="<?php echo isset($_POST['controller']) ? $_POST['controller'] : '' ?>" class="form-control" placeholder="Controller Name" />
                                </div>
                                <div class="form-group">
                                    <label>Custom Model Name</label>
                                    <input type="text" id="model" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : '' ?>" class="form-control" placeholder="Controller Name" />
                                </div>
                            </div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <input type="submit" value="Generate" id="generate" name="generate" class="btn btn-primary" onclick="javascript: return confirm('This will overwrite the existing files. Continue ?')" />
                                <!-- <input type="submit" value="Generate All" id="generateall" name="generateall" class="btn btn-danger" onclick="javascript: return confirm('WARNING !! This will generate code for ALL TABLE and overwrite the existing files\
                    \nPlease double check before continue. Continue ?')" /> -->
                                <a href="core/setting.php" type="button" class="btn btn-default">Setting</a>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>





            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <?php if (count($result) > 0) : ?>
                            <b>File Results</b>
                            <div class="result">
                                <?php
                                foreach ($result as $h) {
                                    echo '<p>' . $h . '</p>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- EL CONTENIDO AQUI -->
                        <h3 style="margin-top: 0px">Codeigniter 4 CRUD Generator 1.0</h3>
                        <p><strong>Créditos :</strong> <a href="https://github.com/irev/ci4-ligatcode"> github: irev/ci4-ligatcode</a></p>
                        <p>
                            <strong>CodeIgniter 4 CRUD Generator</strong> is a powerful and easy-to-use tool that allows you to automatically generate models, controllers, and views directly from your database tables. Designed to streamline your workflow, this tool significantly reduces the time required to create applications with CRUD (Create, Read, Update, Delete) operations, allowing you to focus on business logic and other more important aspects of your project.
                        </p>
                        <p>
                            With <strong>CodeIgniter 4 CRUD Generator</strong>, you will get clean, organized, and easy-to-understand code, designed to ensure maximum comprehension and ease of maintenance. The built-in features include:
                        </p>
                        <ul>
                            <li><strong>Full CRUD operations</strong> to efficiently manage data.</li>
                            <li><strong>Built-in pagination</strong> to handle large volumes of information.</li>
                            <li><strong>Dynamic search and filtering</strong> to find records quickly.</li>
                            <li><strong>Automatic form generation</strong> with fields validated based on your custom rules.</li>
                            <li><strong>Robust form validation</strong> based on CodeIgniter rules.</li>
                        </ul>
                        <p>
                            The view layout uses <strong>Bootstrap 4</strong>, ensuring a modern, responsive, and easy-to-customize interface. This integration provides a consistent and engaging user experience without the need to design from scratch.
                        </p>
                        <p>
                            Furthermore, this tool is designed for both experienced and beginner developers, offering an accessible environment for anyone looking to streamline their development process without sacrificing code quality.
                        </p>
                        <p>
                            In short, <strong>CodeIgniter 4 CRUD Generator</strong> is your ideal ally for saving time, reducing errors, and maintaining high standards in application development. Start enjoying faster and more efficient development today!
                        </p>
                        <!-- End -->
                        <p><strong>Preparation before using this Codeigniter 4 CRUD Generator <span style="color:red;">(Important)</span> :</strong></p>
                        <ul>
                            <li>On <b>Controller</b> <code>app/Controller/BaseController.php</code>, load database library, session library and url helper
                                <ul>
                                    <li><code>protected $helpers = ['html','text','form','session'];</code></li>
                                </ul>
                            </li>
                            <li>On file <code>.env</code>, set :</b>.
                                <ul>
                                    <li>database.default.hostname = localhost</li>
                                    <li>database.default.database = database</li>
                                    <li>database.default.username = username</li>
                                    <li>database.default.password = password</li>
                                    <li>database.default.DBDriver = MySQLi</li>
                                </ul>
                            </li>
                        </ul>
                        <p><strong>Note:</strong> If you get an error when connecting to the database I recommend removing this line of code from the file <code>.env</code><br>
                            <code># If you use MySQLi as tests, first update the values of Config\Database::$tests.</code>
                        </p>
                        <p><strong>Using this CRUD Generator :</strong></p>
                        <ul>
                            <li>Simply put <code>'cxcrud' folder</code>,view folder, <code>'asset' folder</code> and <code>.htaccess</code> file into your project root folder.</li>
                            <li>Open <code>http://localhost/({yourprojectname}/cxcrud.</code></li>
                            <li>Select table and push generate button.</li>
                        </ul>
                        <p><strong>FAQ :</strong></p>
                        <ul>
                            <li>Select table show no data. Make sure you have correct database configuration on application/config/database.php and load database library on autoload.</li>
                            <li>Error chmod on mac and linux. Please change your application folder and harviacode folder chmod to 777 </li>
                            <!--li>Error 404 when click Create, Read, Update, Delete or Next Page. Make sure your mod_rewrite is active 
            and you can access http://localhost/yourproject/welcome. The problem is on htaccess. Still have problem?
            please go to google and search how to remove index.php codeigniter.
        </li-->
                            <li>Error cannot Read, Update, Delete. Make sure your table have primary key.</li>
                        </ul>
                        <br>

                        <p><strong>Update Codeigniter 4 CRUD Generator</strong></p>

                        <ul>
                            <li>V.1.0 <small style="color:red;">(meedun)</small> - 30 August 2020
                                <ul>
                                    <li>Add the displayed database field selector
                                        <ul>
                                            <li>construct (model, view and controller) for Codeigniter framework version 4.0.4</li>
                                            <li>Support custom page layout, built-in features of Codeigniter 4</li>
                                            <li>This feature only affects the Generator button, ignored in Generate All button</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                        <p><strong>&COPY; 2020-<?= date('Y') ?> <a target="_blank" href="http://blog.simeedun.com">blog.simeedun.com</a></strong></p>
                        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script type="text/javascript">
        function capitalize(s) {
            return s && s[0].toUpperCase() + s.slice(1);
        }

        function setname() {
            var table_name = document.getElementById('table_name').value.toLowerCase();
            if (table_name != '') {
                document.getElementById('controller').value = capitalize(table_name);
                document.getElementById('model').value = capitalize(table_name) + 'Model';
            } else {
                document.getElementById('controller').value = '';
                document.getElementById('model').value = '';
            }
        }

        //Get the button
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }



        var form = document.forms.namedItem("myform");
        var myresponse = document.getElementById('myresponse');
        var local = window.location.href.replace('index.php', '');
        form.addEventListener('change', (e) => {
            // on form submission, prevent default
            e.preventDefault();
            // construct a FormData object, which fires the formdata event
            new FormData(form);
        });


        form.onformdata = (e) => {
            //console.log('formdata fired');
            // Get the form data from the event object
            let data = e.formData;
            for (var value of data.values()) {
                //console.log(value);
            }
            if (table_name.value != '') {
                // submit the data via XHR
                var request = new XMLHttpRequest();
                request.open("POST", local + 'getfield.php', true);
                //request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                request.onreadystatechange = function() {
                    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                        //console.log('succeed');
                        myresponse.value = request.responseText;
                        document.getElementById("myresponse").innerHTML = request.responseText;
                        document.getElementById("checkshow").style.display = "block";
                        document.getElementById("generateall").style.display = "none";
                    } else {
                        document.getElementById("myresponse").innerHTML = "";
                        document.getElementById("uncheckshow").style.display = "none";
                        document.getElementById("checkshow").style.display = "none";
                        document.getElementById("generateall").style.display = "block";
                    }
                };
                request.send(data);
            } else {
                document.getElementById("myresponse").innerHTML = "";
                document.getElementById("generateall").style.display = "block";
                document.getElementById("uncheckshow").style.display = "none";
                document.getElementById("checkshow").style.display = "none";
            }
        };
        // test FormDataEvent constructor
        let fd = new FormData();
        fd.append('test', 'test');
        let fdEv = new FormDataEvent('formdata', {
            formData: fd
        });

        function checks(params) {
            var x = document.getElementsByClassName("field");
            var i;
            for (i = 0; i < x.length; i++) {
                if (x[i].checked) {
                    x[i].checked = true;
                } else {
                    x[i].checked = true;
                }
            }
            document.getElementById("uncheckshow").style.display = "block";
            document.getElementById("checkshow").style.display = "none";
        }

        function unchecks(params) {
            var x = document.getElementsByClassName("field");
            var i;
            for (i = 0; i < x.length; i++) {
                if (x[i].checked) {
                    x[i].checked = false;
                } else {
                    x[i].checked = false;
                }
            }
            document.getElementById("uncheckshow").style.display = "none";
            document.getElementById("checkshow").style.display = "block";
        }
        document.getElementById("checkshow").addEventListener("click", checks);
        document.getElementById("uncheckshow").addEventListener("click", unchecks);
    </script>
</body>

</html>