<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Product_unit_model;

class Product_unit extends BaseController {

    //--------------------------------------------------------------------------
    public function index() {

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        } else {
            parent::loadView('product_unit_view');
        }
    }

    //--------------------------------------------------------------------------
    public function fetch_data() {
        $model = new Product_unit_model();
        echo json_encode($model->findAll());
    }

    //--------------------------------------------------------------------------
    public function fetchById() {
        $obj = json_decode($this->request->getPost('jsarray'));
        $model = new Product_unit_model();
        echo json_encode($model->find($obj->unit_id));
    }
    //--------------------------------------------------------------------------
    public function save() {
        $obj = json_decode($this->request->getPost('jsarray'));
        $model = new Product_unit_model();
        $new_id = $model->getNewId();

        $data = [
            'unit_id' => $new_id,
            'unit_name' => $obj->unit_name,
            'unit_note' => $obj->unit_note,
        ];

		if($model->insert($data)==0) {
			if($model->errors()) {
				$errors = $model->errors();
				$msg_validation['valid'] = $errors;
			} else {
				$msg_validation['unit_id'] = $new_id;
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
		$model = new Product_unit_model();

        $data = array(
            'unit_id' => $obj->unit_id,
            'unit_name' => $obj->unit_name,
            'unit_note' => $obj->unit_note,
        );

		if ($model->update($obj->unit_id, $data)) {
            $msg_validation['unit_id'] = $obj->unit_id;
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
        $model = new Product_unit_model();

        if ($model->delete($obj->unit_id)) {
            $msg_validation['valid'] = 'deleted';
            echo json_encode($msg_validation);
        } else {
            $msg_validation['valid'] = 'failed';
            echo json_encode($msg_validation);
        }
    }

    //--------------------------------------------------------------------------
}
