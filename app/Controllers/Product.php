<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Product_model;

class Product extends BaseController {
	// if user not logged in

	//--------------------------------------------------------------------------
	public function index() {
		// echo view('main_side_bar');
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {
			parent::loadView('product');
		}

	}

	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product');
		$builder->select('*');
		$builder->join('tbl_product_category', 'pc_id = prod_pc_id', 'left');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product');
		$builder->select('tbl_product.*, tbl_product_category.pc_name');
		$builder->join('tbl_product_category', 'pc_id = prod_pc_id', 'left');
		$builder->where('prod_id', $obj->prod_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function get_new_id() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product');
		$builder->selectMax('prod_id');
		$query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $max_id = substr($row->prod_id, 1);
            $new_id = $max_id + 1;
            if ($new_id < 10) {
                $new_id = "P00000" . $new_id;
            } elseif ($new_id < 100) {
                $new_id = "P0000" . $new_id;
            } elseif ($new_id < 1000) {
                $new_id = "P000" . $new_id;
            } elseif ($new_id < 10000) {
                $new_id = "P00" . $new_id;
            } elseif ($new_id < 100000) {
                $new_id = "P0" . $new_id;
            } else {
                $new_id = "P" . $new_id;
            }
            return $new_id;
		} else {
			return "P000001";
		}
	}
	//--------------------------------------------------------------------------
	public function validate_data() {
		$validation =  \Config\Services::validation();

		$rules  = [
			'prod_name'  =>  'required|min_length[2]|max_length[100]',
			'prod_price' =>  'required|decimal',
			'prod_pc_id' =>  'required|is_not_unique[tbl_product_category.pc_id]'
		];

		$messages = [
			'product_name' => [
				'required' => 'Product name is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
		];

		return $validation->setRules($rules, $messages);
	}
	//--------------------------------------------------------------------------
	public function save() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$new_id = $this->get_new_id();

		$data = array(
			'prod_id' => $new_id,
			'prod_name' => $obj->prod_name,
			'prod_price' => $obj->prod_price,
			'prod_pc_id' => $obj->prod_pc_id,
			'prod_note'	=> $obj->prod_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['prod_id'] = $new_id;
			$msg_validation['valid'] = 'Success';

		} else {
			$errors = $validation->listErrors();
			$msg_validation['valid'] = $errors;
		}
		echo json_encode($msg_validation);
	}
	//--------------------------------------------------------------------------
	public function edit() {
		$obj = json_decode($this->request->getPost('jsarray'));

		$data = array(
			'prod_id' => $obj->prod_id,
			'prod_name' => $obj->prod_name,
			'prod_price' => $obj->prod_price,
			'prod_pc_id' => $obj->prod_pc_id,
			'prod_note'	=> $obj->prod_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('prod_id', $obj->prod_id);
			$builder->update($data);
			$msg_validation['prod_id'] = $obj->prod_id;
			$msg_validation['valid'] = 'Success';

		} else {
			$errors = $validation->listErrors();
			$msg_validation['valid'] = $errors;
		}
		echo json_encode($msg_validation);
	}

	//--------------------------------------------------------------------------
	function get_category() {
		$db = db_connect();
		if (isset($_REQUEST['query'])) {
			$sql = "SELECT pc_id as data, pc_name as value FROM tbl_product_category WHERE pc_id LIKE '%" . $_REQUEST['query'] . "%' OR pc_name LIKE '%" . $_REQUEST['query'] . "%'";
			$query = $db->query($sql);
		} else {
			$sql = "SELECT pc_id as id, concat(pc_id, '-', pc_name) as name FROM tbl_product_category";
			$query = $db->query($sql);
		}

		if ($query->getNumRows() > 0) {
			$result = json_encode($query->getResult('array'));
			$result = '{"query": "'. $_REQUEST['query'] . '", "suggestions":' . $result . '}';
			echo $result;
		} else {
			echo json_encode(array());
		}
	}
	//--------------------------------------------------------------------------
	public function delete() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product');
		$builder->where('prod_id', $obj->prod_id);
		if($builder->delete()) {
			$msg_validation['valid'] = 'deleted';
			echo json_encode($msg_validation);
			// echo "deleted";
		} else {
			// echo "failed";
			$msg_validation['valid'] = 'failed';
			echo json_encode($msg_validation);
		}
	}
	//--------------------------------------------------------------------------
}

