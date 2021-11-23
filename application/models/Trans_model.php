<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trans_model extends CI_Model {

    public function get_data($table)
    {
        return $this->db->get($table);
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function ubah_data($tabel, $data, $where)
    {
      return $this->db->update($tabel, $data, $where);
    }

    public function cari_data($tabel, $where)
    {
      return $this->db->get_where($tabel, $where);
      
    }

    public function get_data_order($tabel, $field, $order)
    {
      $this->db->order_by($field, $order);
      
      return $this->db->get($tabel);
    }

    public function hapus_data($tabel, $where)
    {
      $this->db->delete($tabel, $where);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Pengarsipan
    /*
    /*****************************************************************************************************/

    public function cari_data_arsip($id_pengarsipan)
    {
        $this->db->select('m.kode_masalah, b.jenis_berkas, tp.kode_berkas, tp.judul_berkas, s.sarana_penyimpanan, d.dokumen_unit, l.lemari_berkas, r.rak_arsip, tp.no_dokumen, tp.id_pengarsipan, k.unit_kerja');
        $this->db->from('tr_pengarsipan as tp');
        $this->db->join('m_kode_masalah as m', 'm.id_kode_masalah = tp.id_kode_masalah', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = tp.id_jenis_berkas', 'inner');
        $this->db->join('m_sarana_penyimpanan as s', 's.id_sarana_penyimpanan = tp.id_sarana_penyimpanan', 'inner');
        $this->db->join('m_dokumen_unit as d', 'd.id_dokumen_unit = tp.id_dokumen_unit', 'inner');
        $this->db->join('m_lemari_berkas as l', 'l.id_lemari_berkas = tp.id_lemari_berkas', 'inner');
        $this->db->join('m_rak_arsip as r', 'r.id_rak_arsip = tp.id_rak_arsip', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = tp.id_unit_kerja', 'inner');
        $this->db->where('tp.id_pengarsipan', $id_pengarsipan);
        
        return $this->db->get();
    }

    public function cari_berkas($id_pengarsipan)
    {
        $this->db->select('upload_berkas');
        $this->db->from('tr_pengarsipan');
        $this->db->where('id_pengarsipan', $id_pengarsipan);
        
        return $this->db->get();
        
    }

    // Master pengarsipan
    public function get_data_pengarsipan()
    {
        $this->_get_datatables_query_pengarsipan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_pengarsipan = [null, 'm.kode_masalah', 'b.jenis_berkas', 'tp.kode_berkas', 'tp.judul_berkas'];
    var $kolom_cari_pengarsipan  = ['LOWER(m.kode_masalah)', 'LOWER(b.jenis_berkas)', 'LOWER(tp.kode_berkas)', 'LOWER(tp.judul_berkas)'];
    var $order_pengarsipan       = ['tp.id_pengarsipan' => 'desc'];

    public function _get_datatables_query_pengarsipan()
    {
        $this->db->select('m.kode_masalah, b.jenis_berkas, tp.kode_berkas, tp.judul_berkas, tp.id_pengarsipan');
        $this->db->from('tr_pengarsipan as tp');
        $this->db->join('m_kode_masalah as m', 'm.id_kode_masalah = tp.id_kode_masalah', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = tp.id_jenis_berkas', 'inner');

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
            $this->db->where('tp.id_unit_kerja', $id_unit_kerja);
            
        }

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_pengarsipan;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_pengarsipan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_pengarsipan)) {
            
            $order = $this->order_pengarsipan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_pengarsipan()
    {
        $this->db->select('m.kode_masalah, b.jenis_berkas, tp.kode_berkas, tp.judul_berkas, tp.id_pengarsipan');
        $this->db->from('tr_pengarsipan as tp');
        $this->db->join('m_kode_masalah as m', 'm.id_kode_masalah = tp.id_kode_masalah', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = tp.id_jenis_berkas', 'inner');

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
            $this->db->where('tp.id_unit_kerja', $id_unit_kerja);
            
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_pengarsipan()
    {
        $this->_get_datatables_query_pengarsipan();

        return $this->db->get()->num_rows();
        
    }

    public function get_kode_arsip()
    {
        $this->db->select('kode_berkas');
        $this->db->from('tr_pengarsipan');
        $this->db->order_by('add_time', 'desc');
        
        return $this->db->get();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Peminjaman
    /*
    /*****************************************************************************************************/

    public function cari_data_kode($id_unit_kerja)
    {
        $this->db->select('m.id_kode_masalah, m.kode_masalah');
        $this->db->from('tr_pengarsipan as p');
        $this->db->join('m_kode_masalah as m', 'm.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->where('p.id_unit_kerja', $id_unit_kerja);
        
        $this->db->group_by('m.id_kode_masalah');
        $this->db->group_by('m.kode_masalah');
        
        return $this->db->get();
    }
    
    public function cari_data_id_jnb($id_kode_masalah, $id_unit_kerja)
    {
        $this->db->select('m.id_jenis_berkas, m.jenis_berkas');
        $this->db->from('tr_pengarsipan as p');
        $this->db->join('m_jenis_berkas as m', 'm.id_jenis_berkas = p.id_jenis_berkas', 'inner');
        $this->db->where('p.id_kode_masalah', $id_kode_masalah);
        $this->db->where('p.id_unit_kerja', $id_unit_kerja);
        
        $this->db->group_by('m.id_jenis_berkas');
        $this->db->group_by('m.jenis_berkas');
        
        return $this->db->get();
    }

    public function cari_data_id_kdbr($id_jenis_berkas, $id_kode_masalah, $id_unit_kerja)
    {
        $this->db->select('p.kode_berkas');
        $this->db->from('tr_pengarsipan as p');
        $this->db->where('p.id_jenis_berkas', $id_jenis_berkas);
        $this->db->where('p.id_unit_kerja', $id_unit_kerja);
        $this->db->where('p.id_kode_masalah', $id_kode_masalah);
        
        $this->db->group_by('p.kode_berkas');
        
        return $this->db->get();
    }

    public function cari_data_kode_berkas($kode_berkas)
    {
        return $this->db->get_where('tr_pengarsipan', array('kode_berkas' => $kode_berkas));
        
    }

    // Master peminjaman
    public function get_data_peminjaman()
    {
        $this->_get_datatables_query_peminjaman();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_peminjaman = [null, 'm.instansi_peminjam', 'k.unit_kerja', 'h.kode_masalah', 'b.jenis_berkas', 'p.kode_berkas', 'p.judul_berkas', 'm.status'];
    var $kolom_cari_peminjaman  = ['LOWER(m.instansi_peminjam)', 'LOWER(k.unit_kerja)', 'LOWER(h.kode_masalah)', 'LOWER(b.jenis_berkas)','LOWER(p.kode_berkas)','LOWER(p.judul_berkas)', 'CAST(m.status as VARCHAR)'];
    var $order_peminjaman       = ['m.id_peminjaman' => 'desc'];

    public function _get_datatables_query_peminjaman()
    {
        $this->db->select('m.id_peminjaman, h.kode_masalah, k.unit_kerja, m.instansi_peminjam, b.jenis_berkas, p.kode_berkas, p.judul_berkas, m.surat_peminjaman, m.status, m.identitas_peminjam');
        $this->db->from('tr_peminjaman as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');
        

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_peminjaman;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_peminjaman;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_peminjaman)) {
            
            $order = $this->order_peminjaman;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_peminjaman()
    {
        $this->db->select('m.id_peminjaman, h.kode_masalah, k.unit_kerja, m.instansi_peminjam, b.jenis_berkas, p.kode_berkas, p.judul_berkas, m.surat_peminjaman, m.status, m.identitas_peminjam');
        $this->db->from('tr_peminjaman as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_peminjaman()
    {
        $this->_get_datatables_query_peminjaman();

        return $this->db->get()->num_rows();
        
    }

    public function get_data_pimjam()
    {
        $this->db->select('add_time, durasi, id_peminjaman');
        $this->db->from('tr_peminjaman');

        return $this->db->get();
                
    }

    // public function cari_data_pinjam($id_peminjaman)
    // {
    //     $this->db->select('');
    //     $this->db->from('tr_peminjaman as p');
    //     $this->db->join('tr_pengarsipan as r', 'r.id_pengarsipan = p.id_pengarsipan', '');
        
        
    // }

    /*****************************************************************************************************/
    /*
    /*                                              Penyiangan
    /*
    /*****************************************************************************************************/

    public function cari_arsip_berkas()
    {
        $this->db->select('b.jangka_waktu_retensi, y.add_time, p.id_penyiangan');
        $this->db->from('tr_penyiangan as p');
        $this->db->join('tr_pengarsipan as y', 'y.id_pengarsipan = p.id_pengarsipan', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = y.id_jenis_berkas', 'inner');
        
        return $this->db->get();
        
    }

    // Master penyiangan
    public function get_data_penyiangan()
    {
        $this->_get_datatables_query_penyiangan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_penyiangan = [null, 'k.unit_kerja', 'h.kode_masalah', 'b.jenis_berkas', 'p.kode_berkas', 'p.judul_berkas'];
    var $kolom_cari_penyiangan  = ['LOWER(k.unit_kerja)', 'LOWER(h.kode_masalah)', 'LOWER(b.jenis_berkas)','LOWER(p.kode_berkas)','LOWER(p.judul_berkas)'];
    var $order_penyiangan       = ['m.id_penyiangan' => 'desc'];

    public function _get_datatables_query_penyiangan()
    {
        $this->db->select('m.id_penyiangan, m.status_retensi, h.kode_masalah, k.unit_kerja, b.jenis_berkas, p.kode_berkas, p.judul_berkas, m.pengelompokan');
        $this->db->from('tr_penyiangan as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');
        $this->db->where('m.status', null);

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_penyiangan;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_penyiangan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_penyiangan)) {
            
            $order = $this->order_penyiangan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_penyiangan()
    {
        $this->db->select('m.id_penyiangan, m.status_retensi, h.kode_masalah, k.unit_kerja,  b.jenis_berkas, p.kode_berkas, p.judul_berkas, m.pengelompokan');
        $this->db->from('tr_penyiangan as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');
        $this->db->where('m.status', null);

        return $this->db->count_all_results();
    }

    public function jumlah_filter_penyiangan()
    {
        $this->_get_datatables_query_penyiangan();

        return $this->db->get()->num_rows();
        
    }
    /*****************************************************************************************************/
    /*
    /*                                          Pemusnahan
    /*
    /*****************************************************************************************************/

    // Master pemusnahan
    public function get_data_pemusnahan()
    {
        $this->_get_datatables_query_pemusnahan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_pemusnahan = [null, 'k.unit_kerja', 'h.kode_masalah', 'b.jenis_berkas', 'p.kode_berkas', 'p.judul_berkas', 'CAST(m.tgl_usulan as VARCHAR)'];
    var $kolom_cari_pemusnahan  = ['LOWER(k.unit_kerja)', 'LOWER(h.kode_masalah)', 'LOWER(b.jenis_berkas)','LOWER(p.kode_berkas)','LOWER(p.judul_berkas)', 'CAST(m.tgl_usulan as VARCHAR)'];
    var $order_pemusnahan       = ['m.id_pemusnahan' => 'desc'];

    public function _get_datatables_query_pemusnahan()
    {
        $this->db->select('m.id_pemusnahan, m.tgl_usulan, h.kode_masalah, k.unit_kerja, b.jenis_berkas, p.kode_berkas, p.judul_berkas, m.status');
        $this->db->from('tr_pemusnahan as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_pemusnahan;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_pemusnahan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_pemusnahan)) {
            
            $order = $this->order_pemusnahan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_pemusnahan()
    {
        $this->db->select('m.id_pemusnahan, m.tgl_usulan, h.kode_masalah, k.unit_kerja, b.jenis_berkas, p.kode_berkas, p.judul_berkas, m.status');
        $this->db->from('tr_pemusnahan as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_pemusnahan()
    {
        $this->_get_datatables_query_pemusnahan();

        return $this->db->get()->num_rows();
        
    }
    /*****************************************************************************************************/
    /*
    /*                                          Pelaporan
    /*
    /*****************************************************************************************************/

    // Master pelaporan
    public function get_data_pelaporan()
    {
        $this->_get_datatables_query_pelaporan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_pelaporan = [null, 'k.unit_kerja', 'h.kode_masalah', 'b.jenis_berkas', 'p.kode_berkas', 'p.judul_berkas', 'CAST(m.tgl_pelaporan as VARCHAR)', 'CAST(m.status as VARCHAR)'];
    var $kolom_cari_pelaporan  = ['LOWER(k.unit_kerja)', 'LOWER(h.kode_masalah)', 'LOWER(b.jenis_berkas)','LOWER(p.kode_berkas)','LOWER(p.judul_berkas)', 'CAST(m.tgl_pelaporan as VARCHAR)', 'CAST(m.status as VARCHAR)'];
    var $order_pelaporan       = ['m.id_pelaporan' => 'desc'];

    public function _get_datatables_query_pelaporan()
    {
        $this->db->select('m.id_pelaporan, m.tgl_pelaporan, m.status, h.kode_masalah, k.unit_kerja, b.jenis_berkas, p.kode_berkas, p.judul_berkas');
        $this->db->from('tr_pelaporan as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_pelaporan;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_pelaporan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_pelaporan)) {
            
            $order = $this->order_pelaporan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_pelaporan()
    {
        $this->db->select('m.id_pelaporan, m.tgl_pelaporan, m.status, h.kode_masalah, k.unit_kerja, b.jenis_berkas, p.kode_berkas, p.judul_berkas');
        $this->db->from('tr_pelaporan as m');
        $this->db->join('tr_pengarsipan as p', 'p.id_pengarsipan = m.id_pengarsipan', 'inner');
        $this->db->join('m_kode_masalah as h', 'h.id_kode_masalah = p.id_kode_masalah', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_jenis_berkas as b', 'b.id_jenis_berkas = p.id_jenis_berkas', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_pelaporan()
    {
        $this->_get_datatables_query_pelaporan();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file Trans_model.php */
/* Location: ./application/models/Trans_model.php */