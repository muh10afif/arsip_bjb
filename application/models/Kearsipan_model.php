<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kearsipan_model extends CI_Model {


    public function get($table)
    {
      return $this->db->get($table)->result();
    }

    public function getby($table,$by)
    {
      $this->db->order_by($by, 'asc');
      return $this->db->get($table)->result();
    }

    public function insert($table,$data)
    {
      $this->db->insert($table, $data);
    }

    public function delete($table,$field,$id)
    {
      return $this->db->delete($table, array($field => $id));
    }

    public function update($table,$field,$id,$data)
    {
      $this->db->update($table, $data, array($field => $id));
    }
    
    public function getById($table,$field,$id)
    {
      return $this->db->get_where($table, [$field => $id])->row();
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

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
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
    /*                                              Kode Masalah
    /*
    /*****************************************************************************************************/

    // Master kode_masalah
    public function get_data_kode_masalah()
    {
        $this->_get_datatables_query_kode_masalah();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_kode_masalah = [null, 'k.kode_masalah', 'k.masalah', 'k.status'];
    var $kolom_cari_kode_masalah  = ['LOWER(k.kode_masalah)', 'LOWER(k.masalah)', 'CAST(k.status as VARCHAR)'];
    var $order_kode_masalah       = ['k.kode_masalah' => 'asc'];

    public function _get_datatables_query_kode_masalah()
    {
        $this->db->from('m_kode_masalah as k');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_kode_masalah;

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

            $kolom_order = $this->kolom_order_kode_masalah;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_kode_masalah)) {
            
            $order = $this->order_kode_masalah;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_kode_masalah()
    {
      $this->db->from('m_kode_masalah as k');

      return $this->db->count_all_results();
    }

    public function jumlah_filter_kode_masalah()
    {
        $this->_get_datatables_query_kode_masalah();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                        JENIS BERKAS
    /*
    /*****************************************************************************************************/

    // Master jenis_berkas
    public function get_data_jenis_berkas()
    {
        $this->_get_datatables_query_jenis_berkas();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_jenis_berkas = [null, 'j.kode_jenis_berkas', 'j.jenis_berkas', 'k.unit_kerja', 'j.jangka_waktu_retensi', 'j.scan_requirment', 'j.status'];
    var $kolom_cari_jenis_berkas  = ['LOWER(j.kode_jenis_berkas)', 'LOWER(j.jenis_berkas)', 'LOWER(k.unit_kerja)', 'CAST(j.jangka_waktu_retensi as VARCHAR)', 'CAST(j.scan_requirment as VARCHAR)', 'CAST(j.status as VARCHAR)'];
    var $order_jenis_berkas       = ['j.kode_jenis_berkas' => 'asc'];

    public function _get_datatables_query_jenis_berkas()
    {
        $this->db->from('m_jenis_berkas as j');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = j.id_unit_kerja', 'inner');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_jenis_berkas;

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

            $kolom_order = $this->kolom_order_jenis_berkas;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_jenis_berkas)) {
            
            $order = $this->order_jenis_berkas;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_jenis_berkas()
    {
        $this->db->from('m_jenis_berkas as j');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = j.id_unit_kerja', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_jenis_berkas()
    {
        $this->_get_datatables_query_jenis_berkas();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Sarana Penyimpanan
    /*
    /*****************************************************************************************************/

    // Master sarana_penyimpanan
    public function get_data_sarana_penyimpanan()
    {
        $this->_get_datatables_query_sarana_penyimpanan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_sarana_penyimpanan = [null, 'kode_sarana_penyimpanan', 'sarana_penyimpanan', 'status'];
    var $kolom_cari_sarana_penyimpanan  = ['LOWER(kode_sarana_penyimpanan)', 'LOWER(sarana_penyimpanan)', 'CAST(status as VARCHAR)'];
    var $order_sarana_penyimpanan       = ['kode_sarana_penyimpanan' => 'asc'];

    public function _get_datatables_query_sarana_penyimpanan()
    {
        $this->db->from('m_sarana_penyimpanan');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_sarana_penyimpanan;

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

            $kolom_order = $this->kolom_order_sarana_penyimpanan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_sarana_penyimpanan)) {
            
            $order = $this->order_sarana_penyimpanan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_sarana_penyimpanan()
    {
      $this->db->from('m_sarana_penyimpanan');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_sarana_penyimpanan()
    {
        $this->_get_datatables_query_sarana_penyimpanan();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Dokumen Unit
    /*
    /*****************************************************************************************************/

    // Master dok_unit
    public function get_data_dok_unit()
    {
        $this->_get_datatables_query_dok_unit();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_dok_unit = [null, 'kode_dokumen_unit', 'dokumen_unit', 'status'];
    var $kolom_cari_dok_unit  = ['LOWER(kode_dokumen_unit)', 'LOWER(dokumen_unit)', 'CAST(status as VARCHAR)'];
    var $order_dok_unit       = ['kode_dokumen_unit' => 'asc'];

    public function _get_datatables_query_dok_unit()
    {
        $this->db->from('m_dokumen_unit');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_dok_unit;

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

            $kolom_order = $this->kolom_order_dok_unit;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_dok_unit)) {
            
            $order = $this->order_dok_unit;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_dok_unit()
    {
      $this->db->from('m_dokumen_unit');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_dok_unit()
    {
        $this->_get_datatables_query_dok_unit();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Gudang Arsip
    /*
    /*****************************************************************************************************/

    // Master gudang_arsip
    public function get_data_gudang_arsip()
    {
        $this->_get_datatables_query_gudang_arsip();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_gudang_arsip = [null, 'kode_gudang_arsip', 'gudang_arsip', 'lokasi', 'kuota', 'status'];
    var $kolom_cari_gudang_arsip  = ['LOWER(kode_gudang_arsip)', 'LOWER(gudang_arsip)', 'LOWER(lokasi)', 'CAST(kuota as VARCHAR)', 'CAST(status as VARCHAR)'];
    var $order_gudang_arsip       = ['kode_gudang_arsip' => 'asc'];

    public function _get_datatables_query_gudang_arsip()
    {
        $this->db->from('m_gudang_arsip');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_gudang_arsip;

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

            $kolom_order = $this->kolom_order_gudang_arsip;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_gudang_arsip)) {
            
            $order = $this->order_gudang_arsip;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_gudang_arsip()
    {
      $this->db->from('m_gudang_arsip');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_gudang_arsip()
    {
        $this->_get_datatables_query_gudang_arsip();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Lemari Berkas
    /*
    /*****************************************************************************************************/

    // Master lemari_berkas
    public function get_data_lemari_berkas()
    {
        $this->_get_datatables_query_lemari_berkas();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_lemari_berkas = [null, 'b.kode_lemari_berkas', 'b.lemari_berkas', 'g.gudang_arsip', 'b.ket', 'b.status'];
    var $kolom_cari_lemari_berkas  = ['LOWER(b.kode_lemari_berkas)', 'LOWER(b.lemari_berkas)', 'LOWER(g.gudang_arsip)', 'LOWER(b.ket)', 'CAST(b.status as VARCHAR)'];
    var $order_lemari_berkas       = ['b.kode_lemari_berkas' => 'asc'];

    public function _get_datatables_query_lemari_berkas()
    {
        $this->db->select('b.*, g.gudang_arsip');
        $this->db->from('m_lemari_berkas as b');
        $this->db->join('m_gudang_arsip as g', 'g.id_gudang_arsip = b.letak', 'inner');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_lemari_berkas;

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

            $kolom_order = $this->kolom_order_lemari_berkas;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_lemari_berkas)) {
            
            $order = $this->order_lemari_berkas;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_lemari_berkas()
    {
        $this->db->select('b.*, g.gudang_arsip');
        $this->db->from('m_lemari_berkas as b');
        $this->db->join('m_gudang_arsip as g', 'g.id_gudang_arsip = b.letak', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_lemari_berkas()
    {
        $this->_get_datatables_query_lemari_berkas();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Rak Arsip
    /*
    /*****************************************************************************************************/

    // Master rak_arsip
    public function get_data_rak_arsip()
    {
        $this->_get_datatables_query_rak_arsip();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_rak_arsip = [null, 'kode_rak_arsip', 'rak_arsip', 'status'];
    var $kolom_cari_rak_arsip  = ['LOWER(kode_rak_arsip)', 'LOWER(rak_arsip)', 'CAST(status as VARCHAR)'];
    var $order_rak_arsip       = ['kode_rak_arsip' => 'asc'];

    public function _get_datatables_query_rak_arsip()
    {
        $this->db->from('m_rak_arsip');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_rak_arsip;

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

            $kolom_order = $this->kolom_order_rak_arsip;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_rak_arsip)) {
            
            $order = $this->order_rak_arsip;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_rak_arsip()
    {
      $this->db->from('m_rak_arsip');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_rak_arsip()
    {
        $this->_get_datatables_query_rak_arsip();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file Kearsipan_model.php */
/* Location: ./application/models/Kearsipan_model.php */