<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Product_model;
use App\Models\Product_cat_model;

class Product extends BaseController {

	//--------------------------------------------------------------------------
	public function index() {
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {
			parent::loadView('product_view');
		}
	}
	//--------------------------------------------------------------------------
	function get_category() {
		$model = new Product_cat_model();
		$query = $model->findProdCategoryByIdOrName($_REQUEST['query']);

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
		$model = new Product_model();
		echo json_encode($model->findAll());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$model = new Product_model();
		echo json_encode($model->find($obj->prod_id));
	}
	//--------------------------------------------------------------------------
	public function save() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$model = new Product_model();
		$new_id = $model->getNewId();

		$data = array(
			'prod_id' => $new_id,
			'prod_name' => $obj->prod_name,
			'prod_price' => $obj->prod_price,
			'prod_pc_id' => $obj->prod_pc_id,
			'prod_note'	=> $obj->prod_note,
		);

		if($model->insert($data)==0) {
			if($model->errors()) {
				$errors = $model->errors();
				$msg_validation['valid'] = $errors;
			} else {
				$msg_validation['prod_id'] = $new_id;
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
		$model = new Product_model();

		$data = array(
			'prod_id' => $obj->prod_id,
			'prod_name' => $obj->prod_name,
			'prod_price' => $obj->prod_price,
			'prod_pc_id' => $obj->prod_pc_id,
			'prod_note'	=> $obj->prod_note,
		);

		if ($model->update($obj->prod_id, $data)) {
			$msg_validation['prod_id'] = $obj->prod_id;
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
		$model = new Product_model();

		if($model->delete($obj->prod_id)) {
			$msg_validation['valid'] = 'deleted';
			echo json_encode($msg_validation);
		} else {
			$msg_validation['valid'] = 'failed';
			echo json_encode($msg_validation);
		}
	}
	//--------------------------------------------------------------------------
}

