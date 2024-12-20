<?php
$string = "<?php namespace App\\Controllers;
use App\\Models\\$m;
use CodeIgniter\\HTTP\\Response;

class " . $c . " extends BaseController
{
    protected \$PageData;
    protected \$Model; //Default models for this controller
    protected \$pager;

	public function __construct()
	{
		\$this->Model = new $m(); //Default models for this controller
        \$this->PageData = \$this->attributePage(); //Attribute Of Page
    }
    
    //ATRIBUTE THIS PAGE
    private function attributePage()
	{
		return  [
			'title' => 'Cx Crud | $c',
			'app' => 'Cx Crud',
		];
    }

    //INDEX 
    public function index()
	{
		\$data = [
			'AttributePage' =>\$this->PageData,
			'content' => 'Create Pages',
           ];
		return view('$c_url/$v_list', \$data);
    }

//DATA TABLE
public function fetchExpenses()
{
    \$request = service('request');
    

    \$draw = \$request->getPost('draw');
    \$start = intval(\$request->getPost('start'));
    \$length = intval(\$request->getPost('length'));
    \$searchValue = \$request->getPost('search')['value'];
    \$order = \$request->getPost('order');
    \$orderColumn = \$order[0]['column'];
    \$orderDir = \$order[0]['dir'];
    \$columns = \$request->getPost('columns');
    \$orderBy = \$columns[\$orderColumn]['data'];

    \$query = \$this->Model;

    if (!empty(\$searchValue)) {
        \$query->like('id', \$searchValue);";
foreach ($all as $row) {
    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate']))  //meedun code selected filed
    {
        $string .= "\n\t\t\t\t\t    \$query->orLike('" . $row['column_name'] . "', \$searchValue);";
    }
    if (isset($_POST['generateall']))  //meedun code
    {
        $string .= "\n\t\t\t\t\t    \$query->orLike('" . $row['column_name'] . "', \$searchValue);";
    }
}
$string .= "}

    \$totalFiltered = \$query->countAllResults(false);

    \$query->orderBy(\$orderBy, \$orderDir)
          ->limit(\$length, \$start);

    \$results = \$query->findAll();
    \$totalData = \$this->Model->countAll();

    \$response = [
        'draw' => intval(\$draw),
        'recordsTotal' => \$totalData,
        'recordsFiltered' => \$totalFiltered, ";
if ($row['column_name'] === 'file') {
    $string .= "
         'data' => array_map(function(\$result) { 
         \$result['file'] = base_url('uploads/' . \$result['file']); 
          return \$result; 
                }, 
         \$results), ";
} else {
    $string .= "
         'data' => \$results,";
}
$string .= " ];

    return \$this->response->setJSON(\$response);
}

//READ
    public function read(\$id)
	{
		\$data = [
			'AttributePage' => \$this->PageData,
			'content' => 'Read Pages',
			'data' => \$this->Model->find(\$id) //find on data
		];
		return view('$c_url/$v_read', \$data);
    }

    //CREATE
    public function create()
	{
		\$data = [
			'AttributePage' => \$this->PageData,
			'content' => 'Create Pages',
			'action' => '$c/create_action',
			'data' =>   [";
//'$c' => set_value('$c'),

foreach ($all as $row) {
    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate']))  //meedun code selected filed
    {
        $string .= "\n\t\t\t\t\t     '" . $row['column_name'] . "' => set_value('" . $row['column_name'] . "'),";
    }
    if (isset($_POST['generateall']))  //meedun code
    {
        $string .= "\n\t\t\t\t\t     '" . $row['column_name'] . "' => set_value('" . $row['column_name'] . "'),";
    }
}
$string .= "
					    ]
		];
		return view('$c_url/$v_form', \$data);
    }\t";


foreach ($all as $field) {
    if ($field['column_name'] === 'file') {
        $string .= "
        //UPLOAD FILE
        public function uploadFile(\$fileInputName)
        {
                \$file = \$this->request->getFile(\$fileInputName);
            
               if (\$file && \$file->isValid() && !\$file->hasMoved()) {
        \$newName = \$file->getRandomName();
        \$file->move(FCPATH . 'uploads', \$newName);
        return \$newName;
    }
            
                return false;
            }\t";
    }
}

$string .= "

    //ACTION CREATE
	public function create_action()
	{
    \$validation = \Config\Services::validation(); 
	\$validation->setRules(\$this->_rules()); 
		if (!\$validation->withRequest(\$this->request)->run()) { 
	return redirect()->back()->withInput()->with('errors', \$validation->getErrors()); 
	}";

if ($field['column_name'] === 'file') {

    $string .= "\$fileName = \$this->uploadFile('file');

   if (\$fileName === false) {
        session()->setFlashdata('error', 'Hubo un error al subir el archivo.');
        return redirect()->back()->withInput();
    }";
}


$string .= " 
              \$data =[";
foreach ($all as $row) {
    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate']))  //meedun code selected filed
    {
        if ($row['column_name'] == 'file') {
            $string .= "\n\t\t\t\t\t     'file' => \$fileName,";
        } else {
            $string .= "\n\t\t\t\t\t     '" . $row['column_name'] . "' => \$this->request->getVar('" . $row['column_name'] . "'),";
        }
    }
    if (isset($_POST['generateall']))  //meedun code
    {
        if ($row['column_name'] == 'file') {
            $string .= "\n\t\t\t\t\t     'file' => \$fileName,";
        } else {
            $string .= "\n\t\t\t\t\t     '" . $row['column_name'] . "' => \$this->request->getVar('" . $row['column_name'] . "'),";
        }
    }
}
$string .= "
        \n\t\t\t\t];
		\$this->Model->save(\$data);
		session()->setFlashdata('message', 'Create Record Success');
		return redirect()->to(base_url('/$c'));
    }
    
    //UPDATE
	public function update(\$id)
	{
		\$dataFind = \$this->Model->find(\$id);
		if(\$dataFind == false){
			return redirect()->to(base_url('/$c'));
		}
		\$data = [
			'AttributePage' => \$this->PageData,
			'content' => 'Edite Pages',
			'action' => '$c_url/update_action',
			'data' => \$this->Model->find(\$id),
        ];
		session()->setFlashdata('message', 'Update Record Success');
		return view('$c_url/$v_form', \$data);
    }
    
    //ACTION UPDATE
   	public function update_action()
	{

       \$validation = \Config\Services::validation(); 
		\$validation->setRules(\$this->_rules()); 
		if (!\$validation->withRequest(\$this->request)->run()) { 
	          return redirect()->back()->withInput()->with('errors', \$validation->getErrors()); 
	    }

		\$id = \$this->request->getVar('$pk');
		\$row = \$this->Model->find(\$id); 

        if (!\$row) {
            session()->setFlashdata('error', 'Registro no encontrado.');
            return redirect()->to(base_url('$c_url'));
        } ";

if ($row['column_name'] == 'file') {
    $string .= "\$fileName = \$this->uploadFile('file'); 
    if (\$fileName === false) { 
        // Si no se sube un nuevo archivo, mantener el valor existente
        \$fileName = \$row['file'] ?? null; 
    } ";
}



$string .= " 
                \$data =[";
foreach ($all as $row) {
    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate']))  //meedun code selected filed
    {
        if ($row['column_name'] == 'file') {
            $string .= "\n\t\t\t\t\t     'file' => \$fileName,";
        } elseif ($row['column_name'] == 'id') {
            $string .= "\n\t\t\t\t\t     'id' => \$id,";
        } else {
            $string .= "\n\t\t\t\t\t     '" . $row['column_name'] . "' => \$this->request->getVar('" . $row['column_name'] . "'),";
        }
    }
    if (isset($_POST['generateall']))  //meedun code
    {
        if ($row['column_name'] == 'file') {
            $string .= "\n\t\t\t\t\t     'file' => \$fileName,";
        } elseif ($row['column_name'] == 'id') {
            $string .= "\n\t\t\t\t\t     'id' => \$id,";
        } else {
            $string .= "\n\t\t\t\t\t     '" . $row['column_name'] . "' => \$this->request->getVar('" . $row['column_name'] . "'),";
        }
    }
}

$string .= "
                    ];

        if (\$this->Model->save(\$data)) {
                   session()->setFlashdata('message', 'Update Record Success');
        } else {
                   session()->setFlashdata('error', 'Error al actualizar el registro.');
    }
			
			return redirect()->to(base_url('$c_url'));
		
	}

    //DELETE
	public function delete(\$id)
	{
		\$row = \$this->Model->find(['$pk' => \$id]);
		if (\$row) {
            \$this->Model->delete(\$id);
            session()->setFlashdata('message', 'Delete Record Success');
            return redirect()->to(base_url('/$c_url'));
        } else {
            session()->setFlashdata('message', 'Record Not Found');
            return redirect()->to(base_url('/$c_url'));
        }

    }

    //RULES
    public function _rules() 
    { 
    return [";
foreach ($non_pk as $row) {
    if ($row['column_name'] == 'file') {
        continue; // Omitir el campo 'file'
    }

    if (isset($_POST['field_' . $row['column_name']]) && isset($_POST['generate']))  //meedun code selected filed
    {
        $int = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? '|numeric' : '';
        $string .= "\n\t'" . $row['column_name'] . "' => 'trim|required$int',";
    }
    if (isset($_POST['generateall']))  //meedun code
    {
        $int = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? '|numeric' : '';
        $string .= "\n\t'" . $row['column_name'] . "' => 'trim|required$int',";
    }
}


$string .= " ]; 
}";




$string .= "\n\n}\n\n/* End of file $c_file */
 /* Location: ./app/controllers/$c_file */
 /* Generated by CX-CRUD " . date('Y-m-d H:i:s') . " */";

$result_controller = createFile($string, $target . "controllers/" . $c_file);
