### Codeigniter 4 CRUD Generator :fa-heart:

**Créditos :** [github: irev/ci4-ligatcode](https://github.com/irev/ci4-ligatcode)

**CodeIgniter 4 CRUD Generator** is a powerful and easy-to-use tool that allows you to automatically generate models, controllers, and views directly from your database tables. Designed to streamline your workflow, this tool significantly reduces the time required to create applications with CRUD (Create, Read, Update, Delete) operations, allowing you to focus on business logic and other more important aspects of your project.

> **NOTE: This Crud is a modification of the ligatcode project.**

## Highlighted Features: :fa-thumbs-o-up::fa-thumbs-o-up:

- [x] CRUD Generator
- [x] MODEL, VIEW, CONTROLER
- [x] DataTable Server Side
- [x] Form validation
- [x] Upload File :: Only fields with the name {file} and type {varchar}
- [x] Dropdown(select) :: Only for fields of type {enum}:
- [x] Datepicker Only for fields of type {date},{datetime}
- [x] Sweet Alert to avoid accidentally deleting records

With **CodeIgniter 4 CRUD Generator**, you will get clean, organized, and easy-to-understand code, designed to ensure maximum comprehension and ease of maintenance. The built-in features include:

- **Full CRUD operations** to efficiently manage data.
- **Built-in pagination** to handle large volumes of information.
- **Dynamic search and filtering** to find records quickly.
- **Automatic form generation** with fields validated based on your custom rules.
- **Robust form validation** based on CodeIgniter rules.

The view layout uses **Bootstrap 4**, ensuring a modern, responsive, and easy-to-customize interface. This integration provides a consistent and engaging user experience without the need to design from scratch.

Furthermore, this tool is designed for both experienced and beginner developers, offering an accessible environment for anyone looking to streamline their development process without sacrificing code quality.

In short, **CodeIgniter 4 CRUD Generator** is your ideal ally for saving time, reducing errors, and maintaining high standards in application development. Start enjoying faster and more efficient development today!

**Preparation before using this Codeigniter 4 CRUD Generator (Important) :**

- On **Controller** `app/Controller/BaseController.php`, load database library, session library and url helper \* `protected $helpers = ['html','text','form','session'];`
  **On file `.env`, set :**.

- database.default.hostname = localhost
- database.default.database = database
- database.default.username = username
- database.default.password = password
- database.default.DBDriver = MySQLi

**Note:** If you get an error when connecting to the database I recommend removing this line of code from the file `.env`  
`# If you use MySQLi as tests, first update the values of Config\Database::$tests.`

**Using this CRUD Generator :** :fa-bolt:

- Simply place the **'cxcrud'** folder in your project's main directory, the **'layout'** folder goes inside the `view/` folder and the **'asset'** folder goes inside the `public/` folder.
- Open http://localhost/({yourprojectname}/cxcrud.
- Select the table and press the Generate button.

**FAQ :** :fa-bug:

- Select table show no data. Make sure you have correct database configuration on application/config/database.php and load database library on autoload.
- Error chmod on mac and linux. Please change your application folder and harviacode folder chmod to 777
- Error cannot Read, Update, Delete. Make sure your table have primary key.

**Upcoming Updates** :fa-clock-o:

- WYSIWYG editor
- View action with modal
- TimePicker
- Checkboxes and Radio Buttons
