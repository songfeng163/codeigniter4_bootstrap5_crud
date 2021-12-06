<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Vendor_model;

class Vendor extends BaseController {

    //--------------------------------------------------------------------------
    public function index() {

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        } else {
            parent::loadView('vendor_view');
        }
    }

    //--------------------------------------------------------------------------
    public function fetch_data() {
        $model = new Vendor_model();
        echo json_encode($model->findAll());
    }

    //--------------------------------------------------------------------------
    public function fetchById() {
        $obj = json_decode($this->request->getPost('jsarray'));
        $model = new Vendor_model();
        echo json_encode($model->find($obj->ven_id));
    }
    //--------------------------------------------------------------------------
    public function save() {
        $obj = json_decode($this->request->getPost('jsarray'));
        $model = new Vendor_model();
        $new_id = $model->getNewId();

        $data = [
            'ven_id' => $new_id,
			'ven_name' => $obj->ven_name,
			'ven_org' => $obj->ven_org,
			'ven_addr' => $obj->ven_addr,
			'ven_mobile' => $obj->ven_mobile,
			'ven_email' => $obj->ven_email,
			'ven_note' =>$obj->ven_note,
        ];

		if($model->insert($data)==0) {
			if($model->errors()) {
				$errors = $model->errors();
				$msg_validation['valid'] = $errors;
			} else {
				$msg_validation['ven_id'] = $new_id;
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
		$model = new Vendor_model();

        $data = array(
            'ven_id' => $obj->ven_id,
			'ven_name' => $obj->ven_name,
			'ven_org' => $obj->ven_org,
			'ven_addr' => $obj->ven_addr,
			'ven_mobile' => $obj->ven_mobile,
			'ven_email' => $obj->ven_email,
			'ven_note' =>$obj->ven_note,
        );

		if ($model->update($obj->ven_id, $data)) {
            $msg_validation['ven_id'] = $obj->ven_id;
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
        $model = new Vendor_model();

        if ($model->delete($obj->ven_id)) {
            $msg_validation['valid'] = 'deleted';
            echo json_encode($msg_validation);
        } else {
            $msg_validation['valid'] = 'failed';
            echo json_encode($msg_validation);
        }
    }
    //--------------------------------------------------------------------------
}
