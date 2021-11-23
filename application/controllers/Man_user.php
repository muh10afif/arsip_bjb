<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Man_user extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
        // $user = $this->user_model;
        // $user->cekLogin();
        $this->cek_login_lib->belum_login();
    }

    public function index()
    {
        $this->level();
    }

    /*****************************************************************************************************/
    /*
    /*                                              LEVEL
    /*
    /*****************************************************************************************************/

    public function level()
    {

        $data['breadcrumb'] = array('Home','Managemen User','Data Level');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = "Data Level";

        $this->template->load('layout/template', 'man_user/level/V_level', $data);
    }

    public function tampil_kode_level()
    {
        // cari kode level 
        $hasil = $this->user_model->get_data_order('m_data_level', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_level'] != '') {

          // ambil angka urut terakhir 
          $angka_urut = substr($hasil['kode_level'], 4);

          $au = $angka_urut + 1;

          $au = str_pad($au, 5, 0, STR_PAD_LEFT);

          $kode = "LVEL".$au;

        } else {

          $kode ="LVEL00001";

        }

        echo json_encode(['kode_level'  => $kode]);
    }

    // menampilkan data level
    public function tampil_level()
    {
        $list = $this->user_model->get_data_level();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['kode_level'];
            $tbody[]    = $o['nama_level'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-level' data-id='".$o['id_data_level']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-level' data-id='".$o['id_data_level']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->user_model->jumlah_semua_level(),
                    "recordsFiltered"  => $this->user_model->jumlah_filter_level(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi level 
    public function aksi_level()
    {
        $kode_level   = $this->input->post('kode_level');
        $nama_level   = $this->input->post('nama_level');
        $aksi         = $this->input->post('aksi');
        $id_level     = $this->input->post('id_level');
        
        $data = ['kode_level' => $kode_level,
                 'nama_level' => $nama_level
                ];

        if ($aksi == 'Tambah') {
            $this->user_model->input_data('m_data_level', $data);
        } elseif ($aksi == 'Edit') {
            $this->user_model->ubah_data('m_data_level', $data, array('id_data_level' => $id_level));
        } else {
            $this->user_model->hapus_data('m_data_level', array('id_data_level' => $id_level));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data level
    public function ambil_data_level($id_level)
    {
        $data = $this->user_model->cari_data('m_data_level', array('id_data_level' => $id_level))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Jabatan
    /*
    /*****************************************************************************************************/

    public function jabatan()
    {

        $data['breadcrumb'] = array('Home','Managemen User','Data Jabatan');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = "Data Jabatan";
        $data['unit_kerja'] = $this->user_model->get_data('m_unit_kerja')->result_array();
        $data['level']      = $this->user_model->get_data('m_data_level')->result_array();

        $this->template->load('layout/template', 'man_user/jabatan/V_jabatan', $data);
    }

    public function tampil_kode_jabatan()
    {
      // cari kode level 
      $hasil = $this->user_model->get_data_order('m_data_jabatan', 'add_time', 'desc')->row_array(); 

      if ($hasil['kode_jabatan'] != '') {

        // ambil angka urut terakhir 
        $angka_urut = substr($hasil['kode_jabatan'], 4);

        $au = $angka_urut + 1;

        $au = str_pad($au, 5, 0, STR_PAD_LEFT);

        $kode = "JBTN".$au;

      } else {

        $kode ="JBTN00001";

      }

      echo json_encode(['kode_jabatan'  => $kode]);
    }

    // menampilkan data jabatan
    public function tampil_jabatan()
    {
        $list = $this->user_model->get_data_jabatan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['kode_jabatan'];
            $tbody[]    = $o['nama_jabatan'];
            $level = $this->session->userdata('level');

            if ($level == 1) {
              $tbody[]    = $o['unit_kerja'];
            }

            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-jabatan' data-id='".$o['id_data_jabatan']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-jabatan' data-id='".$o['id_data_jabatan']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->user_model->jumlah_semua_jabatan(),
                    "recordsFiltered"  => $this->user_model->jumlah_filter_jabatan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi jabatan 
    public function aksi_jabatan()
    {
        $nama_jabatan     = $this->input->post('nama_jabatan');
        $kode_jabatan     = $this->input->post('kode_jabatan');

        $level          = $this->session->userdata('level');
        $id_unit_kerja  = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
          $unit_kerja       = $id_unit_kerja;
        } elseif ($level == 1) {
          $unit_kerja       = $this->input->post('unit_kerja');
        }

        $unit_kerja_input = $this->input->post('unit_kerja_input');
        $unit_kerja_edit  = $this->input->post('unit_kerja_edit');
        $lokasi           = $this->input->post('lokasi');
        $level            = $this->input->post('level');
        $aksi             = $this->input->post('aksi');
        $id_data_jabatan  = $this->input->post('id_data_jabatan');

        // cari kode level 
        $hasil = $this->user_model->get_data_order('m_unit_kerja', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_unit_kerja'] != '') {

          // ambil angka urut terakhir 
          $angka_urut = substr($hasil['kode_unit_kerja'], 4);

          $au = $angka_urut + 1;

          $au = str_pad($au, 5, 0, STR_PAD_LEFT);

          $kode_unit_kerja = "UNTK".$au;

        } else {

          $kode_unit_kerja ="UNTK00001";

        }
        
        $data = ['nama_jabatan'   => $nama_jabatan,
                 'kode_jabatan'   => $kode_jabatan,
                 'id_unit_kerja'  => $unit_kerja
                ];

        $data_unit = ['kode_unit_kerja' => $kode_unit_kerja,
                      'unit_kerja'      => $unit_kerja_input,
                      'lokasi'          => $lokasi,
                      'id_data_level'   => $level
                    ];

        if ($aksi == 'Tambah') {

            if ($unit_kerja_input != '') {

              $this->user_model->input_data('m_unit_kerja', $data_unit);

              $id_unit_kerja = $this->db->insert_id();
              
              $data_jab = ['nama_jabatan'   => $nama_jabatan,
                           'kode_jabatan'   => $kode_jabatan,
                           'id_unit_kerja'  => $id_unit_kerja
                          ];

              $this->user_model->input_data('m_data_jabatan', $data_jab);

            } else {

              $this->user_model->input_data('m_data_jabatan', $data);
            }

        } elseif ($aksi == 'Edit') {

          // $data_edit = ['nama_jabatan'   => $nama_jabatan,
          //               'kode_jabatan'   => $kode_jabatan,
          //               'id_unit_kerja'  => $unit_kerja_edit
          //             ];

          if ($unit_kerja_input != '') {

            $this->user_model->input_data('m_unit_kerja', $data_unit);

            $id_unit_kerja = $this->db->insert_id();
            
            $data_jab = ['nama_jabatan'   => $nama_jabatan,
                         'kode_jabatan'   => $kode_jabatan,
                         'id_unit_kerja'  => $id_unit_kerja
                        ];

            $this->user_model->ubah_data('m_data_jabatan', $data_jab, array('id_data_jabatan' => $id_data_jabatan));

          } else {

            $this->user_model->ubah_data('m_data_jabatan', $data, array('id_data_jabatan' => $id_data_jabatan));
          }

            
        } else {
            $this->user_model->hapus_data('m_data_jabatan', array('id_data_jabatan' => $id_data_jabatan));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data jabatan
    public function ambil_data_jabatan($id_data_jabatan)
    {
        $data = $this->user_model->cari_data('m_data_jabatan', array('id_data_jabatan' => $id_data_jabatan))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Pegawai
    /*
    /*****************************************************************************************************/

    public function pegawai()
    {
        $data['breadcrumb'] = array('Home','Managemen User','Data Pegawai');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = "Data Pegawai";
        $data['unit_kerja'] = $this->user_model->get_data('m_unit_kerja')->result_array();
        $data['level']      = $this->user_model->get_data('m_data_level')->result_array();

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
          $data['jabatan']    = $this->user_model->cari_data('m_data_jabatan', array('id_unit_kerja' => $id_unit_kerja))->result_array();
        } else {
          $data['jabatan']    = $this->user_model->get_data('m_data_jabatan')->result_array();
        }

        $this->template->load('layout/template', 'man_user/pegawai/V_pegawai', $data);
    }

    public function tampil_reg_emp()
    {
      // cari kode level 
      $hasil = $this->user_model->get_data_order('m_data_pegawai', 'add_time', 'desc')->row_array(); 

      if ($hasil['reg_employee'] != '') {

        // ambil angka urut terakhir 
        $angka_urut = substr($hasil['reg_employee'], 4);

        $au = $angka_urut + 1;

        $au = str_pad($au, 5, 0, STR_PAD_LEFT);

        $kode = "REGM".$au;

      } else {

        $kode ="REGM00001";

      }

      echo json_encode(['reg_emp' => $kode]);
    }

    // menampilkan data pegawai
    public function tampil_pegawai()
    {
        $list = $this->user_model->get_data_pegawai();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['reg_employee'];
            $tbody[]    = $o['nama_pegawai'];
            $tbody[]    = $o['nama_jabatan'];
            $tbody[]    = $o['no_telp'];
            $tbody[]    = $o['email'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-primary btn-sm mr-3 detail-pegawai' data-id='".$o['id_data_pegawai']."'>Detail</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-pegawai' data-id='".$o['id_data_pegawai']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-pegawai' data-id='".$o['id_data_pegawai']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->user_model->jumlah_semua_pegawai(),
                    "recordsFiltered"  => $this->user_model->jumlah_filter_pegawai(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi pegawai 
    public function aksi_pegawai()
    {
        $id_pegawai       = $this->input->post('id_pegawai');
        $reg_emp          = $this->input->post('reg_emp');
        $nama_pegawai     = $this->input->post('nama_pegawai');
        $nik              = $this->input->post('nik');
        $tgl_lahir        = nice_date($this->input->post('tgl_lahir'), 'Y-m-d');
        $no_telp          = $this->input->post('no_telp');
        $email            = $this->input->post('email');

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
          $unit_kerja    = $id_unit_kerja;
        } elseif ($level == 1) {
          $unit_kerja    = $this->input->post('unit_kerja');
        }
        
        $unit_kerja_input = $this->input->post('unit_kerja_input');
        $lokasi           = $this->input->post('lokasi');
        $level            = $this->input->post('level');
        $jabatan          = $this->input->post('jabatan');
        $jabatan_input    = $this->input->post('jabatan_input');
        $alamat           = $this->input->post('alamat');
        $aksi             = $this->input->post('aksi');
        
        $data = ['reg_employee'   => $reg_emp,
                 'nik'            => $nik,
                 'nama_pegawai'   => $nama_pegawai,
                 'tgl_lahir'      => $tgl_lahir,
                 'no_telp'        => $no_telp,
                 'email'          => $email,
                 'alamat'         => $alamat,
                 'id_data_jabatan'=> $jabatan,
                 'id_unit_kerja'  => $unit_kerja
                ];

        // cari kode level 
        $hasil = $this->user_model->get_data_order('m_unit_kerja', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_unit_kerja'] != '') {

          // ambil angka urut terakhir 
          $angka_urut = substr($hasil['kode_unit_kerja'], 4);

          $au = $angka_urut + 1;

          $au = str_pad($au, 5, 0, STR_PAD_LEFT);

          $kode_unit_kerja = "UNTK".$au;

        } else {

          $kode_unit_kerja ="UNTK00001";

        }

        // cari kode level 
        $hasil = $this->user_model->get_data_order('m_data_jabatan', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_jabatan'] != '') {

          // ambil angka urut terakhir 
          $angka_urut = substr($hasil['kode_jabatan'], 4);

          $au = $angka_urut + 1;

          $au = str_pad($au, 5, 0, STR_PAD_LEFT);

          $kode_jabatan = "JBTN".$au;

        } else {

          $kode_jabatan ="JBTN00001";

        }

        $data_unit = ['kode_unit_kerja' => $kode_unit_kerja,
                      'unit_kerja'      => $unit_kerja_input,
                      'lokasi'          => $lokasi,
                      'id_data_level'   => $level
                    ];

        $data_jabatan = [ 'kode_jabatan'  => $kode_jabatan,
                          'nama_jabatan'  => $jabatan_input
                        ];

        if ($aksi == 'Tambah') {
            
          if ($unit_kerja_input != '' || $jabatan_input != '') {

            if ($unit_kerja_input != '') {
              $this->user_model->input_data('m_unit_kerja', $data_unit);

              $id_unit_kerja = $this->db->insert_id();
            } else {

              $id_unit_kerja = $unit_kerja;
            }

            if ($jabatan_input != '') {
              $this->user_model->input_data('m_data_jabatan', $data_jabatan);

              $id_jabatan = $this->db->insert_id();
            } else {

              $id_jabatan = $jabatan;
            }
            
            $data_unit_jab = ['reg_employee'   => $reg_emp,
                              'nik'            => $nik,
                              'nama_pegawai'   => $nama_pegawai,
                              'tgl_lahir'      => $tgl_lahir,
                              'no_telp'        => $no_telp,
                              'email'          => $email,
                              'alamat'         => $alamat,
                              'id_data_jabatan'=> $id_jabatan,
                              'id_unit_kerja'  => $id_unit_kerja
                              ];

            $this->user_model->input_data('m_data_pegawai', $data_unit_jab);

            $id_pegawai = $this->db->insert_id();
            
            // cari id unit

            $dt = $this->user_model->cari_data('m_data_pegawai', array('id_data_pegawai' => $id_pegawai))->row_array();

            // cari id jabatan

            $this->user_model->ubah_data('m_data_jabatan', array('id_unit_kerja'  => $dt['id_unit_kerja']) ,array('id_data_jabatan' => $dt['id_data_jabatan']));

          } else {

            $this->user_model->input_data('m_data_pegawai', $data);
          }

            
        } elseif ($aksi == 'Edit') {

          if ($unit_kerja_input != '' || $jabatan_input != '') {

            if ($unit_kerja_input != '') {
              $this->user_model->input_data('m_unit_kerja', $data_unit);

              $id_unit_kerja = $this->db->insert_id();
            } else {

              $id_unit_kerja = $unit_kerja;
            }

            if ($jabatan_input != '') {
              $this->user_model->input_data('m_data_jabatan', $data_jabatan);

              $id_jabatan = $this->db->insert_id();
            } else {

              $id_jabatan = $jabatan;
            }
            
            $data_unit_jab = ['reg_employee'   => $reg_emp,
                              'nik'            => $nik,
                              'nama_pegawai'   => $nama_pegawai,
                              'tgl_lahir'      => $tgl_lahir,
                              'no_telp'        => $no_telp,
                              'email'          => $email,
                              'alamat'         => $alamat,
                              'id_data_jabatan'=> $id_jabatan,
                              'id_unit_kerja'  => $id_unit_kerja
                              ];

            $this->user_model->ubah_data('m_data_pegawai', $data_unit_jab, array('id_data_pegawai' => $id_pegawai));
            
            // cari id unit

            $dt = $this->user_model->cari_data('m_data_pegawai', array('id_data_pegawai' => $id_pegawai))->row_array();

            // cari id jabatan

            $this->user_model->ubah_data('m_data_jabatan', array('id_unit_kerja'  => $dt['id_unit_kerja']) ,array('id_data_jabatan' => $dt['id_data_jabatan']));

          } else {

            $this->user_model->ubah_data('m_data_pegawai', $data, array('id_data_pegawai' => $id_pegawai));
          }

        } else {
            $this->user_model->hapus_data('m_data_pegawai', array('id_data_pegawai' => $id_pegawai));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data pegawai
    public function ambil_data_pegawai($id_data_pegawai)
    {
        $data = $this->user_model->cari_data('m_data_pegawai', array('id_data_pegawai' => $id_data_pegawai))->row_array();

        $uk   = $this->user_model->cari_data('m_unit_kerja', array('id_unit_kerja'  => $data['id_unit_kerja']))->row_array();

        $jb   = $this->user_model->cari_data('m_data_jabatan', array('id_data_jabatan'  => $data['id_data_jabatan']))->row_array();

        array_push($data, array('tgl_lahir' => nice_date($data['tgl_lahir'], 'd-F-Y'), 'nm_unit' => $uk['unit_kerja'], 'nm_jabatan'  => $jb['nama_jabatan']));

        echo json_encode($data);
    }

    // ambil jabatan
    public function ambil_jabatan()
    {
        $id_unit_kerja = $this->input->post('id_unit_kerja');

        if ($id_unit_kerja == "") {

            $option   = "";

            $pegawai  = "";

            $reg_emp  = "";

        } else {

          $list_as = $this->user_model->cari_data('m_data_jabatan', array('id_unit_kerja' => $id_unit_kerja))->result_array();

          $option = "<option value=''>Pilih Jabatan</option>";

          foreach ($list_as as $a) {
            $option .= "<option value='".$a['id_data_jabatan']."'>".$a['nama_jabatan']."</option>";
          }

          $pegawai  = "";

          $reg_emp  = "";

        }

        $data = ['jabatan'    => $option, 'pegawai' => $pegawai, 'reg_emp'  => $reg_emp];

        echo json_encode($data);
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              User
    /*
    /*****************************************************************************************************/

    public function user()
    {
        $data['breadcrumb'] = array('Home','Managemen User','Data User');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = "Data User";
        $data['unit']       = $this->user_model->get_data_unit()->result_array();

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
          $data['jabatan']    = $this->user_model->cari_data('m_data_jabatan', array('id_unit_kerja' => $id_unit_kerja))->result_array();
        } else {
          $data['jabatan']    = $this->user_model->get_data('m_data_jabatan')->result_array();
        }

        $this->template->load('layout/template', 'man_user/user/V_user', $data);
    }

    // menampilkan data user
    public function tampil_user()
    {
        $list = $this->user_model->get_data_user();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['reg_employee'];
            $tbody[]    = $o['nama_pegawai'];
            $tbody[]    = $o['nama_level'];
            $tbody[]    = $o['username'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-user' data-id='".$o['id_data_user']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-user' data-id='".$o['id_data_user']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->user_model->jumlah_semua_user(),
                    "recordsFiltered"  => $this->user_model->jumlah_filter_user(),   
                    "data"             => $data
                  ];

        echo json_encode($output);
    }

    // aksi user 
    public function aksi_user()
    {
        $username         = $this->input->post('username');
        $password         = $this->input->post('password');
        $id_data_pegawai  = $this->input->post('nm_pegawai');
        $aksi             = $this->input->post('aksi');
        $id_data_user     = $this->input->post('id_data_user');
        $username_edit    = $this->input->post('username_edit');
        $password_edit    = $this->input->post('password_edit');
        
        $data = ['username'         => $username,
                 'password'         => password_hash($password, PASSWORD_DEFAULT),
                 'id_data_pegawai'  => $id_data_pegawai
                ];

        if ($aksi == 'Tambah') {
            $this->user_model->input_data('m_data_user', $data);
        } elseif ($aksi == 'Edit') {

            if ($password_edit != '') {
                $data1 = ['username'  => $username_edit,
                          'password'  => password_hash($password_edit, PASSWORD_DEFAULT)
                          ];
            } else {
                $data1 = ['username'  => $username_edit];
            }

            $this->user_model->ubah_data('m_data_user', $data1, array('id_data_user' => $id_data_user));
        } else {

            $this->user_model->hapus_data('m_data_user', array('id_data_user' => $id_data_user));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data user
    public function ambil_data_user($id_data_user)
    {
        $dt = $this->user_model->cari_data_user($id_data_user)->row_array();

        $data = ['username'     => $dt['username'],
                 'password'     => $dt['password'],
                 'unit_kerja'   => $dt['unit_kerja'],
                 'jabatan'      => $dt['nama_jabatan'],
                 'reg_emp'      => $dt['reg_employee'],
                 'nm_pegawai'   => $dt['nama_pegawai'],
                 'id_data_user' => $dt['id_data_user']
                ];

        echo json_encode($data);
    }

    public function ambil_nama_pegawai()
    {
      $level          = $this->session->userdata('level');
      $id_unit_kerja2  = $this->session->userdata('id_unit_kerja');

      if ($level == 2) {
        $id_unit_kerja  = $id_unit_kerja2;
      } elseif ($level == 1) {
        $id_unit_kerja  = $this->input->post('id_unit_kerja');
      }

      $id_jabatan     = $this->input->post('id_jabatan');

      if ($id_jabatan == "") {

        $option = "";

      } else {

        $list_as = $this->user_model->cari_data_pegawai($id_unit_kerja, $id_jabatan)->result_array();

        $option = "<option value=''>Pilih Nama Pegawai</option>";

        foreach ($list_as as $a) {
          $option .= "<option value='".$a['id_data_pegawai']."'>".$a['nama_pegawai']."</option>";
        }

      }

      $data = ['pegawai'    => $option];

      echo json_encode($data);
    }

    // ambil reg employee
    public function ambil_reg_emp()
    {
        $id_data_pegawai = $this->input->post('id_data_pegawai');

        $option = "";

        if ($id_data_pegawai == "") {

          $option = "";

        } else {

          $list_as = $this->user_model->cari_data('m_data_pegawai', array('id_data_pegawai' => $id_data_pegawai))->row_array();

          $option = $list_as['reg_employee'];

        }

        $data = ['reg_emp'  => $option];

        echo json_encode($data);
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Unit Kerja
    /*
    /*****************************************************************************************************/

    public function unit_kerja()
    {
        $data['breadcrumb'] = array('Home','Managemen User','Data Unit Kerja');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = "Data Unit Kerja";
        $data['level']      = $this->user_model->get_data('m_data_level')->result_array();

        $this->template->load('layout/template', 'man_user/unit_kerja/V_unit_kerja', $data);
    }

    public function tampil_kode_unit_kerja()
    {
      // cari kode level 
      $hasil = $this->user_model->get_data_order('m_unit_kerja', 'add_time', 'desc')->row_array(); 

      if ($hasil['kode_unit_kerja'] != '') {

        // ambil angka urut terakhir 
        $angka_urut = substr($hasil['kode_unit_kerja'], 4);

        $au = $angka_urut + 1;

        $au = str_pad($au, 5, 0, STR_PAD_LEFT);

        $kode_unit_kerja = "UNTK".$au;

      } else {

        $kode_unit_kerja ="UNTK00001";

      }

      echo json_encode(['kode_unit_kerja' => $kode_unit_kerja]);
    }

    // menampilkan data unit_kerja
    public function tampil_unit_kerja()
    {
        $list = $this->user_model->get_data_unit_kerja();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_unit_kerja'];
            $tbody[]    = $o['unit_kerja'];
            $tbody[]    = $o['lokasi'];
            $tbody[]    = $o['nama_level'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-unit-kerja' data-id='".$o['id_unit_kerja']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-unit-kerja' data-id='".$o['id_unit_kerja']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->user_model->jumlah_semua_unit_kerja(),
                    "recordsFiltered"  => $this->user_model->jumlah_filter_unit_kerja(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi unit_kerja 
    public function aksi_unit_kerja()
    {
        $id_unit_kerja    = $this->input->post('id_unit_kerja');
        $kode_unit_kerja  = $this->input->post('kode_unit_kerja');
        $unit_kerja       = $this->input->post('nama_unit_kerja');
        $lokasi           = $this->input->post('lokasi');
        $level            = $this->input->post('level');
        $aksi             = $this->input->post('aksi');
        
        $data = ['kode_unit_kerja'  => $kode_unit_kerja,
                 'unit_kerja'       => $unit_kerja,
                 'lokasi'           => $lokasi,
                 'id_data_level'    => $level
                ];

        if ($aksi == 'Tambah') {
            $this->user_model->input_data('m_unit_kerja', $data);
        } elseif ($aksi == 'Edit') {
            $this->user_model->ubah_data('m_unit_kerja', $data, array('id_unit_kerja' => $id_unit_kerja));
        } else {
            $this->user_model->hapus_data('m_unit_kerja', array('id_unit_kerja' => $id_unit_kerja));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data user
    public function ambil_data_unit_kerja($id_unit_kerja)
    {
        $data = $this->user_model->cari_data('m_unit_kerja', array('id_unit_kerja' => $id_unit_kerja))->row_array();

        echo json_encode($data);
    }


    //LEVEL CRUD START
    public function addLevel()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kodeLevel','Kode Level', 'required');
        $this->form_validation->set_rules('namaLevel','Nama Level', 'required');

        if ($this->form_validation->run()) {
          $data['id_data_level'] = mt_rand(100000, 999999);
          $data['kode_level'] = $this->input->post('kodeLevel');
          $data['nama_level'] = $this->input->post('namaLevel');
          $data['add_time'] = date('Y-m-d H:i:s');

          $this->user_model->insert('m_data_level',$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function level2()
    {
        $data['breadcrumb'] = array('Home','Managemen User','Data Level');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = "Data Level";

        $this->load->view('man_user/dat_level', $data);
    }

    public function getLevel($id)
    {
      $row = $this->user_model->getById('m_data_level','id_data_level',$id);
      echo json_encode($row);
    }
    public function editLevel()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kodeLevel','Kode Level', 'required');
        $this->form_validation->set_rules('namaLevel','Nama Level', 'required');

        if ($this->form_validation->run()) {
          $data['id_data_level'] = $this->input->post('id');
          $data['kode_level'] = $this->input->post('kodeLevel');
          $data['nama_level'] = $this->input->post('namaLevel');
          $data['add_time'] = $this->input->post('date');

          $this->user_model->update('m_data_level','id_data_level',$data['id_data_level'],$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function deleteLevel($id=null)
    {
        if (!isset($id)){show_404();}
        if ($this->user_model->delete('m_data_level','id_data_level',$id)) {
          echo "Success";
        }else{
          echo "Error";
        }
    }
    //LEVEL CRUD END

    //JABATAN CRUD START
    public function addJabatan()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('selectUnit','Unit Kerja', 'required');
        $this->form_validation->set_rules('kodeJabatan','Kode Jabatan', 'required');
        $this->form_validation->set_rules('namaJabatan','Nama Jabatan', 'required');

        if ($this->form_validation->run()) {
          $data['id_data_jabatan'] = mt_rand(100000, 999999);
          $data['kode_jabatan'] = $this->input->post('kodeJabatan');
          $data['nama_jabatan'] = $this->input->post('namaJabatan');
          $data['id_unit_kerja'] = $this->input->post('selectUnit');
          $data['add_time'] = date('Y-m-d H:i:s');

          $this->user_model->insert('m_data_jabatan',$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function Jabatan2()
    {
        $data['unit'] = $this->user_model->get('m_unit_kerja');
        $data['jabatan'] = $this->user_model->getby('m_data_jabatan','add_time');
        $data['breadcrumb'] = array('Home','Managemen User','Data Jabatan');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="level" title="">','');
        $data['title'] = "Data Jabatan";
        $this->load->view('man_user/dat_jabatan', $data);
    }

    public function getJabatan($id)
    {
      $row = $this->user_model->getById('m_data_jabatan','id_data_jabatan',$id);
      echo json_encode($row);
    }
    public function editJabatan()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('selectUnit','Unit Kerja', 'required');
        $this->form_validation->set_rules('kodeJabatan','Kode Jabatan', 'required');
        $this->form_validation->set_rules('namaJabatan','Nama Jabatan', 'required');

        if ($this->form_validation->run()) {
          $data['id_data_jabatan'] = $this->input->post('id');
          $data['kode_jabatan'] = $this->input->post('kodeJabatan');
          $data['nama_jabatan'] = $this->input->post('namaJabatan');
          $data['add_time'] = $this->input->post('date');

          $this->user_model->update('m_data_jabatan','id_data_jabatan',$data['id_data_jabatan'],$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function deleteJabatan($id=null)
    {
        if (!isset($id)){show_404();}
        if ($this->user_model->delete('m_data_jabatan','id_data_jabatan',$id)) {
          echo "Success";
        }else{
          echo "Error";
        }
    }
    //JABATAN CRUD END


    //USER CRUD START
    public function addUser()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kodeUser','Kode User', 'required');
        $this->form_validation->set_rules('namaUser','Nama User', 'required');

        if ($this->form_validation->run()) {
          $data['id_data_user'] = mt_rand(100000, 999999);
          $data['kode_user'] = $this->input->post('kodeUser');
          $data['nama_user'] = $this->input->post('namaUser');
          $data['add_time'] = date('Y-m-d H:i:s');

          $this->user_model->insert('m_data_level',$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function user2()
    {
        $data['level'] = $this->user_model->getby('m_data_level','add_time');
        $data['breadcrumb'] = array('Home','Managemen User','Data Level');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title'] = "Data Level";
        $this->load->view('man_user/dat_level', $data);

        $data['user'] = $this->user_model->get('m_data_user');
        $data['breadcrumb'] = array('Home','Managemen User','Data User');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="level" title="">','');
        $data['title'] = "Data User";
        $this->load->view('man_user/dat_user', $data);
    }

    public function getUser($id)
    {
      $row = $this->user_model->getById('m_data_level','id_data_level',$id);
      echo json_encode($row);
    }
    public function editUser()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kodeLevel','Kode Level', 'required');
        $this->form_validation->set_rules('namaLevel','Nama Level', 'required');

        if ($this->form_validation->run()) {
          $data['id_data_level'] = $this->input->post('id');
          $data['kode_level'] = $this->input->post('kodeLevel');
          $data['nama_level'] = $this->input->post('namaLevel');
          $data['add_time'] = $this->input->post('date');

          $this->user_model->update('m_data_level','id_data_level',$data['id_data_level'],$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function deleteUser($id=null)
    {
        if (!isset($id)){show_404();}
        if ($this->user_model->delete('m_data_level','id_data_level',$id)) {
          echo "Success";
        }else{
          echo "Error";
        }
    }
    //USER CRUD END

    

    //UNIT KERJA CRUD START
    public function addUnit()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kodeUnit','Kode Unit', 'required');
        $this->form_validation->set_rules('namaUnit','Nama Unit', 'required');
        $this->form_validation->set_rules('lokasiUnit','Lokasi Unit', 'required');

        if ($this->form_validation->run()) {
          $data['id_unit_kerja'] = mt_rand(100000, 999999);
          $data['kode_unit_kerja'] = $this->input->post('kodeUnit');
          $data['unit_kerja'] = $this->input->post('namaUnit');
          $data['lokasi'] = $this->input->post('lokasiUnit');
          $data['add_time'] = date('Y-m-d H:i:s');

          $this->user_model->insert('m_unit_kerja',$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function unit2()
    {
        $data['unit'] = $this->user_model->getby('m_unit_kerja','add_time');
        $data['level'] = $this->user_model->getby('m_data_level','add_time');
        $data['breadcrumb'] = array('Home','Managemen User','Data Unit');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="level" title="">','');
        $data['title'] = "Data unit";
        $this->load->view('man_user/dat_unit', $data);
    }

    public function getUnit($id)
    {
      $row = $this->user_model->getById('m_unit_kerja','id_unit_kerja',$id);
      echo json_encode($row);
    }
    public function editUnit()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kodeUnit','Kode Unit', 'required');
        $this->form_validation->set_rules('namaUnit','Nama Unit', 'required');
        $this->form_validation->set_rules('lokasiUnit','Lokasi Unit', 'required');

        if ($this->form_validation->run()) {
          $data['id_unit_kerja'] = $this->input->post('id');
          $data['kode_unit_kerja'] = $this->input->post('kodeUnit');
          $data['unit_kerja'] = $this->input->post('namaUnit');
          $data['lokasi'] = $this->input->post('lokasiUnit');
          $data['add_time'] = $this->input->post('date');

          $this->user_model->update('m_unit_kerja','id_unit_kerja',$data['id_unit_kerja'],$data);
          echo "Sukses";
        }else{
          echo validation_errors();
        }
    }

    public function deleteUnit($id=null)
    {
        if (!isset($id)){show_404();}
        if ($this->user_model->delete('m_unit_kerja','id_unit_kerja',$id)) {
          echo "Success";
        }else{
          echo "Error";
        }
    }
    //UNIT KERJA CRUD END


    public function pegawai2()
    {
        // $user->cekLogin();

        $data['pegawai'] = $this->user_model->get('m_data_pegawai');
        $data['breadcrumb'] = array('Home','Managemen User','Data Pegawai');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="level" title="">','');
        $data['title'] = "Data Pegawai";
        $this->load->view('man_user/dat_pegawai', $data);
    }





}

/* End of file Man_user.php */
/* Location: ./application/controllers/Man_user.php */