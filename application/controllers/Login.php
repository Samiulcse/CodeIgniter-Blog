<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Login_model', 'auth_model', true);

        if ($this->uri->segment(2) == 'logout') {
            $this->logout();
        } else {
            $this->have_session_user_data();
        }

    }

    private function have_session_user_data()
    {

        if ($this->session->has_userdata('user_name') && $this->session->has_userdata('user_email')) {
            redirect(base_url('Admin'));
        }
    }

    public function index()
    {
        $data['title'] = "User Login";

        $this->load->view('backend/login/header', $data);
        $this->load->view('backend/login/login');
        $this->load->view('backend/login/footer');

    }

    public function login_validation()
    {

        $config = array(
            array(
                'field' => 'user_name',
                'label' => 'Username',
                'rules' => 'trim|xss_clean|required',
                'errors' => array(
                    'required' => 'You have not provided %s.',
                ),
            ),
            array(
                'field' => 'user_pass',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You have not provided %s.',
                ),
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $user_name = $this->input->post('user_name');
            $user_pass = sha1($this->input->post('user_pass'));

            $user_id = $this->auth_model->can_login($user_name, $user_pass);

            if ($user_id) {
                if ($this->set_session_data_user_info($user_id)) {
                    echo json_encode(['redirect' => base_url('admin')]);
                }
            } else {
                $error_message['login_error'] = "Username or Password didn't match";
                echo json_encode(['error' => $error_message]);
            }

        } else {

            $errors['user_name'] = form_error('user_name') ? form_error('user_name') : '';
            $errors['user_pass'] = form_error('user_pass') ? form_error('user_pass') : '';
            echo json_encode(['error' => $errors]);

        }

    }

    // set session data
    private function set_session_data_user_info($user_id)
    {
        $current_user_data = $this->auth_model->get_current_user_data($user_id);
        if ($current_user_data) {
            $session_data = array(
                'user_name' => $current_user_data[0]->username,
                'user_email' => $current_user_data[0]->email,
                'user_id' => $current_user_data[0]->id,
            );
            $this->session->set_userdata($session_data);
            return true;
        } else {
            redirect(base_url());
        }

    }

    // logout user

    public function logout()
    {

        $session_data = array(
            'user_name',
            'user_email',
            'user_id',
        );

        $this->session->unset_userdata($session_data);

        return redirect(base_url());
    }
}
