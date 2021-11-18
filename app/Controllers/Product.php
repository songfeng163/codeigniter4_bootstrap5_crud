<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Product_model;
use App\Models\Category_model;

class Product extends Controller {

	public function index() {
		// $data['product'] = $prod_model->get()->join('category', 'category_id=product_category_id', 'left')->orderBy('product_id', 'DESC');
		// $cat_model = new Category_model();
		// $data['category'] = $cat_model->orderBy('category_id', 'DESC')->findAll();

		$db = db_connect();
		// $db->reconnect();
		// $db->close();
		$data = array();

		// $sql = "SELECT * FROM product LEFT JOIN category ON category_id = product_category_id";
		// $query = $db->query($sql);
		// $data['product'] = $query->getResult();
        //
		// $sql = "SELECT * FROM category";
		// $query = $db->query($sql);
		// $data['category'] = $query->getResult();

		// $prod_model = new Product_model();
		// $data['product'] = $prod_model->getProduct->getResult();
		//$cat_model = new Category_model();

		$db      = \Config\Database::connect();
		$builder = $db->table('category');
		$query = $builder->get();
		$data['category'] = $query->getResult();

		$db      = \Config\Database::connect();
		$builder = $db->table('product');
		$builder->select('*');
		$builder->join('category', 'category_id = product_category_id', 'left');
		$query = $builder->get();
		$data['product'] = $query->getResult();

		// echo view('main_side_bar');
		echo view('test_view_1', $data);
	}

	public function save() {
		$model = new Product_model();
		$validation =  \Config\Services::validation();

		$validations  = [
			'product_name'  =>  'required|min_length[2]|max_length[100]',
			'product_price' =>  'required|decimal',
			'product_category' =>  'required',
		];

		$data = array(
			'product_name'			=> $this->request->getPost('product_name'),
			'product_price'			=> $this->request->getPost('product_price'),
			'product_category_id'	=> $this->request->getPost('product_category'),
		);
		if ($this->request->getMethod() === 'post' && $this->validate($validations)) {
			$model->saveProduct($data);
			return redirect()->to('/product');
		} else {
			// $errors = array(
			// 	'error' => $validations->listErrors()
			// );
			// $session()->set($errors);
			// return redirect()->to('/product');
			// echo view('product_view');
			// echo view('product_view', [
            //     'validation' => $this->validator
            // ]);
			$data["validation"] = $validation->getErrors();
			// $session = \Config\Services::session();
			$this->session = \Config\Services::session();
			$this->session->start();
			$this->session->set($data);
			return redirect()->to('/product');
		}
	}

	public function update() {
		$model = new Product_model();
		$id = $this->request->getPost('product_id');
		$data = array(
			'product_name'					=> $this->request->getPost('product_name'),
			'product_price'					=> $this->request->getPost('product_price'),
			'product_category_id'			=> $this->request->getPost('product_catetory'),
		);
	}

	public function delete() {
		$model = new Product_model();
		$id = $this->request->getPost('product_id');
		$model->deleteProduct($id);
		return redirect()->to('/product');
	}
}

