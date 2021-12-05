<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Customer_group_model;

class Customer_group extends BaseController {

    //--------------------------------------------------------------------------
    public function index() {
        
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        } else {
            parent::loadView('customer_group_view');
        }
    }

    //--------------------------------------------------------------------------
    public function fetch_data() {
        $model = new Customer_group_model();
        echo json_encode($model->findAll());
    }

    //--------------------------------------------------------------------------
    public function fetchById() {
        $obj = json_decode($this->request->getPost('jsarray'));
        $model = new Customer_group_model();
        echo json_encode($model->find($obj->cg_id));
    }

    //--------------------------------------------------------------------------
    public function validate_data() {
        $validation = \Config\Services::validation();

        $rules = [
            'cg_name' => 'required|min_length[2]|max_length[100]',
        ];

        $messages = [
            'cg_name' => [
                'required' => 'Group name is required.',
                'min_length' => 'Minimum 2 characters.',
                'max_length' => 'Maximum 100 characters.',
            ],
        ];

        return $validation->setRules($rules, $messages);
    }
    //--------------------------------------------------------------------------
    public function save() {
        $obj = json_decode($this->request->getPost('jsarray'));
        $model = new Customer_group_model();
        $new_id = $model->getNewId();

        $data = [
            'cg_id' => $new_id,
            'cg_name' => $obj->cg_name,
            'cg_note' => $obj->cg_note,
        ];
      
       
        $validation = $this->validate_data();

        if ($validation->run($data)) {
            
            $model->insert($data);
            
            $msg_validation['cg_id'] = $new_id;
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
            'cg_id' => $obj->cg_id,
            'cg_name' => $obj->cg_name,
            'cg_note' => $obj->cg_note,
        );

        $validation = $this->validate_data();

        if ($validation->run($data)) {
            $model = new Customer_group_model();
            $model->update($obj->cg_id, $data);

            $msg_validation['cg_id'] = $obj->cg_id;
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
        $model = new Customer_group_model();

        if ($model->delete($obj->cg_id)) {
            $msg_validation['valid'] = 'deleted';
            echo json_encode($msg_validation);
        } else {
            $msg_validation['valid'] = 'failed';
            echo json_encode($msg_validation);
        }
    }

    //--------------------------------------------------------------------------
}
