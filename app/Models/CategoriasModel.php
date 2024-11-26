<?php namespace App\Models;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
* Generated by LigatCode
**/
use CodeIgniter\Model;

class CategoriasModel extends Model
{
    protected $table      = 'categorias';
    protected $primaryKey = 'id';
    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['id','nombre','descripcion','fecha']; 

    // GET ALL DATA
    public function getData($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->db->where($this->primaryKey, $id)->first();
    }


}

/* End of file CategoriasModel.php */
/* Location: ./app/models/CategoriasModel.php */
/* Please DO NOT modify this information : */
/* Generated by Ligatcode Codeigniter 4 CRUD Generator 2024-11-26 12:58:47 */