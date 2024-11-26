<?php namespace App\Controllers;
use App\Models\ClientesModel;
use CodeIgniter\HTTP\Response;

class Clientes extends BaseController
{
    protected $PageData;
    protected $Model; //Default models for this controller
    protected $pager;

	public function __construct()
	{
		$this->Model = new ClientesModel(); //Default models for this controller
        $this->PageData = $this->attributePage(); //Attribute Of Page
    }
    
    //ATRIBUTE THIS PAGE
    private function attributePage()
	{
		return  [
			'title' => 'Cx Crud | Clientes',
			'app' => 'Cx Crud',
		];
    }

    //INDEX 
    public function index()
	{
		$data = [
			'AttributePage' =>$this->PageData,
			'content' => 'Create Pages',
           ];
		return view('clientes/index_clientes', $data);
    }

//DATA TABLE
public function fetchExpenses()
{
    $request = service('request');
    

    $draw = $request->getPost('draw');
    $start = intval($request->getPost('start'));
    $length = intval($request->getPost('length'));
    $searchValue = $request->getPost('search')['value'];
    $order = $request->getPost('order');
    $orderColumn = $order[0]['column'];
    $orderDir = $order[0]['dir'];
    $columns = $request->getPost('columns');
    $orderBy = $columns[$orderColumn]['data'];

    $query = $this->Model;

    if (!empty($searchValue)) {
        $query->like('id', $searchValue);
					    $query->orLike('id', $searchValue);
					    $query->orLike('nombre', $searchValue);
					    $query->orLike('email', $searchValue);
					    $query->orLike('telefono', $searchValue);
					    $query->orLike('direccion', $searchValue);
					    $query->orLike('fecha_nacimiento', $searchValue);
					    $query->orLike('file', $searchValue);}

    $totalFiltered = $query->countAllResults(false);

    $query->orderBy($orderBy, $orderDir)
          ->limit($length, $start);

    $results = $query->findAll();
    $totalData = $this->Model->countAll();

    $response = [
        'draw' => intval($draw),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered, 
         'data' => array_map(function($result) { 
         $result['file'] = base_url('uploads/' . $result['file']); 
          return $result; 
                }, 
         $results),  ];

    return $this->response->setJSON($response);
}

//READ
    public function read($id)
	{
		$data = [
			'AttributePage' => $this->PageData,
			'content' => 'Read Pages',
			'data' => $this->Model->find($id) //find on data
		];
		return view('clientes/read_clientes', $data);
    }

    //CREATE
    public function create()
	{
		$data = [
			'AttributePage' => $this->PageData,
			'content' => 'Create Pages',
			'action' => 'Clientes/create_action',
			'data' =>   [
					     'id' => set_value('id'),
					     'nombre' => set_value('nombre'),
					     'email' => set_value('email'),
					     'telefono' => set_value('telefono'),
					     'direccion' => set_value('direccion'),
					     'fecha_nacimiento' => set_value('fecha_nacimiento'),
					     'file' => set_value('file'),
					    ]
		];
		return view('clientes/form_clientes', $data);
    }	
        //UPLOAD FILE
        public function uploadFile($fileInputName)
        {
                $file = $this->request->getFile($fileInputName);
            
               if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $newName);
        return $newName;
    }
            
                return false;
            }	

    //ACTION CREATE
	public function create_action()
	{
    $validation = \Config\Services::validation(); 
	$validation->setRules($this->_rules()); 
		if (!$validation->withRequest($this->request)->run()) { 
	return redirect()->back()->withInput()->with('errors', $validation->getErrors()); 
	}$fileName = $this->uploadFile('file');

   if ($fileName === false) {
        session()->setFlashdata('error', 'Hubo un error al subir el archivo.');
        return redirect()->back()->withInput();
    } 
              $data =[
					     'id' => $this->request->getVar('id'),
					     'nombre' => $this->request->getVar('nombre'),
					     'email' => $this->request->getVar('email'),
					     'telefono' => $this->request->getVar('telefono'),
					     'direccion' => $this->request->getVar('direccion'),
					     'fecha_nacimiento' => $this->request->getVar('fecha_nacimiento'),
					     'file' => $fileName,
        
				];
		$this->Model->save($data);
		session()->setFlashdata('message', 'Create Record Success');
		return redirect()->to(base_url('/Clientes'));
    }
    
    //UPDATE
	public function update($id)
	{
		$dataFind = $this->Model->find($id);
		if($dataFind == false){
			return redirect()->to(base_url('/Clientes'));
		}
		$data = [
			'AttributePage' => $this->PageData,
			'content' => 'Edite Pages',
			'action' => 'clientes/update_action',
			'data' => $this->Model->find($id),
        ];
		session()->setFlashdata('message', 'Update Record Success');
		return view('clientes/form_clientes', $data);
    }
    
    //ACTION UPDATE
   	public function update_action()
	{

       $validation = \Config\Services::validation(); 
		$validation->setRules($this->_rules()); 
		if (!$validation->withRequest($this->request)->run()) { 
	          return redirect()->back()->withInput()->with('errors', $validation->getErrors()); 
	    }

		$id = $this->request->getVar('id');
		$row = $this->Model->find($id); 

        if (!$row) {
            session()->setFlashdata('error', 'Registro no encontrado.');
            return redirect()->to(base_url('clientes'));
        } $fileName = $this->uploadFile('file'); 
    if ($fileName === false) { 
        // Si no se sube un nuevo archivo, mantener el valor existente
        $fileName = $row['file'] ?? null; 
    }  
                $data =[
					     'id' => $id,
					     'nombre' => $this->request->getVar('nombre'),
					     'email' => $this->request->getVar('email'),
					     'telefono' => $this->request->getVar('telefono'),
					     'direccion' => $this->request->getVar('direccion'),
					     'fecha_nacimiento' => $this->request->getVar('fecha_nacimiento'),
					     'file' => $fileName,
                    ];

        if ($this->Model->save($data)) {
                   session()->setFlashdata('message', 'Update Record Success');
        } else {
                   session()->setFlashdata('error', 'Error al actualizar el registro.');
    }
			
			return redirect()->to(base_url('clientes'));
		
	}

    //DELETE
	public function delete($id)
	{
		$row = $this->Model->find(['id' => $id]);
		if ($row) {
            $this->Model->delete($id);
            session()->setFlashdata('message', 'Delete Record Success');
            return redirect()->to(base_url('/clientes'));
        } else {
            session()->setFlashdata('message', 'Record Not Found');
            return redirect()->to(base_url('/clientes'));
        }

    }

    //RULES
    public function _rules() 
    { 
    return [
	'nombre' => 'trim|required',
	'email' => 'trim|required',
	'telefono' => 'trim|required',
	'direccion' => 'trim|required',
	'fecha_nacimiento' => 'trim|required', ]; 
}

}

/* End of file Clientes.php */
 /* Location: ./app/controllers/Clientes.php */
 /* Generated by CX-CRUD 2024-11-26 13:52:30 */