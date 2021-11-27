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
                    
                    echo view('product');
                }
		
	}

	//--------------------------------------------------------------------------
	public function fetch_data() {
		$db      = \Config\Database::connect();
		$builder = $db->table('product');
		$builder->select('*');
		$builder->join('category', 'category_id = product_category_id', 'left');
		$query = $builder->get();
		echo json_encode($query->getResult());
	}
	//--------------------------------------------------------------------------
	public function fetchById() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('product');
		$builder->select('*');
		$builder->join('category', 'category_id = product_category_id', 'left');
		$builder->where('product_id', $obj->product_id);
		$query = $builder->get();
		echo json_encode($query->getRow());
	}
	//--------------------------------------------------------------------------
	public function validate_data() {
		$validation =  \Config\Services::validation();

		$rules  = [
			'product_name'  =>  'required|min_length[2]|max_length[100]',
			'product_price' =>  'required|decimal',
			'product_category_id' =>  'required'
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

		$data = array(
			'product_name'			=> $obj->product_name,
			'product_price'			=> $obj->product_price,
			'product_category_id'	=> $obj->category_id,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('product');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->insert($data);
			$msg_validation['pr_id'] = $db->insertID();
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
			'product_id'			=> $obj->product_id,
			'product_name'			=> $obj->product_name,
			'product_price'			=> $obj->product_price,
			'product_category_id'	=> $obj->category_id,
		);

		$db      = \Config\Database::connect();
		$builder = $db->table('product');

		$validation = $this->validate_data();

		if ($validation->run($data)) {
			$builder->where('product_id', $obj->product_id);
			$builder->update($data);
			$msg_validation['pr_id'] = $obj->product_id;
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
            $sql = "SELECT category_id as data, concat(category_id, '-', category_name) as value FROM category WHERE category_id LIKE '%" . $_REQUEST['query'] . "%' OR category_name LIKE '%" . $_REQUEST['query'] . "%'";
            $query = $db->query($sql);
        } else {
            $sql = "SELECT category_id as id, concat(category_id, '-', category_name) as name FROM category";
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
	public function update() {
		$model = new Product_model();
		$id = $this->request->getPost('product_id');
		$data = array(
			'product_name'					=> $this->request->getPost('product_name'),
			'product_price'					=> $this->request->getPost('product_price'),
			'product_category_id'			=> $this->request->getPost('product_catetory'),
		);
	}

	//--------------------------------------------------------------------------
	public function delete() {
		$obj = json_decode($this->request->getPost('jsarray'));
		$db      = \Config\Database::connect();
		$builder = $db->table('product');
		$builder->where('product_id', $obj->product_id);
		if($builder->delete()) {
			$msg_validation['valid'] = 'deleted';
			echo json_encode($msg_validation);
			// echo "deleted";
		} else {
			// echo "failed";
			$msg_validation['valid'] = 'failed';
			echo json_encode($msg_validation);
		}

		// $model = new Product_model();
		// $id = $this->request->getPost('product_id');
		// $model->deleteProduct($id);
		// return redirect()->to('/product');
	}
	//--------------------------------------------------------------------------
}

