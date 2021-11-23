<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_login_lib
{
    public function belum_login()
    {
    	$_this =& get_instance();
    	if ($_this->session->userdata('masuk') != 'arsip_bjb') {
    		redirect('login','refresh');
    	}
    }

    public function sudah_login()
    {
    	$_this =& get_instance();
    	if ($_this->session->userdata('masuk') == 'arsip_bjb') {
    		redirect('Dashboard/Dashboard','refresh');
    	}
    }

}