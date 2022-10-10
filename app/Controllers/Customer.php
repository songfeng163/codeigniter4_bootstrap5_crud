<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Customer_model;
use App\Models\Customer_group_model;

class Customer extends BaseController {
	//--------------------------------------------------------------------------
	public function index() {
		// echo view('main_side_bar');
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {
			parent::loadView('customer_view');
		}
	}
	//--------------------------------------------------------------------------
	function get_customer_group() {
		$model = new Customer_group_model();
		$query = $model->findCustGroupByIdOrName($_REQUEST['query']);

		if ($query->getNumRows() > 0) {
			$result = json_encode($query->getResult('array'));
			$result = '{"query": "'. $_REQUEST['query'] . '", "suggestions":' . $result . '}';
			echo $result;
		} else {
			echo json_encode(array());
		}
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		$model = new Customer_model();
		echo json_encode($model->findAll());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$model = new Customer_model();
		echo json_encode($model->find($obj->cust_id));
	}
	//--------------------------------------------------------------------------
	public function save() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$model = new Customer_model();
		$new_id = $model->getNewId();

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

		if($model->insert($data)==0) {
			if($model->errors()) {
				$errors = $model->errors();
				$msg_validation['valid'] = $errors;
			} else {
				$msg_validation['cust_id'] = $new_id;
				$msg_validation['valid'] = 'Success';
			}
		} else {
			$errors = $model->errors();
			$msg_validation['valid'] = $errors;
		}
		echo json_encode($msg_validation);
	}
	//--------------------------------------------------------------------------
	public function edit() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$model = new Customer_model();

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

		if ($model->update($obj->cust_id, $data)) {
			$msg_validation['cust_id'] = $obj->cust_id;
			$msg_validation['valid'] = 'Success';

		} else {
			$errors = $model->errors();
			$msg_validation['valid'] = $errors;
		}
		echo json_encode($msg_validation);
	}
	//--------------------------------------------------------------------------
	public function delete() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$model = new Customer_model();

		if($model->delete($obj->cust_id)) {
			$msg_validation['valid'] = 'deleted';
			echo json_encode($msg_validation);
		} else {
			$msg_validation['valid'] = 'failed';
			echo json_encode($msg_validation);
		}
	}
	//--------------------------------------------------------------------------
}