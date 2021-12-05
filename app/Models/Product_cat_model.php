<?php
namespace App\Models;

use CodeIgniter\Model;

class Product_cat_model extends Model {

	protected $table = 'tbl_product_category';

	protected $primaryKey = 'pc_id';

	protected $allowedFields = [
        'pc_id', 'pc_name', 'pc_note'
    ];

	//-------------------------------------------------
	public function findProdCategoryByIdOrName($str_search) {
		if (isset($str_search)) {
			$builder = $this->builder();
			$builder->select('pc_id as data, pc_name as value');
			$builder->like('pc_id' , $_REQUEST['query']);
			$builder->orLike('pc_name' , $_REQUEST['query']);
			$query = $builder->get();

		} else {
			$builder = $this->builder();
			$builder->select('pc_id as data, pc_name as value');
			$query = $builder->get();
		}
		return $query;
	}
	//-------------------------------------------------
	public function getNewId() {
		$builder = $this->builder();
		$builder->selectMax('pc_id');
		$query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $max_id = substr($row->pc_id, 2);
            $new_id = $max_id + 1;
            if ($new_id < 10) {
                $new_id = "PC00000" . $new_id;
            } elseif ($new_id < 100) {
                $new_id = "PC0000" . $new_id;
            } elseif ($new_id < 1000) {
                $new_id = "PC000" . $new_id;
            } elseif ($new_id < 10000) {
                $new_id = "PC00" . $new_id;
            } elseif ($new_id < 100000) {
                $new_id = "PC0" . $new_id;
            } else {
                $new_id = "PC" . $new_id;
            }
            return $new_id;
		} else {
			return "PC000001";
		}
	}
	//-------------------------------------------------
}
