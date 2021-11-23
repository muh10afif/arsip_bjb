<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trans extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('trans_model');
        $this->cek_login_lib->belum_login();
    }

    public function index()
    {
        $this->pengarsipan();
    }
    
    /*****************************************************************************************************/
    /*
    /*                                              Pengarsipan
    /*
    /*****************************************************************************************************/

    public function pengarsipan()
    {
        $data = ['breadcrumb'               => array('Home','Data Pengarsipan'),
                 'bclink'                   => array('<a href="../dashboard" title="">',''),
                 'title'                    => "Data Pengarsipan",
                 'unit_kerja'               => $this->trans_model->get_data('m_unit_kerja')->result_array(),
                 'kode_masalah'             => $this->trans_model->cari_data('m_kode_masalah', array('status' => 1))->result_array(),
                 'jenis_berkas'             => $this->trans_model->cari_data('m_jenis_berkas', array('status' => 1))->result_array(),
                 'sarana_penyimpanan'       => $this->trans_model->cari_data('m_sarana_penyimpanan', array('status' => 1))->result_array(),
                 'dokumen_unit'             => $this->trans_model->cari_data('m_dokumen_unit', array('status' => 1))->result_array(),
                 'lemari_berkas'            => $this->trans_model->cari_data('m_lemari_berkas', array('status' => 1))->result_array(),
                 'rak_arsip'                => $this->trans_model->cari_data('m_rak_arsip', array('status' => 1))->result_array()
                ];

        $this->template->load('layout/template', 'trans/pengarsipan/V_pengarsipan', $data);
    }

    // menampilkan pdf
    public function tampil_pdf()
    {
        $nama = $this->uri->segment(3);

        $data = ['nama_dok' => $nama];

        $this->load->view('trans/pengarsipan/V_dokumen', $data);
    }

    public function tampil_kode_berkas()
    {

        // cari kode kode berkas 
        $hasil = $this->trans_model->get_kode_arsip()->row_array(); 

        if ($hasil['kode_berkas'] != '') {

            // ambil angka urut terakhir 
            $angka_urut = substr($hasil['kode_berkas'], 4);

            $au = $angka_urut + 1;

            $au = str_pad($au, 5, 0, STR_PAD_LEFT);

            $kode_berkas = "KDBK".$au;

        } else {

            $kode_berkas ="KDBK00001";

        }

        echo json_encode(['kode_berkas' => $kode_berkas]);
    }

    // menampilkan data pengarsipan
    public function tampil_pengarsipan()
    {
        $list = $this->trans_model->get_data_pengarsipan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['kode_masalah'];
            $tbody[]    = $o['jenis_berkas'];
            $tbody[]    = $o['kode_berkas'];
            $tbody[]    = $o['judul_berkas'];
            $tbody[]    = "";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-xs waves-effect waves-light btn-outline-info btn-sm mr-3 detail-pengarsipan' data-id='".$o['id_pengarsipan']."'>Detail</button><button type='button' class='btn btn-xs waves-effect waves-light btn-outline-success btn-sm mr-3 edit-pengarsipan' data-id='".$o['id_pengarsipan']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-pengarsipan' data-id='".$o['id_pengarsipan']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->trans_model->jumlah_semua_pengarsipan(),
                    "recordsFiltered"  => $this->trans_model->jumlah_filter_pengarsipan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function tampil_detail_arsip()
    {
        $id_pengarsipan = $this->input->post('id_pengarsipan');
        
        $data = ['arsip'    => $this->trans_model->cari_data_arsip($id_pengarsipan)->row_array(),
                 'berkas'   => $this->trans_model->cari_berkas($id_pengarsipan)->row_array()
                ];

        $this->load->view('trans/pengarsipan/V_detail_arsip', $data);
        
    }

    // aksi pengarsipan 
    public function aksi_pengarsipan()
    {
        $kode_masalah           = $this->input->post('kode_masalah');
        $jenis_berkas           = $this->input->post('jenis_berkas');
        $sarana_penyimpanan     = $this->input->post('sarana_penyimpanan');
        $dokumen_unit           = $this->input->post('dokumen_unit');
        $lemari_berkas          = $this->input->post('lemari_berkas');
        $rak_arsip              = $this->input->post('rak_arsip');

        $level          = $this->session->userdata('level');
        $id_unit_kerja2  = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
            $unit_kerja          = $id_unit_kerja2;
        } elseif ($level == 1) {
            $unit_kerja          = $this->input->post('unit_kerja');
        }

        $kode_berkas            = $this->input->post('kode_berkas');
        $no_dokumen             = $this->input->post('no_dokumen');
        $judul_berkas           = $this->input->post('judul_berkas');
        $id_pengarsipan         = $this->input->post('id_pengarsipan');
        $aksi                   = $this->input->post('aksi');

        $add_by                 = $this->session->userdata('id_data_pegawai');

        // upload file
        $config['max_size']         = 2048;
        $config['allowed_types']    = "pdf";
        $config['remove_spaces']    = TRUE;
        $config['overwrite']        = TRUE;
        $config['upload_path']      = FCPATH.'file/';
        $config['encrypt_name']     = FALSE;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($aksi == 'Tambah') {

            $cari = $this->trans_model->cari_data('tr_pengarsipan', array('no_dokumen' => $no_dokumen, 'id_unit_kerja'  => $unit_kerja, 'id_jenis_berkas'   => $jenis_berkas))->num_rows();

            if ($cari == 0) {

                if (!empty($_FILES['upload_berkas']['name'])) {

                    if ( !$this->upload->do_upload("upload_berkas")){

                        echo json_encode(['hasil' => 0]);

                    } else {

                        $this->upload->do_upload('upload_berkas');

                        // $new_name = time().$_FILES["upload_berkas"]['name'];
                        // $config['file_name'] = $new_name;

                        // $new_name = strtotime("now").$_FILES["upload_berkas"]['name'];
                        // $config['file_name'] = $new_name;

                        $data           = array('upload_data' => $this->upload->data());
                        $filename       = $data['upload_data']['file_name'];

                        // $pathinfo       = 'file/'.$filename;

                        // $filecontent    = file_get_contents($pathinfo);

                        // $gb        = $this->upload->data();
                        // $gambar    = $gb['file_name'];

                        $berkas_base64  = rtrim(base64_encode($filename));

                        $data = ['kode_berkas'         => $kode_berkas,
                                'id_kode_masalah'      => $kode_masalah,
                                'id_jenis_berkas'      => $jenis_berkas,
                                'id_sarana_penyimpanan'=> $sarana_penyimpanan,
                                'id_dokumen_unit'      => $dokumen_unit,
                                'id_lemari_berkas'     => $lemari_berkas,
                                'id_rak_arsip'         => $rak_arsip,
                                'id_unit_kerja'        => $unit_kerja,
                                'no_dokumen'           => $no_dokumen,
                                'judul_berkas'         => $judul_berkas,
                                'upload_berkas'        => $berkas_base64,
                                'add_by'               => $add_by
                                ];

                        $this->trans_model->input_data('tr_pengarsipan', $data);

                        $id_arsip = $this->db->insert_id();

                        $this->trans_model->input_data('tr_penyiangan', array('id_pengarsipan' => $id_arsip, 'add_by'   => $add_by));

                        echo json_encode(['hasil' => 1]);

                    }

                } else {
                    $data = ['kode_berkas'         => $kode_berkas,
                            'id_kode_masalah'      => $kode_masalah,
                            'id_jenis_berkas'      => $jenis_berkas,
                            'id_sarana_penyimpanan'=> $sarana_penyimpanan,
                            'id_dokumen_unit'      => $dokumen_unit,
                            'id_lemari_berkas'     => $lemari_berkas,
                            'id_rak_arsip'         => $rak_arsip,
                            'id_unit_kerja'        => $unit_kerja,
                            'no_dokumen'           => $no_dokumen,
                            'judul_berkas'         => $judul_berkas,
                            'add_by'               => $add_by
                            ];

                    $this->trans_model->input_data('tr_pengarsipan', $data);

                    $id_arsip = $this->db->insert_id();

                    $this->trans_model->input_data('tr_penyiangan', array('id_pengarsipan' => $id_arsip, 'add_by'   => $add_by));

                    echo json_encode(['hasil' => 1]);
                }


                

            } else {
                echo json_encode(['hasil'   => 2]);
            }

        } elseif ($aksi == 'Edit') {

            if (!empty($_FILES['upload_berkas']['name'])) {
                
                $this->upload->do_upload('upload_berkas');
                $data           = array('upload_data' => $this->upload->data());
                $filename       = $data['upload_data']['file_name'];

                // $pathinfo       = 'file/'.$filename;

                // $filecontent    = file_get_contents($pathinfo);

                $berkas_base64  = rtrim(base64_encode($filename));

                $data = ['kode_berkas'         => $kode_berkas,
                        'id_kode_masalah'      => $kode_masalah,
                        'id_jenis_berkas'      => $jenis_berkas,
                        'id_sarana_penyimpanan'=> $sarana_penyimpanan,
                        'id_dokumen_unit'      => $dokumen_unit,
                        'id_lemari_berkas'     => $lemari_berkas,
                        'id_rak_arsip'         => $rak_arsip,
                        'id_unit_kerja'        => $unit_kerja,
                        'no_dokumen'           => $no_dokumen,
                        'judul_berkas'         => $judul_berkas,
                        'upload_berkas'        => $berkas_base64,
                        'add_by'               => $add_by
                        ];

                $this->trans_model->ubah_data('tr_pengarsipan', $data, array('id_pengarsipan' => $id_pengarsipan));

                $cari = $this->trans_model->cari_data('tr_pengarsipan', array('id_pengarsipan' => $id_pengarsipan))->row_array();

                // unlink("file/".base64_decode($cari['upload_berkas']));

                echo json_encode(['hasil' => 1]);

            } else {

                $data = ['kode_berkas'         => $kode_berkas,
                        'id_kode_masalah'      => $kode_masalah,
                        'id_jenis_berkas'      => $jenis_berkas,
                        'id_sarana_penyimpanan'=> $sarana_penyimpanan,
                        'id_dokumen_unit'      => $dokumen_unit,
                        'id_lemari_berkas'     => $lemari_berkas,
                        'id_rak_arsip'         => $rak_arsip,
                        'id_unit_kerja'        => $unit_kerja,
                        'no_dokumen'           => $no_dokumen,
                        'judul_berkas'         => $judul_berkas,
                        'add_by'               => $add_by
                        ];

                $this->trans_model->ubah_data('tr_pengarsipan', $data, array('id_pengarsipan' => $id_pengarsipan));

                echo json_encode(['hasil' => 1]);

            }

            
        } else {

            $this->trans_model->hapus_data('tr_pengarsipan', array('id_pengarsipan' => $id_pengarsipan));

            $cari = $this->trans_model->cari_data('tr_pengarsipan', array('id_pengarsipan' => $id_pengarsipan))->row_array();

            $this->load->helper("file");

            // $path = "./file/".base64_decode($cari['upload_berkas']);

            // delete_files($path);

            // unlink("file/".base64_decode($cari['upload_berkas']));

            echo json_encode(['hasil' => 1]);
        }
        
    }

    // ambil data user
    public function ambil_data_pengarsipan($id_pengarsipan)
    {
        
        $data = $this->user_model->cari_data('tr_pengarsipan', array('id_pengarsipan' => $id_pengarsipan))->row_array();

        echo json_encode($data);
    }

    public function ambil_status_scan()
    {
        $id_jenis_berkas = $this->input->post('id_jenis_berkas');
        
        if ($id_jenis_berkas == '') {
            $scan = null;
        } else {
            $cari = $this->trans_model->cari_data('m_jenis_berkas', array('id_jenis_berkas' => $id_jenis_berkas))->row_array();

            $scan = $cari['scan_requirment'];
        }

        echo json_encode(['scan' => $scan]);
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Peminjaman
    /*
    /*****************************************************************************************************/

    public function peminjaman()
    {
        $data = ['unit_kerja'       => $this->trans_model->get_data('m_unit_kerja')->result_array(),
                 'kode_masalah'     => $this->trans_model->cari_data('m_kode_masalah', array('status' => 1))->result_array(),
                 'jenis_berkas'     => $this->trans_model->cari_data('m_jenis_berkas', array('status' => 1))->result_array(),
                 'kode_berkas'      => $this->trans_model->get_kode_arsip()->result_array()
                ];

        $data['breadcrumb'] = array('Home','Data Peminjaman');
        $data['bclink']     = array('<a href="../dashboard" title="">','');
        $data['title']      = "Data Peminjaman";

        // $tgl_skrg = date("Y-m-d", now('Asia/Jakarta'));

        // echo date('Y-m-d', strtotime("2019-03-01 -1 days"));

        $tgl_skrg2 = date("Y-m-d", now('Asia/Jakarta'));

        $cari = $this->trans_model->get_data_pimjam()->result_array();

        foreach ($cari as $c) {
            
            $tgl_pinjam = $c['add_time'];
            $durasi     = $c['durasi'];

            $tgl_akhir2 = date("Y-m-d H:i:s", strtotime("$tgl_pinjam +$durasi days"));
            $tgl_akhir  = strtotime($tgl_akhir2);
            $tgl_skrg   = strtotime($tgl_skrg2);

            if ($tgl_skrg > $tgl_akhir) {
                $this->trans_model->ubah_data('tr_peminjaman', array('status' => 2), array('id_peminjaman' => $c['id_peminjaman']));
            }

        }

        $this->template->load('layout/template', 'trans/peminjaman/V_peminjaman', $data);
    }

    public function tes()
    {
        echo $da = date('Y-m-d', strtotime("now +2 years"));
    }

    public function ambil_kode_masalah()
    {
        $id_unit_kerja = $this->input->post('id_unit_kerja');

        $option = "";

        if ($id_unit_kerja == '') {
            $option = "";
        } else {
        
            $cari = $this->trans_model->cari_data_kode($id_unit_kerja)->result_array();

            $option = "<option></option>";

            foreach ($cari as $a) {
                $option .= "<option value='".$a['id_kode_masalah']."'>".$a['kode_masalah']."</option>";
            }

        }

        echo json_encode(['kode_masalah' => $option]);
    }

    public function ambil_id_jenis_berkas()
    {
        $id_unit_kerja   = $this->input->post('id_unit_kerja');
        $id_kode_masalah = $this->input->post('id_kode_masalah');

        $option = "";

        if ($id_kode_masalah == '') {
            $option = "";
        } else {
        
            $cari = $this->trans_model->cari_data_id_jnb($id_kode_masalah, $id_unit_kerja)->result_array();

            $option = "<option></option>";

            foreach ($cari as $a) {
                $option .= "<option value='".$a['id_jenis_berkas']."'>".$a['jenis_berkas']."</option>";;
            }

        }

        echo json_encode(['jenis_berkas' => $option]);
    }

    public function ambil_id_kode_berkas()
    {
        $id_kode_masalah = $this->input->post('id_kode_masalah');
        $id_unit_kerja   = $this->input->post('id_unit_kerja');
        $id_jenis_berkas = $this->input->post('id_jenis_berkas');

        $option = "";

        if ($id_jenis_berkas == '') {
            $option = "";
        } else {
        
            $cari = $this->trans_model->cari_data_id_kdbr($id_jenis_berkas, $id_kode_masalah, $id_unit_kerja)->result_array();

            $option = "<option></option>";

            foreach ($cari as $a) {
                $option .= "<option value='".$a['kode_berkas']."'>".$a['kode_berkas']."</option>";;
            }

        }

        echo json_encode(['kode_berkas' => $option]);
    }

    public function ambil_data_dari_kode_berkas()
    {
        $kode_berkas = $this->input->post('kode_berkas');
        
        $cari = $this->trans_model->cari_data_kode_berkas($kode_berkas)->row_array();

        echo json_encode($cari);
    }

    // menampilkan data peminjaman
    public function tampil_peminjaman()
    {
        $list = $this->trans_model->get_data_peminjaman();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $st         = "<span class='badge badge-success'>Data Lengkap</span>";
                $disable    = "";
            } elseif ($o['status'] == 2) {
                $st = "<span class='badge badge-danger'>Tenggang Waktu Habis</span>";
                $disable    = "disabled";
            } elseif ($o['status'] == 3) {
                $st = "<span class='badge badge-warning'>Sudah dikembalikan</span>";
                $disable    = "disabled";
            } else {
                $st = "<span class='badge badge-dark'>Data Belum Lengkap</span>";
                $disable    = "disabled";
            }

            $surat_peminjam = base64_decode($o['surat_peminjaman']);
            $srt_pinjam     = str_replace(' ','_',$surat_peminjam);

            $identitas_peminjam = base64_decode($o['identitas_peminjam']);
            $iden_pinjam        = str_replace(' ','_',$identitas_peminjam);

            $aksi = "<div align='center'><a href='".base_url("trans/tampil_pdf/$srt_pinjam/preview")."' target='_blank'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 ubah' data-id='".$o['id_peminjaman']."' data-toggle='tooltip' data-placement='top' title='Surat Peminjaman'><i class='fa fa-file'></i></button></a><a href='".base_url("trans/tampil_pdf/$iden_pinjam/preview")."' target='_blank'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm ubah' data-id='".$o['id_peminjaman']."' data-toggle='tooltip' data-placement='top' title='Identitas Peminjam'><i class='fa fa-file'></i></button></a></div>";

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['instansi_peminjam'];
            $tbody[]    = $o['unit_kerja'];
            $tbody[]    = $o['kode_masalah'];
            $tbody[]    = $o['jenis_berkas'];
            $tbody[]    = $o['kode_berkas'];
            $tbody[]    = $o['judul_berkas'];
            $tbody[]    = "<div align='center'>".$st."</div>";;
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-peminjaman' data-id='".$o['id_peminjaman']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-peminjaman' data-id='".$o['id_peminjaman']."'>Hapus</button></div>";
            $tbody[]    = $aksi;
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 pengembalian' data-id='".$o['id_peminjaman']."' ".$disable.">Catat</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->trans_model->jumlah_semua_peminjaman(),
                    "recordsFiltered"  => $this->trans_model->jumlah_filter_peminjaman(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi peminjaman 
    public function aksi_peminjaman()
    {
        $id_pengarsipan     = $this->input->post('id_pengarsipan');
        $id_peminjaman      = $this->input->post('id_peminjaman');
        $instansi_peminjam  = $this->input->post('instansi_peminjam');
        $durasi             = ($this->input->post('durasi') == '') ? 0 : $this->input->post('durasi');
        $aksi               = $this->input->post('aksi');
        $add_by             = $this->session->userdata('id_data_pegawai');

        // if ($aksi == 'Tambah' || $aksi == 'edit') {

        //     $surat_peminjaman       = $_FILES['surat_peminjam']['name'];
        //     $identitas_peminjaman   = $_FILES['identitas_peminjam']['name'];

        //     if (empty($surat_peminjaman) || empty($identitas_peminjaman)) {
        //         $status = 0;
        //     } else {
        //         $status = 1;
        //     }
            
        //     $data = ['id_pengarsipan'   => $id_pengarsipan,
        //             'instansi_peminjam'=> $instansi_peminjam,
        //             'durasi'           => $durasi,
        //             'status'           => $status,
        //             'add_by'           => $add_by
        //             ];
        // }

        // upload file
        $config['max_size']         = 2048;
        $config['allowed_types']    = "pdf";
        $config['remove_spaces']    = TRUE;
        $config['overwrite']        = TRUE;
        $config['upload_path']      = FCPATH.'file/';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($aksi == 'Tambah') {

            $surat_peminjaman       = $_FILES['surat_peminjam']['name'];
            $identitas_peminjaman   = $_FILES['identitas_peminjam']['name'];

            if (empty($surat_peminjaman) || empty($identitas_peminjaman)) {
                $status = 0;
            } else {
                $status = 1;
            }

            if ( !$this->upload->do_upload("surat_peminjam")){

                echo json_encode(['hasil' => 0]);

            } else {

                $data = ['id_pengarsipan'   => $id_pengarsipan,
                        'instansi_peminjam' => $instansi_peminjam,
                        'durasi'            => $durasi,
                        'status'            => $status,
                        'add_by'            => $add_by
                        ];

                $this->trans_model->input_data('tr_peminjaman', $data);

                $id_peminjaman2 = $this->db->insert_id();
                
                $this->upload->do_upload('surat_peminjam');
                $data           = array('upload_data' => $this->upload->data());
                $filename       = $data['upload_data']['file_name'];

                // $pathinfo       = 'file/'.$filename;

                // $filecontent    = file_get_contents($pathinfo);

                $surat_peminjaman  = rtrim(base64_encode($filename));

                $data1 = ['surat_peminjaman'=> $surat_peminjaman];

                $this->trans_model->ubah_data('tr_peminjaman', $data1, array('id_peminjaman' => $id_peminjaman2));

                // ubah data

                $this->upload->do_upload('identitas_peminjam');
                $data2           = array('upload_data1' => $this->upload->data());
                $filename2       = $data2['upload_data1']['file_name'];

                // $pathinfo2       = 'file/'.$filename2;

                // $filecontent2    = file_get_contents($pathinfo2);

                $identitas_peminjam  = rtrim(base64_encode($filename2));

                $data2 = ['identitas_peminjam'=> $identitas_peminjam];

                $this->trans_model->ubah_data('tr_peminjaman', $data2, array('id_peminjaman' => $id_peminjaman2));

                echo json_encode(['hasil' => "berhasil"]);

            }

        } elseif ($aksi == 'Edit') {

            $surat_peminjaman       = $_FILES['surat_peminjam']['name'];
            $identitas_peminjaman   = $_FILES['identitas_peminjam']['name'];

            if (empty($surat_peminjaman) || empty($identitas_peminjaman)) {
                $status = 0;
            } else {
                $status = 1;
            }

            $data = ['id_pengarsipan'   => $id_pengarsipan,
                        'instansi_peminjam' => $instansi_peminjam,
                        'durasi'            => $durasi,
                        'status'            => $status,
                        'add_by'            => $add_by
                        ];

            $this->trans_model->ubah_data('tr_peminjaman', $data, array('id_peminjaman' => $id_peminjaman));
                
            $this->upload->do_upload('surat_peminjam');
            $data           = array('upload_data' => $this->upload->data());
            $filename       = $data['upload_data']['file_name'];

            // $pathinfo       = 'file/'.$filename;

            // $filecontent    = file_get_contents($pathinfo);

            $surat_peminjaman  = rtrim(base64_encode($filename));

            $data1 = ['surat_peminjaman'=> $surat_peminjaman];

            $this->trans_model->ubah_data('tr_peminjaman', $data1, array('id_peminjaman' => $id_peminjaman));

            // ubah data

            $this->upload->do_upload('identitas_peminjam');
            $data2           = array('upload_data1' => $this->upload->data());
            $filename2       = $data2['upload_data1']['file_name'];

            // $pathinfo2       = 'file/'.$filename2;

            // $filecontent2    = file_get_contents($pathinfo2);

            $identitas_peminjam  = rtrim(base64_encode($filename2));

            $data2 = ['identitas_peminjam'=> $identitas_peminjam];

            $this->trans_model->ubah_data('tr_peminjaman', $data2, array('id_peminjaman' => $id_peminjaman));

            echo json_encode(['hasil' => "berhasil"]);

        } elseif ($aksi == 'dikembalikan') {
            
            $this->trans_model->ubah_data('tr_peminjaman', array('status' => 3), array('id_peminjaman' => $id_peminjaman));

            echo json_encode(['hasil' => "berhasil"]);
        } else {

            $this->trans_model->hapus_data('tr_peminjaman', array('id_peminjaman' => $id_peminjaman));

            echo json_encode(['hasil' => "berhasil"]);
        }
    }

    // ambil data user
    public function ambil_data_peminjaman($id_peminjaman)
    {
        $data = $this->trans_model->cari_data('tr_peminjaman', array('id_peminjaman' => $id_peminjaman))->row_array();

        echo json_encode($data);
    }


    /*****************************************************************************************************/
    /*
    /*                                        Penyiangan
    /*
    /*****************************************************************************************************/

    public function penyiangan()
    {

        $data['breadcrumb'] = array('Home','Data Penyiangan');
        $data['bclink']     = array('<a href="../dashboard" title="">','');
        $data['title']      = "Data Penyiangan";

        $tgl_skrg2 = date("Y-m-d", now('Asia/Jakarta'));

        $cari = $this->trans_model->cari_arsip_berkas()->result_array();

        foreach ($cari as $c) {
            
            $tgl_berkas = $c['add_time'];
            $jk_retensi = $c['jangka_waktu_retensi'];

            $tgl_akhir2 = date("Y-m-d H:i:s", strtotime("$tgl_berkas +$jk_retensi years"));
            $tgl_akhir  = strtotime($tgl_akhir2);
            $tgl_skrg   = strtotime($tgl_skrg2);

            if ($tgl_skrg > $tgl_akhir) {
                $this->trans_model->ubah_data('tr_penyiangan', array('status_retensi' => 1), array('id_penyiangan' => $c['id_penyiangan']));
            }

        }

        $this->template->load('layout/template', 'trans/penyiangan/V_penyiangan', $data);
    }

    public function tampil_kode_penyiangan()
    {
        // cari kode penyiangan 
        $hasil = $this->user_model->get_data_order('tr_penyiangan', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_penyiangan'] != '') {

          // ambil angka urut terakhir 
          $angka_urut = substr($hasil['kode_penyiangan'], 3);

          $au = $angka_urut + 1;

          $au = str_pad($au, 5, 0, STR_PAD_LEFT);

          $kode = "LVL".$au;

        } else {

          $kode ="LVL1";

        }

        echo json_encode(['kode_penyiangan'  => $kode]);
    }

    // menampilkan data penyiangan
    public function tampil_penyiangan()
    {
        $list = $this->trans_model->get_data_penyiangan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status_retensi'] == 1) {
                $st         = "<span class='badge badge-success'>Sudah Berakhir</span>";
                $disable    = "";
            } else {
                $st         = "<span class='badge badge-dark'>Belum Berakhir</span>";
                $disable    = "disabled";
            }

            if ($o['pengelompokan'] == 1) {
                $aksi = "<div align='center'><span class='badge badge-success'>Sudah Diberkas</span></div>";
            } elseif ($o['pengelompokan'] == 2) {
                $aksi = "<div align='center'><span class='badge badge-warning'>Belum Diberkas</span></div>";
            } else {
                $aksi = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 ubah' aksi='sudah diberkas' data-id='".$o['id_penyiangan']."' data-toggle='tooltip' data-placement='top' title='Sudah Diberkas'><i class='fa fa-check'></i></button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm ubah' aksi='belum diberkas' data-id='".$o['id_penyiangan']."' data-toggle='tooltip' data-placement='top' title='Belum Diberkas'><i class='fa fa-times'></i></button></div>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['unit_kerja'];
            $tbody[]    = $o['kode_masalah'];
            $tbody[]    = $o['jenis_berkas'];
            $tbody[]    = $o['kode_berkas'];
            $tbody[]    = $o['judul_berkas'];
            $tbody[]    = $aksi;
            $tbody[]    = "<div align='center'>".$st."</div>";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 ubah' data-id='".$o['id_penyiangan']."' aksi='usul pemusnahan' data-toggle='tooltip' data-placement='top' title='Usulkan Pemusnahan' ".$disable."><i class='fa fa-paper-plane'></i></button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->trans_model->jumlah_semua_penyiangan(),
                    "recordsFiltered"  => $this->trans_model->jumlah_filter_penyiangan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi penyiangan 
    public function aksi_penyiangan()
    {
        $aksi               = $this->input->post('aksi');
        $id_penyiangan      = $this->input->post('id_penyiangan');

        if ($aksi == 'sudah diberkas') {
            $angka = 1;

            $data = ['pengelompokan' => $angka];

            $this->trans_model->ubah_data('tr_penyiangan', $data, array('id_penyiangan' => $id_penyiangan));
        } else if ($aksi == 'belum diberkas') {
            $angka = 2;

            $data = ['pengelompokan' => $angka];

            $this->trans_model->ubah_data('tr_penyiangan', $data, array('id_penyiangan' => $id_penyiangan));
        } else {

            $cari = $this->trans_model->cari_data('tr_penyiangan', array('id_penyiangan' => $id_penyiangan))->row_array();

            $data = ['id_pengarsipan'   => $cari['id_pengarsipan'],
                     'tgl_usulan'       => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                     'add_by'           => $this->session->userdata('id_data_pegawai')
                    ];

            $this->trans_model->input_data('tr_pemusnahan', $data);

            $this->trans_model->ubah_data('tr_penyiangan', array('status' => 2), array('id_penyiangan' => $id_penyiangan));
        }
    
        echo json_encode(['status' => TRUE]);
    }

    // ambil data penyiangan
    public function ambil_data_penyiangan($id_penyiangan)
    {
        $data = $this->trans_model->cari_data('tr_penyiangan', array('id_penyiangan' => $id_penyiangan))->row_array();

        echo json_encode($data);
    }

    public function pemusnahan2()
    {
        $user = $this->user_model;
        $user->cekLogin();

        $data['pemusnahan'] = $this->trans_model->get('tr_pemusnahan');
        $data['breadcrumb'] = array('Home','Managemen User','Data Pemusnahan');
        $data['bclink'] = array('<a href="../dashboard" title="">','<a href="" title="">','');
        $data['title'] = "Data Pemusnahan";
        $this->load->view('trans/pemusnahan', $data);
    }

    /*****************************************************************************************************/
    /*
    /*                                        Pemusnahan
    /*
    /*****************************************************************************************************/

    public function pemusnahan()
    {
        $data['breadcrumb'] = array('Home','Data Pemusnahan');
        $data['bclink']     = array('<a href="../dashboard" title="">','');
        $data['title']      = "Data Pemusnahan";

        $this->template->load('layout/template', 'trans/pemusnahan/V_pemusnahan', $data);
    }

    // menampilkan data pemusnahan
    public function tampil_pemusnahan()
    {
        $list = $this->trans_model->get_data_pemusnahan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $aksi = "<div align='center'><span class='badge badge-success'>Disetujui</span></div>";
            } elseif ($o['status'] == 2) {
                $aksi = "<div align='center'><span class='badge badge-danger'>Ditolak</span></div>";
            } else {
                $aksi = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 ubah' aksi='disetujui' data-id='".$o['id_pemusnahan']."' data-toggle='tooltip' data-placement='top' title='Setujui'><i class='fa fa-check'></i></button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm ubah' aksi='ditolak' data-id='".$o['id_pemusnahan']."' data-toggle='tooltip' data-placement='top' title='Tolak'><i class='fa fa-times'></i></button></div>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['unit_kerja'];
            $tbody[]    = $o['kode_masalah'];
            $tbody[]    = $o['jenis_berkas'];
            $tbody[]    = $o['kode_berkas'];
            $tbody[]    = $o['judul_berkas'];
            $tbody[]    = $o['tgl_usulan'];
            $tbody[]    = $aksi;
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->trans_model->jumlah_semua_pemusnahan(),
                    "recordsFiltered"  => $this->trans_model->jumlah_filter_pemusnahan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi pemusnahan 
    public function aksi_pemusnahan()
    {
        $aksi           = $this->input->post('aksi');
        $id_pemusnahan  = $this->input->post('id_pemusnahan');
        
        if ($aksi == 'disetujui') {

            $cari = $this->trans_model->cari_data('tr_pemusnahan', array('id_pemusnahan' => $id_pemusnahan))->row_array();

            $data = ['id_pengarsipan'   => $cari['id_pengarsipan'],
                     'tgl_pelaporan'    => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                     'id_data_user'     => $this->session->userdata('id_data_user'),
                     'add_by'           => $this->session->userdata('id_data_pegawai')
                     
                    ];

            $this->trans_model->input_data('tr_pelaporan', $data);

            $this->trans_model->ubah_data('tr_pemusnahan', array('status' => 1), array('id_pemusnahan' => $id_pemusnahan));
        } else {
            $this->trans_model->ubah_data('tr_pemusnahan', array('status' => 2), array('id_pemusnahan' => $id_pemusnahan));
        }

        echo json_encode(['status' => TRUE]);
    }

    /*****************************************************************************************************/
    /*
    /*                                        Pelaporan
    /*
    /*****************************************************************************************************/

    public function pelaporan()
    {
        
        // cari kode pelaporan 
        // $hasil = $this->user_model->get_data_order('tr_pelaporan', 'add_time', 'desc')->row_array(); 

        // if ($hasil['kode_pelaporan'] != '') {

        //   // ambil angka urut terakhir 
        //   $angka_urut = substr($hasil['kode_pelaporan'], 3);

        //   $au = $angka_urut + 1;

        //   $au = str_pad($au, 5, 0, STR_PAD_LEFT);

        //   $data['kode_pelaporan'] = "LVL".$au;

        // } else {

        //   $data['kode_pelaporan'] ="LVL1";

        // }

        $data['breadcrumb'] = array('Home','Data Pelaporan');
        $data['bclink']     = array('<a href="../dashboard" title="">','');
        $data['title']      = "Data Pelaporan";

        $this->template->load('layout/template', 'trans/pelaporan/V_pelaporan', $data);
    }

    public function tampil_kode_pelaporan()
    {
        // cari kode pelaporan 
        $hasil = $this->user_model->get_data_order('tr_pelaporan', 'add_time', 'desc')->row_array(); 

        if ($hasil['kode_pelaporan'] != '') {

          // ambil angka urut terakhir 
          $angka_urut = substr($hasil['kode_pelaporan'], 3);

          $au = $angka_urut + 1;

          $au = str_pad($au, 5, 0, STR_PAD_LEFT);

          $kode = "LVL".$au;

        } else {

          $kode ="LVL1";

        }

        echo json_encode(['kode_pelaporan'  => $kode]);
    }

    // menampilkan data pelaporan
    public function tampil_pelaporan()
    {
        $list = $this->trans_model->get_data_pelaporan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['unit_kerja'];
            $tbody[]    = $o['kode_masalah'];
            $tbody[]    = $o['jenis_berkas'];
            $tbody[]    = $o['kode_berkas'];
            $tbody[]    = $o['judul_berkas'];
            $tbody[]    = $o['tgl_pelaporan'];
            $tbody[]    = $o['status'];
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-3 cetak-pelaporan' data-id='".$o['id_pelaporan']."'><i class='fa fa-print'></i></button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->trans_model->jumlah_semua_pelaporan(),
                    "recordsFiltered"  => $this->trans_model->jumlah_filter_pelaporan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi pelaporan 
    public function aksi_pelaporan()
    {
        $kode_pelaporan   = $this->input->post('kode_pelaporan');
        $nama_pelaporan   = $this->input->post('nama_pelaporan');
        $aksi         = $this->input->post('aksi');
        $id_pelaporan     = $this->input->post('id_pelaporan');
        
        $data = ['kode_pelaporan' => $kode_pelaporan,
                 'nama_pelaporan' => $nama_pelaporan
                ];

        if ($aksi == 'Tambah') {
            $this->trans_model->input_data('tr_pelaporan', $data);
        } elseif ($aksi == 'Edit') {
            $this->trans_model->ubah_data('tr_pelaporan', $data, array('id_pelaporan' => $id_pelaporan));
        } else {
            $this->trans_model->hapus_data('tr_pelaporan', array('id_pelaporan' => $id_pelaporan));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data pelaporan
    public function ambil_data_pelaporan($id_pelaporan)
    {
        $data = $this->trans_model->cari_data('tr_pelaporan', array('id_pelaporan' => $id_pelaporan))->row_array();

        echo json_encode($data);
    }

}

/* End of file Trans.php */
/* Location: ./application/controllers/Trans.php */