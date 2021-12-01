<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Customer extends BaseController {
	//--------------------------------------------------------------------------
	public function index() {
		// echo view('main_side_bar');
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {

			echo view('customer');
		}
	}
	//--------------------------------------------------------------------------
    function get_customer_group() {
		$db = db_connect();
        if (isset($_REQUEST['query'])) {
            $sql = "SELECT id as data, concat(id, '-', group_name) as value FROM tbl_customer_group WHERE id LIKE '%" . $_REQUEST['query'] . "%' OR group_name LIKE '%" . $_REQUEST['query'] . "%'";
            $query = $db->query($sql);
        } else {
            $sql = "SELECT category_id as id, concat(id, '-', group_name) as name FROM tbl_customer";
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
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db  = \Config\Database::connect();
		$builder = $db->table('tbl_customer');
		$builder->select('tbl_customer.id, customer_name, father_name, mother_name, national_id_card_no, present_address, mobile, email_address, credit_limit, tbl_customer.group_id, tbl_customer_group.group_name, tbl_customer.note');
		$builder->join('tbl_customer_group', 'tbl_customer.group_id = tbl_customer_group.id', 'inner');
		$builder->where('tbl_customer.id', $obj->customer_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');
		$builder->select('tbl_customer.id, customer_name, present_address, mobile,  tbl_customer.note');
		$builder->join('tbl_customer_group', 'tbl_customer.group_id = tbl_customer_group.id', 'inner');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function get_new_id() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');
		$builder->selectMax('id');
		$query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $max_id = substr($row->id, 1);
            $new_id = $max_id + 1;
            if ($new_id < 10) {
                $new_id = "C00000" . $new_id;
            } elseif ($new_id < 100) {
                $new_id = "C0000" . $new_id;
            } elseif ($new_id < 1000) {
                $new_id = "C000" . $new_id;
            } elseif ($new_id < 10000) {
                $new_id = "C00" . $new_id;
            } elseif ($new_id < 100000) {
                $new_id = "C0" . $new_id;
            } else {
                $new_id = "C" . $new_id;
            }
            return $new_id;
		} else {
			return "C000001";
		}
	}
	//--------------------------------------------------------------------------
	public function validate_data() {
		$validation =  \Config\Services::validation();

		$rules  = [
			'customer_name'  =>  'required|min_length[2]|max_length[100]',
			'present_address'  =>  'required|min_length[2]|max_length[100]',
			'mobile'  =>  'required|min_length[2]|max_length[100]',
			'group_id'  =>  'required|is_not_unique[tbl_customer_group.id]',
		];

		$messages = [
				'customer_name' => [
				'required' => 'Name is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
				'present_address' => [
				'required' => 'Address is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
				'mobile' => [
				'required' => 'Mobile name is required.',
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
			'customer_name'=> $obj->cust_name,
			'father_name'=> $obj->father_name,
			'mother_name'=> $obj->mother_name,
			'national_id_card_no'=> $obj->nid_no,
			'present_address'=> $obj->present_address,
			'mobile'=> $obj->mobile_no,
			'email_address'=> $obj->email_add,
			'credit_limit'=> $obj->credit_limit,
			'group_id'=> $obj->cust_group_id,
			'note'=> $obj->cust_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['customer_id'] = $new_id;
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
			'id'=> $obj->customer_id,
			'customer_name'=> $obj->cust_name,
			'father_name'=> $obj->father_name,
			'mother_name'=> $obj->mother_name,
			'national_id_card_no'=> $obj->nid_no,
			'present_address'=> $obj->present_address,
			'mobile'=> $obj->mobile_no,
			'email_address'=> $obj->email_add,
			'credit_limit'=> $obj->credit_limit,
			'group_id'=> $obj->cust_group_id,
			'note'=> $obj->cust_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('id', $obj->customer_id);
			$builder->update($data);
			$msg_validation['customer_id'] = $obj->customer_id;
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
		$builder = $db->table('tbl_customer');
		$builder->where('id', $obj->customer_id);
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
