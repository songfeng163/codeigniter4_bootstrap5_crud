<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $allowed_login_attempts = 3;

    //-------------------------------------------------------
    public function index()
    {
        helper(['form']);
        echo view('login_view');
    }
    //----------------------------------------------------------------------
    public function check_login_status()
    {
        if (!session()->get('isLoggedIn')) {
            exit(0);
        }
    }

    //-------------------------------------------------------
    public function prevent_login_attempt($user_email)
    {
        $session = session();
        $userModel = new UserModel();
        $user = $userModel->asObject()->where('email', $user_email)->first();
        $previous_attempt = intval($user->login_attempt);
        if ($previous_attempt >$this->allowed_login_attempts) {
            $session->setFlashdata('msg', 'Allowed login attempt exceeded. Pls contact Admin');
            exit('Allowed login attempt exceeded. Pls contact Admin');
            return redirect()->to('/login');
        } else {
            return false;
        }
    }
    //-------------------------------------------------------
    public function clear_login_attempt($user_email)
    {
        $this->check_login_status();
        $userModel = new UserModel();
        $data = array(
            'login_attempt' => 0
        );
        $userModel->where('email', $user_email)
        ->set($data)
        ->update();
    }
    //-------------------------------------------------------
    public function increase_login_attempt($user_email)
    {
        $userModel = new UserModel();
        $user = $userModel->asObject()->where('email', $user_email)->first();
        $new_attempt = intval($user->login_attempt) + 1;
        $data = array(
            'login_attempt' => $new_attempt
        );
        $userModel->where('email', $user_email)
        ->set($data)
        ->update();
    }
    //-------------------------------------------------------
    public function loginAuth()
    {
        $session = session();

        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $userModel->where('email', $email)->first();
        $prev_login_attempt = $this->prevent_login_attempt($email);
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
                $this->clear_login_attempt($email);
                return redirect()->to('/login/load_dash_board');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                $this->increase_login_attempt($email);
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
        $this->check_login_status();
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
    //-------------------------------------------------------
    public function load_dash_board()
    {
        $this->check_login_status();
        parent::loadView('dash_board_view');
    }
    //-------------------------------------------------------
}