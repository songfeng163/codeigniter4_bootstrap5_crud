<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends BaseController
{
    //-------------------------------------------------------
    public function index()
    {
        helper(['form']);
        echo view('login_view');
    }

    //-------------------------------------------------------
    public function loginAuth()
    {
        $session = session();

        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $userModel->where('email', $email)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'isLoggedIn' => true
                ];

                $session->set($ses_data);
                return redirect()->to('/login/load_dash_board');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');

                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            //$session->set('isLoggedIn', FALSE);
            return redirect()->to('/login');
        }
    }

    //-------------------------------------------------------
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
    //-------------------------------------------------------

    public function load_dash_board()
    {
        parent::loadView('dash_board_view');
    }
}
