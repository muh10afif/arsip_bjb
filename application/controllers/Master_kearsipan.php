<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_kearsipan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('kearsipan_model','kearsipan_model'));
        $this->cek_login_lib->belum_login();
    }

    public function index()
    {
        $this->kode_masalah();
    }

    /*****************************************************************************************************/
    /*
    /*                                         KODE MASALAH
    /*
    /*****************************************************************************************************/

    public function kode_masalah()
    {
        $data['breadcrumb'] = array('Home','Master Kearsipan','Kode Masalah');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = 'Kode Masalah';

        $this->template->load('layout/template', 'master_kearsipan/kode_masalah/V_kode_masalah', $data);
    }

    public function generate_kode_masalah()
    {
        // cari kode level 
        $hasil = $this->kearsipan_model->get_data_order('m_kode_masalah', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_masalah'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_masalah'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_masalah = "KMSL".$au;

        } else {

            $kode_masalah ="KMSL00001";

        }

        echo json_encode(['kode_masalah' => $kode_masalah]);
    }

    // menampilkan data kode_masalah
    public function tampil_kode_masalah()
    {
        $list = $this->kearsipan_model->get_data_kode_masalah();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<div align='center'><span class='badge badge-success'>Aktif</span></div>";
            } else {
                $st = "<div align='center'><span class='badge badge-dark'>Tidak Aktif</span></div>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_masalah'];
            $tbody[]    = $o['masalah'];
            $tbody[]    = $st;
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-kode-masalah' data-id='".$o['id_kode_masalah']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-kode-masalah' data-id='".$o['id_kode_masalah']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_kode_masalah(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_kode_masalah(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi kode_masalah 
    public function aksi_kode_masalah()
    {
        $kode_masalah       = $this->input->post('kode_masalah');
        $masalah            = $this->input->post('masalah');
        $aksi               = $this->input->post('aksi');
        $status             = $this->input->post('status');
        $id_kode_masalah    = $this->input->post('id_kode_masalah');
        
        $data = ['kode_masalah' => $kode_masalah,
                 'masalah'      => $masalah,
                 'status'       => 1
                ];

        if ($aksi == 'Tambah') {

            $this->kearsipan_model->input_data('m_kode_masalah', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = ['kode_masalah' => $kode_masalah,
                     'masalah'       => $masalah,
                     'status'        => $status
                    ];

            $this->kearsipan_model->ubah_data('m_kode_masalah', $data2, array('id_kode_masalah' => $id_kode_masalah));
        } else {
            $this->kearsipan_model->hapus_data('m_kode_masalah', array('id_kode_masalah' => $id_kode_masalah));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data kode_masalah
    public function ambil_data_kode_masalah($id_kode_masalah)
    {
        $data = $this->kearsipan_model->cari_data('m_kode_masalah', array('id_kode_masalah' => $id_kode_masalah))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              JENIS BERKAS
    /*
    /*****************************************************************************************************/

    public function jenis_berkas()
    {
        $data['breadcrumb'] = array('Home','Master Kearsipan','Jenis Berkas');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title']      = 'Jenis Berkas';
        $data['unit_kerja'] = $this->kearsipan_model->get_data('m_unit_kerja')->result_array();

        $this->template->load('layout/template', 'master_kearsipan/jenis_berkas/V_jenis_berkas', $data);
    }

    public function tampil_kode_jenis_berkas()
    {
        // cari kode level 
        $hasil = $this->kearsipan_model->get_data_order('m_jenis_berkas', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_jenis_berkas'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_jenis_berkas'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_jenis_berkas = "JSBR".$au;

        } else {

            $kode_jenis_berkas ="JSBR00001";

        }

        echo json_encode(['kode_jenis_berkas' => $kode_jenis_berkas]);
    }

    // menampilkan data jenis_berkas
    public function tampil_jenis_berkas()
    { 
        $list = $this->kearsipan_model->get_data_jenis_berkas();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<div align='center'><span class='badge badge-success'>Aktif</span></div>";
            } else {
                $st = "<div align='center'><span class='badge badge-dark'>Tidak Aktif</span></div>";
            }

            if ($o['scan_requirment'] == 1) {
                $scan = "<div align='center'><span class='badge badge-success'>Ya</span></div>";
            } else {
                $scan = "<div align='center'><span class='badge badge-dark'>Tidak</span></div>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_jenis_berkas'];
            $tbody[]    = $o['jenis_berkas'];
            $tbody[]    = $o['unit_kerja'];
            $tbody[]    = "<div align='center'>".$o['jangka_waktu_retensi']." Tahun</div>";
            $tbody[]    = $scan;
            $tbody[]    = $st;
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-jenis_berkas' data-id='".$o['id_jenis_berkas']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-jenis_berkas' data-id='".$o['id_jenis_berkas']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_jenis_berkas(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_jenis_berkas(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi jenis_berkas 
    public function aksi_jenis_berkas()
    {
        $kode_jenis_berkas  = $this->input->post('kode_jenis_berkas');
        $jenis_berkas       = $this->input->post('jenis_berkas');
        $unit_kerja         = $this->input->post('unit_kerja');
        $retensi            = $this->input->post('retensi');
        $scan_dok           = $this->input->post('scan_dok');
        $status             = $this->input->post('status');
        $aksi               = $this->input->post('aksi');
        $id_jenis_berkas    = $this->input->post('id_jenis_berkas');
        
        $data = ['kode_jenis_berkas'    => $kode_jenis_berkas,
                 'jenis_berkas'         => $jenis_berkas,
                 'id_unit_kerja'        => $unit_kerja,
                 'jangka_waktu_retensi' => $retensi,
                 'scan_requirment'      => $scan_dok,
                 'status'               => 1
                ];

        if ($aksi == 'Tambah') {
            $this->kearsipan_model->input_data('m_jenis_berkas', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = [  'kode_jenis_berkas'    => $kode_jenis_berkas,
                        'jenis_berkas'         => $jenis_berkas,
                        'id_unit_kerja'        => $unit_kerja,
                        'jangka_waktu_retensi' => $retensi,
                        'scan_requirment'      => $scan_dok,
                        'status'               => $status
                        ];

            $this->kearsipan_model->ubah_data('m_jenis_berkas', $data2, array('id_jenis_berkas' => $id_jenis_berkas));
        } else {
            $this->kearsipan_model->hapus_data('m_jenis_berkas', array('id_jenis_berkas' => $id_jenis_berkas));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data jenis_berkas
    public function ambil_data_jenis_berkas($id_jenis_berkas)
    {
        $data = $this->kearsipan_model->cari_data('m_jenis_berkas', array('id_jenis_berkas' => $id_jenis_berkas))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              SARANA PENYIMPANAN
    /*
    /*****************************************************************************************************/

    public function sarana_penyimpanan()
    {
        $data['breadcrumb'] = array('Home','Master Kearsipan','Sarana Penyimpanan');
        $data['bclink']     = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title']      = 'Sarana Penyimpanan';

        $this->template->load('layout/template', 'master_kearsipan/sarana_penyimpanan/V_sarana_penyimpanan', $data);
    }

    public function tampil_kode_sarana_p()
    {
        // cari kode level 
        $hasil = $this->kearsipan_model->get_data_order('m_sarana_penyimpanan', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_sarana_penyimpanan'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_sarana_penyimpanan'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_sarana_penyimpanan = "SRPN".$au;

        } else {

            $kode_sarana_penyimpanan ="SRPN00001";

        }

        echo json_encode(['kode_sarana_penyimpanan' => $kode_sarana_penyimpanan]);
    }

    // menampilkan data sarana_penyimpanan
    public function tampil_sarana_penyimpanan()
    {
        $list = $this->kearsipan_model->get_data_sarana_penyimpanan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_sarana_penyimpanan'];
            $tbody[]    = $o['sarana_penyimpanan'];
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-sarana_penyimpanan' data-id='".$o['id_sarana_penyimpanan']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-sarana_penyimpanan' data-id='".$o['id_sarana_penyimpanan']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_sarana_penyimpanan(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_sarana_penyimpanan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi sarana_penyimpanan 
    public function aksi_sarana_penyimpanan()
    {
        $kode_sarana_penyimpanan    = $this->input->post('kode_sarana_penyimpanan');
        $sarana_penyimpanan         = $this->input->post('sarana_penyimpanan');
        $status                     = $this->input->post('status');
        $aksi                       = $this->input->post('aksi');
        $id_sarana_penyimpanan      = $this->input->post('id_sarana_penyimpanan');
            
        $data = ['kode_sarana_penyimpanan'  => $kode_sarana_penyimpanan,
                 'sarana_penyimpanan'       => $sarana_penyimpanan,
                 'status'                   => 1
                ];

        if ($aksi == 'Tambah') {
            $this->kearsipan_model->input_data('m_sarana_penyimpanan', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = ['kode_sarana_penyimpanan'  => $kode_sarana_penyimpanan,
                     'sarana_penyimpanan'        => $sarana_penyimpanan,
                     'status'                    => $status
                     ];

            $this->kearsipan_model->ubah_data('m_sarana_penyimpanan', $data2, array('id_sarana_penyimpanan' => $id_sarana_penyimpanan));
        } else {
            $this->kearsipan_model->hapus_data('m_sarana_penyimpanan', array('id_sarana_penyimpanan' => $id_sarana_penyimpanan));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data sarana_penyimpanan
    public function ambil_data_sarana_penyimpanan($id_sarana_penyimpanan)
    {
        $data = $this->kearsipan_model->cari_data('m_sarana_penyimpanan', array('id_sarana_penyimpanan' => $id_sarana_penyimpanan))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Dokumen Unit
    /*
    /*****************************************************************************************************/

    public function dok_unit()
    {
        // cari kode dok_unit 
        // $hasil = $this->kearsipan_model->get_data_order('m_dokumen_unit', 'add_time', 'desc')->row_array(); 

        // if ($hasil['kode_dokumen_unit'] != '') {

        //   // ambil angka urut terakhir 
        //   $angka_urut = substr($hasil['kode_dokumen_unit'], 3);

        //   $au = $angka_urut + 1;

        //   $data['kode_dokumen_unit'] = "LVL".$au;

        // } else {

        //   $data['kode_dokumen_unit'] ="LVL1";

        // }

        $data['breadcrumb'] = array('Home','Master Kearsipan','Dokumen Unit');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title'] = 'Dokumen Unit';

        $this->template->load('layout/template', 'master_kearsipan/dok_unit/V_dok_unit', $data);
    }

    public function tampil_kode_dokumen_unit()
    {
        // cari kode level 
        $hasil = $this->kearsipan_model->get_data_order('m_dokumen_unit', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_dokumen_unit'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_dokumen_unit'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_dokumen_unit = "DNUT".$au;

        } else {

            $kode_dokumen_unit ="DNUT00001";

        }

        echo json_encode(['kode_dokumen_unit' => $kode_dokumen_unit]);
    }

    // menampilkan data dok_unit
    public function tampil_dokumen_unit()
    {
        $list = $this->kearsipan_model->get_data_dok_unit();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_dokumen_unit'];
            $tbody[]    = $o['dokumen_unit'];
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-dokumen-unit' data-id='".$o['id_dokumen_unit']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-dokumen-unit' data-id='".$o['id_dokumen_unit']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_dok_unit(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_dok_unit(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi dok_unit 
    public function aksi_dokumen_unit()
    {
        $kode_dokumen_unit  = $this->input->post('kode_dokumen_unit');
        $dokumen_unit       = $this->input->post('dokumen_unit');
        $status             = $this->input->post('status');
        $aksi               = $this->input->post('aksi');
        $id_dokumen_unit    = $this->input->post('id_dokumen_unit');
        
        $data = ['kode_dokumen_unit'    => $kode_dokumen_unit,
                 'dokumen_unit'         => $dokumen_unit,
                 'status'               => 1
                ];

        if ($aksi == 'Tambah') {

            $this->kearsipan_model->input_data('m_dokumen_unit', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = [  'kode_dokumen_unit'    => $kode_dokumen_unit,
                        'dokumen_unit'         => $dokumen_unit,
                        'status'               => $status
                        ];

            $this->kearsipan_model->ubah_data('m_dokumen_unit', $data2, array('id_dokumen_unit' => $id_dokumen_unit));
        } else {
            $this->kearsipan_model->hapus_data('m_dokumen_unit', array('id_dokumen_unit' => $id_dokumen_unit));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data dok_unit
    public function ambil_data_dokumen_unit($id_dokumen_unit)
    {
        $data = $this->kearsipan_model->cari_data('m_dokumen_unit', array('id_dokumen_unit' => $id_dokumen_unit))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Gudang Arsip
    /*
    /*****************************************************************************************************/

    public function gudang_arsip()
    {
        // cari kode gudang_arsip 
        // $hasil = $this->kearsipan_model->get_data_order('m_gudang_arsip', 'add_time', 'desc')->row_array(); 

        // if ($hasil['kode_gudang_arsip'] != '') {

        //   // ambil angka urut terakhir 
        //   $angka_urut = substr($hasil['kode_gudang_arsip'], 3);

        //   $au = $angka_urut + 1;

        //   $data['kode_gudang_arsip'] = "LVL".$au;

        // } else {

        //   $data['kode_gudang_arsip'] ="LVL1";

        // }

        $data['breadcrumb'] = array('Home','Master Kearsipan','Gudang Arsip');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Gudang Arsip';

        $this->template->load('layout/template', 'master_kearsipan/gudang_arsip/V_gudang_arsip', $data);
    }

    public function tampil_kode_gudang_arsip()
    {
        // cari kode gudang_arsip 
        $hasil = $this->kearsipan_model->get_data_order('m_gudang_arsip', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_gudang_arsip'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_gudang_arsip'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_gudang_arsip = "GDAP".$au;

        } else {

            $kode_gudang_arsip ="GDAP00001";

        }

        echo json_encode(['kode_gudang_arsip' => $kode_gudang_arsip]);
    }

    // menampilkan data gudang_arsip
    public function tampil_gudang_arsip()
    {
        $list = $this->kearsipan_model->get_data_gudang_arsip();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_gudang_arsip'];
            $tbody[]    = $o['gudang_arsip'];
            $tbody[]    = $o['lokasi'];
            $tbody[]    = "<div align='center'>".$o['kuota']."</div>";
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-gudang-arsip' data-id='".$o['id_gudang_arsip']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-gudang-arsip' data-id='".$o['id_gudang_arsip']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_gudang_arsip(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_gudang_arsip(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi gudang_arsip 
    public function aksi_gudang_arsip()
    {
        $kode_gudang_arsip  = $this->input->post('kode_gudang_arsip');
        $gudang_arsip       = $this->input->post('gudang_arsip');
        $lokasi             = $this->input->post('lokasi');
        $kuota              = $this->input->post('kuota');
        $status             = $this->input->post('status');
        $aksi               = $this->input->post('aksi');
        $id_gudang_arsip    = $this->input->post('id_gudang_arsip');
        
        $data = ['kode_gudang_arsip'    => $kode_gudang_arsip,
                 'gudang_arsip'         => $gudang_arsip,
                 'lokasi'               => $lokasi,
                 'kuota'                => $kuota,
                 'status'               => 1
                ];

        if ($aksi == 'Tambah') {
            $this->kearsipan_model->input_data('m_gudang_arsip', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = [  'kode_gudang_arsip'    => $kode_gudang_arsip,
                        'gudang_arsip'         => $gudang_arsip,
                        'lokasi'               => $lokasi,
                        'kuota'                => $kuota,
                        'status'               => $status
                        ];

            $this->kearsipan_model->ubah_data('m_gudang_arsip', $data2, array('id_gudang_arsip' => $id_gudang_arsip));
        } else {
            $this->kearsipan_model->hapus_data('m_gudang_arsip', array('id_gudang_arsip' => $id_gudang_arsip));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data gudang_arsip
    public function ambil_data_gudang_arsip($id_gudang_arsip)
    {
        $data = $this->kearsipan_model->cari_data('m_gudang_arsip', array('id_gudang_arsip' => $id_gudang_arsip))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Lemari Berkas
    /*
    /*****************************************************************************************************/

    public function lemari_berkas()
    {
        $data['breadcrumb']     = array('Home','Master Kearsipan','Lemari Berkas');
        $data['bclink']         = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title']          = 'Lemari Berkas';
        $data['gudang_arsip']   = $this->kearsipan_model->get_data_order('m_gudang_arsip', 'gudang_arsip', 'desc')->result_array();

        $this->template->load('layout/template', 'master_kearsipan/lemari_berkas/V_lemari_berkas', $data);
    }

    public function tampil_kode_lemari_berkas()
    {
        // cari kode lemari_berkas 
        $hasil = $this->kearsipan_model->get_data_order('m_lemari_berkas', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_lemari_berkas'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_lemari_berkas'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_lemari_berkas = "LMBS".$au;

        } else {

            $kode_lemari_berkas ="LMBS00001";

        }

        echo json_encode(['kode_lemari_berkas' => $kode_lemari_berkas]);
    }

    // menampilkan data lemari_berkas
    public function tampil_lemari_berkas()
    {
        $list = $this->kearsipan_model->get_data_lemari_berkas();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_lemari_berkas'];
            $tbody[]    = $o['lemari_berkas'];
            $tbody[]    = $o['gudang_arsip'];
            $tbody[]    = $o['ket'];
            $tbody[]    = "<div align='center'>".$st."</div>";;
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-lemari-berkas' data-id='".$o['id_lemari_berkas']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-lemari-berkas' data-id='".$o['id_lemari_berkas']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_lemari_berkas(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_lemari_berkas(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi lemari_berkas 
    public function aksi_lemari_berkas()
    {
        $kode_lemari_berkas = $this->input->post('kode_lemari_berkas');
        $lemari_berkas      = $this->input->post('lemari_berkas');
        $keterangan         = $this->input->post('keterangan');
        $id_gudang_arsip    = $this->input->post('gudang_arsip');
        $status             = $this->input->post('status');
        $aksi               = $this->input->post('aksi');
        $id_lemari_berkas   = $this->input->post('id_lemari_berkas');
        
        $data = ['kode_lemari_berkas'   => $kode_lemari_berkas,
                 'lemari_berkas'        => $lemari_berkas,
                 'letak'                => $id_gudang_arsip,
                 'ket'                  => $keterangan,
                 'status'               => 1
                ];

        if ($aksi == 'Tambah') {
            $this->kearsipan_model->input_data('m_lemari_berkas', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = [  'kode_lemari_berkas'   => $kode_lemari_berkas,
                        'lemari_berkas'        => $lemari_berkas,
                        'letak'                => $id_gudang_arsip,
                        'ket'                  => $keterangan,
                        'status'               => $status
                        ];

            $this->kearsipan_model->ubah_data('m_lemari_berkas', $data2, array('id_lemari_berkas' => $id_lemari_berkas));
        } else {
            $this->kearsipan_model->hapus_data('m_lemari_berkas', array('id_lemari_berkas' => $id_lemari_berkas));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data lemari_berkas
    public function ambil_data_lemari_berkas($id_lemari_berkas)
    {
        $data = $this->kearsipan_model->cari_data('m_lemari_berkas', array('id_lemari_berkas' => $id_lemari_berkas))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Rak Arsip
    /*
    /*****************************************************************************************************/

    public function rak_arsip()
    {
        // cari kode rak_arsip 
        // $hasil = $this->kearsipan_model->get_data_order('m_rak_arsip', 'add_time', 'desc')->row_array(); 

        // if ($hasil['kode_rak_arsip'] != '') {

        //   // ambil angka urut terakhir 
        //   $angka_urut = substr($hasil['kode_rak_arsip'], 3);

        //   $au = $angka_urut + 1;

        //   $data['kode_rak_arsip'] = "LVL".$au;

        // } else {

        //   $data['kode_rak_arsip'] ="LVL1";

        // }

        $data['breadcrumb'] = array('Home','Master Kearsipan','Rak Arsip');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Rak Arsip';

        $this->template->load('layout/template', 'master_kearsipan/rak_arsip/V_rak_arsip', $data);
    }

    public function tampil_kode_rak_arsip()
    {
        // cari kode lemari_berkas 
        $hasil = $this->kearsipan_model->get_data_order('m_rak_arsip', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_rak_arsip'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_rak_arsip'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_rak_arsip = "RKAR".$au;

        } else {

            $kode_rak_arsip ="RKAR00001";

        }

        echo json_encode(['kode_rak_arsip' => $kode_rak_arsip]);
    }

    // menampilkan data rak_arsip
    public function tampil_rak_arsip()
    {
        $list = $this->kearsipan_model->get_data_rak_arsip();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st = "<span class='badge badge-success'>Aktif</span>";
            } else {
                $st = "<span class='badge badge-dark'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_rak_arsip'];
            $tbody[]    = $o['rak_arsip'];
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 edit-rak-arsip' data-id='".$o['id_rak_arsip']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-rak-arsip' data-id='".$o['id_rak_arsip']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->kearsipan_model->jumlah_semua_rak_arsip(),
                    "recordsFiltered"  => $this->kearsipan_model->jumlah_filter_rak_arsip(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi rak_arsip 
    public function aksi_rak_arsip()
    {
        $kode_rak_arsip = $this->input->post('kode_rak_arsip');
        $rak_arsip      = $this->input->post('rak_arsip');
        $status         = $this->input->post('status');
        $aksi           = $this->input->post('aksi');
        $id_rak_arsip   = $this->input->post('id_rak_arsip');
        
        $data = ['kode_rak_arsip'   => $kode_rak_arsip,
                 'rak_arsip'        => $rak_arsip,
                 'status'           => 1
                ];

        if ($aksi == 'Tambah') {
            $this->kearsipan_model->input_data('m_rak_arsip', $data);
        } elseif ($aksi == 'Edit') {

            $data2 = [  'kode_rak_arsip'   => $kode_rak_arsip,
                        'rak_arsip'        => $rak_arsip,
                        'status'           => $status
                        ];

            $this->kearsipan_model->ubah_data('m_rak_arsip', $data2, array('id_rak_arsip' => $id_rak_arsip));
        } else {
            $this->kearsipan_model->hapus_data('m_rak_arsip', array('id_rak_arsip' => $id_rak_arsip));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data rak_arsip
    public function ambil_data_rak_arsip($id_rak_arsip)
    {
        $data = $this->kearsipan_model->cari_data('m_rak_arsip', array('id_rak_arsip' => $id_rak_arsip))->row_array();

        echo json_encode($data);
    }
    
    // Akhir 

    public function kode_masalah2()
    {
        $data['kode_masalah'] = $this->kearsipan_model->get('m_kode_masalah');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Kode Masalah');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title'] = 'Kode Masalah';
        $this->load->view('master_kearsipan/kode_masalah', $data);
    }

    public function jenis_berkas2()
    {
        $data['jenis_berkas'] = $this->kearsipan_model->get('m_jenis_berkas');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Jenis Berkas');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Jenis Berkas';
        $this->load->view('master_kearsipan/jenis_berkas', $data);
    }

    public function sarana_penyimpanan2()
    {
        $data['sarana_penyimpanan'] = $this->kearsipan_model->get('m_sarana_penyimpanan');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Sarana Penyimpanan');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Sarana Penyimpanan';
        $this->load->view('master_kearsipan/sarana_penyimpanan', $data);
    }

    public function dokumen_unit2()
    {
        $data['dokumen_unit'] = $this->kearsipan_model->get('m_dokumen_unit');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Dokumen Unit');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Dokumen Unit';
        $this->load->view('master_kearsipan/dokumen_unit', $data);
    }

    public function gudang_arsip2()
    {
        $data['gudang_arsip'] = $this->kearsipan_model->get('m_gudang_arsip');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Gudang Arsip');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Gudang Arsip';
        $this->load->view('master_kearsipan/gudang_arsip', $data);
    }

    public function lemari_berkas2()
    {
        $data['lemari_berkas'] = $this->kearsipan_model->get('m_lemari_berkas');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Lemari Berkas');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Lemari Berkas';
        $this->load->view('master_kearsipan/lemari_berkas', $data);
    }

    public function rak_arsip2()
    {
        $data['rak_arsip'] = $this->kearsipan_model->get('m_rak_arsip');
        $data['breadcrumb'] = array('Home','Master Kearsipan','Rak Arsip');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="kode_masalah" title="">','');
        $data['title'] = 'Rak Arsip';
        $this->load->view('master_kearsipan/rak_arsip', $data);
    }

}

/* End of file Master_kearsipan.php */
/* Location: ./application/controllers/Master_kearsipan.php */