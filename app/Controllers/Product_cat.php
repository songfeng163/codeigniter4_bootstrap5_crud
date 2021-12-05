<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Product_cat_model;

class Product_cat extends BaseController {
	//--------------------------------------------------------------------------
	public function index() {
		// echo view('main_side_bar');
		if(!session()->get('isLoggedIn')) {
			return redirect()->to('/login');
		} else {
			parent::loadView('product_cat_view');
		}
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		// $db      = \Config\Database::connect();
		// $builder = $db->table('tbl_product_category');
		// $builder->select('*');
		// $query = $builder->get();
		// echo json_encode($query->getResult());

		$model = new Product_cat_model();
		echo json_encode($model->findAll());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		// $db      = \Config\Database::connect();
		// $builder = $db->table('tbl_product_category');
		// $builder->select('*');
		// $builder->where('pc_id', $obj->pc_id);
		// $query = $builder->get();
		// echo json_encode($query->getRow());

		$model = new Product_cat_model();
		echo json_encode($model->find($obj->pc_id));
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

		$model = new Product_cat_model();
		$new_id = $model->getNewId();

		$data = [
			'pc_id' => $new_id,
			'pc_name' => $obj->pc_name,
			'pc_note' => $obj->pc_note,
		];

		// $db      = \Config\Database::connect();
		// $builder = $db->table('tbl_product_category');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
		 	// $builder->insert($data);

			$model->insert($data);

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

		// $db      = \Config\Database::connect();
		// $builder = $db->table('tbl_product_category');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			// $builder->where('pc_id', $obj->pc_id);
			// $builder->update($data);
			$model = new Product_cat_model();
			$model->update($obj->pc_id, $data);
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
		// $db      = \Config\Database::connect();
		// $builder = $db->table('tbl_product_category');
		// $builder->where('pc_id', $obj->pc_id);
		$model = new Product_cat_model();
		if($model->delete($obj->pc_id)) {
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

