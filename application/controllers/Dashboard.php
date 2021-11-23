<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('user_model');
    $this->cek_login_lib->belum_login();
  }

  public function index()
  {
      $data = ['tot_gudang_arsip'   => $this->user_model->get_data('m_gudang_arsip')->num_rows(),
               'tot_lemari_berkas'  => $this->user_model->get_data('m_lemari_berkas')->num_rows(),
               'tot_rak_arsip'      => $this->user_model->get_data('m_rak_arsip')->num_rows(),
               'tot_dokumen_unit'   => $this->user_model->get_data('m_dokumen_unit')->num_rows()
              ];

      $data['breadcrumb']   = array('Home','Dashboard');
      $data['bclink']       = array('<a href="" title="">','');
      $data['title']        = 'Dashboard';

      $this->template->load('layout/template', 'dashboard', $data);
  }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */