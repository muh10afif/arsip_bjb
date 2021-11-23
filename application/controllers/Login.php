<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
            $this->load->model("user_model");
            $this->load->library('form_validation');
            $this->load->library('session');
    }

    public function index()
    {
        $this->cek_login_lib->sudah_login();
        
        $data["title"] = 'Login Page';

        $this->load->view('v_login', $data);
    }

    public function logout()
    {
        $ms = $this->session->userdata('masuk');
        
        if ($ms == 'arsip_bjb') {
            $this->session->sess_destroy();
            redirect(base_url());  
        } else {
            redirect(base_url());  
        }
    }

    public function cek()
    {
        
        $post = $this->input->post();

        $u = $post['username'];
        $p = $post['password'];

        $username = $this->security->xss_clean(trim(htmlspecialchars($u, ENT_QUOTES))); 
        $password = $this->security->xss_clean(trim(htmlspecialchars($p, ENT_QUOTES))); 

        $user       = $this->user_model;
        $isiUser    = $user->cari_username($username);
        $hasil      = $isiUser->row_array();

        // mengecek username
        if ($isiUser->num_rows() != 0 ) {

            // cek password
            if (password_verify($password, $hasil['password'])) {

                // set session
                $array = array(
                    'masuk'             => 'arsip_bjb',
                    'level'             => $hasil['id_data_level'],
                    'username'          => $hasil['username'],
                    'id_data_user'      => $hasil['id_data_user'],
                    'id_data_pegawai'   => $hasil['id_data_pegawai'],
                    'add_time'          => $hasil['add_time_user'],
                    'unit_kerja'        => $hasil['unit_kerja'],
                    'id_unit_kerja'     => $hasil['id_unit_kerja']
                );
                
                $this->session->set_userdata( $array );

                // berhasil masuk
                echo json_encode(['hasil'   => 'silahkan masuk']);

            }else{

                // password salah
                echo json_encode(['hasil' => 'password salah']);
            }

        }else{

            // username tidak ditemukan
            echo json_encode(['hasil' => 'username tidak ditemukan']);
        }
    }

    // public function sign_in()
    // {
    //     $post = $this->input->post();

    //     $id_data_user = $post['id_data_user'];
    //     $username = $post['username'];
    //     $id_data_pegawai = $post['id_data_pegawai'];
    //     $add_time = $post['add_time'];

    //     $this->session->set_userdata('id_data_user',$id_data_user);
    //     $this->session->set_userdata('username',$username);
    //     $this->session->set_userdata('id_data_pegawai',$id_data_pegawai);
    //     $this->session->set_userdata('add_time',$add_time);

    //     echo "dashboard";
    // }

    public function tes()
    {
        $hash = password_hash('pusat', PASSWORD_DEFAULT);
        echo $hash;

        // if (password_verify('t', $hash2)){
        //     echo "benar";
        // }else{
        //     echo "salah";
        // }
    }

    public function r()
    {
        $user = $this->user_model;
        $isiUser = $user->joinUser1('q','1');
        echo $isiUser;
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */