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

			echo view('product_cat');
		}
	}
	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('category');
		$builder->select('*');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('category');
		$builder->select('*');
		$builder->where('category_id', $obj->category_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function validate_data() {
		$validation =  \Config\Services::validation();

		$rules  = [
			'category_name'  =>  'required|min_length[2]|max_length[100]',
		];

		$messages = [
				'category_name' => [
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

		$data = array(
			'category_name'			=> $obj->category_name,
			'category_note'			=> $obj->category_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('category');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['cat_id'] = $db->insertID();
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
			'category_id'			=> $obj->category_id,
			'category_name'			=> $obj->category_name,
			'category_note'			=> $obj->category_note,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('category');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('category_id', $obj->category_id);
			$builder->update($data);
			$msg_validation['cat_id'] = $obj->category_id;
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
		$builder = $db->table('category');
		$builder->where('category_id', $obj->product_cat_id);
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

