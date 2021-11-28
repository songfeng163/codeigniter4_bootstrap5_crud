<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Customer_group extends BaseController {
	//--------------------------------------------------------------------------
	public function index() {
		// echo view('main_side_bar');
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {

			echo view('customer_group');
		}
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer_group');
		$builder->select('*');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db  = \Config\Database::connect();
		$builder = $db->table('tbl_customer_group');
		$builder->select('*');
		$builder->where('id', $obj->group_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function get_new_id() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer_group');
		$builder->selectMax('id');
		$query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $max_id = substr($row->id, 1);
            $new_id = $max_id + 1;
            if ($new_id < 10) {
                $new_id = "G00000" . $new_id;
            } elseif ($new_id < 100) {
                $new_id = "G0000" . $new_id;
            } elseif ($new_id < 1000) {
                $new_id = "G000" . $new_id;
            } elseif ($new_id < 10000) {
                $new_id = "G00" . $new_id;
            } elseif ($new_id < 100000) {
                $new_id = "G0" . $new_id;
            } else {
                $new_id = "G" . $new_id;
            }
            return $new_id;
		} else {
			return "G000001";
		}
	}
	//--------------------------------------------------------------------------
	public function validate_data() {
		$validation =  \Config\Services::validation();

		$rules  = [
			'group_name'  =>  'required|min_length[2]|max_length[100]',
		];

		$messages = [
				'group_name' => [
				'required' => 'Group name is required.',
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
			'id'=> $new_id,
			'group_name'=> $obj->group_name,
			'note'=> $obj->group_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer_group');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['group_id'] = $new_id;
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

		$data = array (
			'id'=> $obj->group_id,
			'group_name'=> $obj->group_name,
			'note'=> $obj->group_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer_group');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('id', $obj->group_id);
			$builder->update($data);
			$msg_validation['group_id'] = $obj->group_id;
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
		$builder = $db->table('tbl_customer_group');
		$builder->where('id', $obj->cust_group_id);
		if($builder->delete()) {
			$msg_validation['valid'] = 'deleted';
			echo json_encode($msg_validation);
		} else {
			$msg_validation['valid'] = 'failed';
			echo json_encode($msg_validation);
		}
	}
	//--------------------------------------------------------------------------
}
