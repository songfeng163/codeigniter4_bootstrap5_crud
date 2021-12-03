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
			parent::loadView('customer');
		}
	}
	//--------------------------------------------------------------------------
    function get_customer_group() {
		$db = db_connect();
        if (isset($_REQUEST['query'])) {
            $sql = "SELECT cg_id as data, cg_name as value FROM tbl_customer_group WHERE cg_id LIKE '%" . $_REQUEST['query'] . "%' OR cg_name LIKE '%" . $_REQUEST['query'] . "%'";
            $query = $db->query($sql);
        } else {
            $sql = "SELECT cg_id as id, cg_name as name FROM tbl_customer";
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
		$builder->select('*');
		$builder->join('tbl_customer_group', 'cg_id = cust_group_id', 'left');
		$builder->where('tbl_customer.cust_id', $obj->cust_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');
		$builder->select('*');
		$builder->join('tbl_customer_group', 'cg_id = cust_id', 'left');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function get_new_id() {
		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');
		$builder->selectMax('cust_id');
		$query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $max_id = substr($row->cust_id, 1);
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
			'cust_name'  =>  'required|min_length[2]|max_length[100]',
			'cust_pr_address'  =>  'required|min_length[2]|max_length[100]',
			'cust_mobile'  =>  'required|min_length[2]|max_length[100]',
			'cust_group_id'  =>  'required|is_not_unique[tbl_customer_group.cg_id]',
			'cust_credit_limit'  =>  'permit_empty|numeric',
		];

		$messages = [
			'cust_name' => [
				'required' => 'Name is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
			'cust_pr_address' => [
				'required' => 'Address is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
			'cust_mobile' => [
				'required' => 'Mobile No is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
			'cust_group_id' => [
				'required' => 'Group is required.',
				'min_length' => 'Minimum 2 characters.',
				'max_length' => 'Maximum 100 characters.',
			],
			'cust_credit_limit' => [
				'numeric' => 'Credit Limit Must be Number',
			],
		];
		return $validation->setRules($rules, $messages);
	}
	//--------------------------------------------------------------------------
	public function save() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$new_id = $this->get_new_id();

		$data = array(
			'cust_id'=> $new_id,
			'cust_name'=> $obj->cust_name,
			'cust_father_name'=> $obj->cust_father_name,
			'cust_mother_name'=> $obj->cust_mother_name,
			'cust_nid_no'=> $obj->cust_nid_no,
			'cust_pr_address'=> $obj->cust_pr_address,
			'cust_mobile'=> $obj->cust_mobile,
			'cust_email'=> $obj->cust_email,
			'cust_credit_limit'=> $obj->cust_credit_limit,
			'cust_group_id'=> $obj->cust_group_id,
			'cust_note'=> $obj->cust_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['cust_id'] = $new_id;
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
			'cust_id'=> $obj->cust_id,
			'cust_name'=> $obj->cust_name,
			'cust_father_name'=> $obj->cust_father_name,
			'cust_mother_name'=> $obj->cust_mother_name,
			'cust_nid_no'=> $obj->cust_nid_no,
			'cust_pr_address'=> $obj->cust_pr_address,
			'cust_mobile'=> $obj->cust_mobile,
			'cust_email'=> $obj->cust_email,
			'cust_credit_limit'=> $obj->cust_credit_limit,
			'cust_group_id'=> $obj->cust_group_id,
			'cust_note'=> $obj->cust_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('tbl_customer');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('cust_id', $obj->cust_id);
			$builder->update($data);
			$msg_validation['cust_id'] = $obj->cust_id;
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
		$builder->where('cust_id', $obj->cust_id);

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
