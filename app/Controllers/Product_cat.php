<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Product_cat extends BaseController {
	//--------------------------------------------------------------------------
	public function index() {
		// echo view('main_side_bar');
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {
			parent::loadView('product_cat');
		}
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product_category');
		$builder->select('*');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product_category');
		$builder->select('*');
		$builder->where('pc_id', $obj->pc_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function get_new_id() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product_category');
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
	//--------------------------------------------------------------------------
	public function validate_data() {
		$validation =  \Config\Services::validation();

		$rules  = [
			'pc_name'  =>  'required|min_length[2]|max_length[100]',
		];

		$messages = [
				'pc_name' => [
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
			'pc_id' => $new_id,
			'pc_name' => $obj->pc_name,
			'pc_note' => $obj->pc_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product_category');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['pc_id'] = $new_id;
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
			'pc_id'			=> $obj->pc_id,
			'pc_name'			=> $obj->pc_name,
			'pc_note'			=> $obj->pc_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product_category');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('pc_id', $obj->pc_id);
			$builder->update($data);
			$msg_validation['pc_id'] = $obj->pc_id;
			$msg_validation['valid'] = 'Success';

		} else {
			$errors = $validation->listErrors();
			$msg_validation['valid'] = $errors;
		}
		echo json_encode($msg_validation);
	}

	//--------------------------------------------------------------------------
	public function delete() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_product_category');
		$builder->where('pc_id', $obj->pc_id);
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

