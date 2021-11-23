<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function get($table)
    {
      return $this->db->get($table)->result();
    }

    public function get_data($tabel)
    {
      return $this->db->get($tabel);
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


    public function joinUser1($username,$id)
    {
        $this->db->select('*');
        $this->db->from('m_data_user');
        $this->db->join('m_data_pegawai', 'm_data_pegawai.id_data_pegawai = m_data_user.id_data_pegawai');
        $this->db->where('username', $username);
        $this->db->where('id_data_user', $id);
        $query = $this->db->get()->row();
        return json_encode($query);
    }

    public function login($username,$password)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where(array( 'username' => $username,
                                'password' => md5($password)));
        $this->db->order_by('user_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function cekLogin()
    {
      if ($this->session->userdata('username') == "") {
          $this->session->set_flashdata('warning', 'Silahkan login terlebih dahulu');
          redirect(base_url('login'),'refresh');
      }
    }


    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('date_login');
        $this->session->set_flashdata('success', 'Sesi anda telah berakhir!');
        redirect(base_url('login'),'refresh');

    }

    // cari username 
    public function cari_username($username)
    {
      $this->db->select('u.username, l.id_data_level, u.*, p.*, u.add_time as add_time_user, k.*');
      $this->db->from('m_data_user as u');
      $this->db->join('m_data_pegawai as p', 'p.id_data_pegawai = u.id_data_pegawai', 'inner');
      $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
      $this->db->join('m_data_level as l', 'l.id_data_level = k.id_data_level', 'inner');
      $this->db->where('u.username', $username);
      
      return $this->db->get();
    }

    public function username($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('m_data_user');
        return $query;
    }

    function ajaxLogin($username,$password)
    {
        $this->db->select('*');
        $this->db->from('m_data_user');
        $this->db->where(array( 'username' => $username)); // password_verify('t', $hash2)
        $query = $this->db->get();
        return json_encode($query->row());
    }

    public function cekField($field,$isi)
    {
        $this->db->select($field);
        $this->db->from($this->_table);
        $this->db->where($field, $isi);
        return json_encode($this->db->get()->row());
    }

    public function cekDifField($field,$isi,$id)
    {
        $this->db->select($field);
        $this->db->from($this->_table);
        $this->db->where($field, $isi);
        $this->db->where('user_id !=', $id);
        return json_encode($this->db->get()->row());
    }

    // Afif

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
    /*                                              Level
    /*
    /*****************************************************************************************************/

    // Master level
    public function get_data_level()
    {
        $this->_get_datatables_query_level();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_level = [null, 'kode_level', 'nama_level'];
    var $kolom_cari_level  = ['LOWER(kode_level)', 'LOWER(nama_level)'];
    var $order_level       = ['kode_level' => 'asc'];

    public function _get_datatables_query_level()
    {
        $this->db->from('m_data_level');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_level;

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

            $kolom_order = $this->kolom_order_level;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_level)) {
            
            $order = $this->order_level;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_level()
    {
      $this->db->from('m_data_level');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_level()
    {
        $this->_get_datatables_query_level();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Jabatan
    /*
    /*****************************************************************************************************/

    // Master jabatan
    public function get_data_jabatan()
    {
        $this->_get_datatables_query_jabatan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_jabatan = [null, 'j.kode_jabatan', 'j.nama_jabatan', 'k.unit_kerja'];
    var $kolom_cari_jabatan  = ['LOWER(j.kode_jabatan)', 'LOWER(j.nama_jabatan)', 'LOWER(k.unit_kerja)'];
    var $order_jabatan       = ['j.kode_jabatan' => 'asc'];

    public function _get_datatables_query_jabatan()
    {
        $this->db->from('m_data_jabatan as j');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = j.id_unit_kerja', 'inner');

        $level          = $this->session->userdata('level');
        $id_unit_kerja  = $this->session->userdata('id_unit_kerja');

        if ($level == 2) :
            $this->db->where('k.id_unit_kerja', $id_unit_kerja);
            
        endif;

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_jabatan;

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

            $kolom_order = $this->kolom_order_jabatan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_jabatan)) {
            
            $order = $this->order_jabatan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_jabatan()
    {
      $this->db->from('m_data_jabatan as j');
      $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = j.id_unit_kerja', 'inner');

        $level          = $this->session->userdata('level');
        $id_unit_kerja  = $this->session->userdata('id_unit_kerja');

        if ($level == 2) :
            $this->db->where('k.id_unit_kerja', $id_unit_kerja);
            
        endif;

      return $this->db->count_all_results();
    }

    public function jumlah_filter_jabatan()
    {
        $this->_get_datatables_query_jabatan();

        return $this->db->get()->num_rows();
        
    }

    public function get_data_unit()
    {
        $this->db->select('u.id_unit_kerja, u.unit_kerja');
        $this->db->from('m_unit_kerja as u');
        $this->db->join('m_data_jabatan as j', 'j.id_unit_kerja = u.id_unit_kerja', 'inner');
        $this->db->group_by('u.id_unit_kerja');
        $this->db->group_by('u.unit_kerja');
        // $this->db->where('u.id_data_level', 1);
    
        return $this->db->get();
    }

    /*****************************************************************************************************/
    /*
    /*                                              Pegawai
    /*
    /*****************************************************************************************************/

    // Master pegawai
    public function get_data_pegawai()
    {
        $this->_get_datatables_query_pegawai();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_pegawai = [null, 'j.reg_employee', 'j.nama_pegawai', 'k.unit_kerja'];
    var $kolom_cari_pegawai  = ['LOWER(j.reg_employee)', 'LOWER(j.nama_pegawai)', 'LOWER(k.unit_kerja)'];
    var $order_pegawai       = ['j.reg_employee' => 'asc'];

    public function _get_datatables_query_pegawai()
    {
        $this->db->select('j.*, k.unit_kerja, b.nama_jabatan');
        $this->db->from('m_data_pegawai as j');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = j.id_unit_kerja', 'inner');
        $this->db->join('m_data_jabatan as b', 'b.id_data_jabatan = j.id_data_jabatan', 'inner');

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
            $this->db->where('k.id_unit_kerja', $id_unit_kerja);
            
        }

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_pegawai;

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

            $kolom_order = $this->kolom_order_pegawai;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_pegawai)) {
            
            $order = $this->order_pegawai;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_pegawai()
    {
      $this->db->select('j.*, k.unit_kerja, b.nama_jabatan');
      $this->db->from('m_data_pegawai as j');
      $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = j.id_unit_kerja', 'inner');
      $this->db->join('m_data_jabatan as b', 'b.id_data_jabatan = j.id_data_jabatan', 'inner');

        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
            $this->db->where('k.id_unit_kerja', $id_unit_kerja);
            
        }

      return $this->db->count_all_results();
    }

    public function jumlah_filter_pegawai()
    {
        $this->_get_datatables_query_pegawai();

        return $this->db->get()->num_rows();
        
    }

    public function cari_data_pegawai($id_unit_kerja, $id_jabatan)
    {
        // 'm_data_pegawai', array('id_unit_kerja' => $id_unit_kerja, 'id_data_jabatan' => )

        $this->db->select('*');
        $this->db->from('m_data_user');
        $a = $this->db->get()->result();
        $ay = array();
        foreach ($a as $b) {
            $ay[] = $b->id_data_pegawai;
        }

        $im     = implode(',',$ay);
        $peg    = explode(',',$im); 

        $this->db->select('p.id_data_pegawai, p.nama_pegawai');
        $this->db->from('m_data_pegawai as p');
        $this->db->where('p.id_unit_kerja', $id_unit_kerja);
        $this->db->where('p.id_data_jabatan', $id_jabatan);

        if ($peg[0] != "") {
            $this->db->where_not_in('p.id_data_pegawai', $peg);
        }


        return $this->db->get();
    }

    /*****************************************************************************************************/
    /*
    /*                                              User
    /*
    /*****************************************************************************************************/

    // Master user
    public function get_data_user()
    {
        $this->_get_datatables_query_user();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_user = [null, 'p.reg_employee', 'p.nama_pegawai', 'l.nama_level', 'j.username'];
    var $kolom_cari_user  = ['LOWER(p.reg_employee)', 'LOWER(p.nama_pegawai)', 'LOWER(l.nama_level)', 'LOWER(j.username)'];
    var $order_user       = ['j.id_data_user' => 'asc'];

    public function _get_datatables_query_user()
    {
        $this->db->select('j.*, p.*, l.nama_level');
        $this->db->from('m_data_user as j');
        $this->db->join('m_data_pegawai as p', 'p.id_data_pegawai = j.id_data_pegawai', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        $this->db->join('m_data_level as l', 'l.id_data_level = k.id_data_level', 'inner');
        
        $level           = $this->session->userdata('level');
        $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

        if ($level == 2) {
            $this->db->where('k.id_unit_kerja', $id_unit_kerja);
            
        }

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_user;

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

            $kolom_order = $this->kolom_order_user;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_user)) {
            
            $order = $this->order_user;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_user()
    {
      $this->db->select('j.*, p.*, l.nama_level');
      $this->db->from('m_data_user as j');
      $this->db->join('m_data_pegawai as p', 'p.id_data_pegawai = j.id_data_pegawai', 'inner');
      $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
      $this->db->join('m_data_level as l', 'l.id_data_level = k.id_data_level', 'inner');

    $level           = $this->session->userdata('level');
    $id_unit_kerja   = $this->session->userdata('id_unit_kerja');

    if ($level == 2) {
        $this->db->where('k.id_unit_kerja', $id_unit_kerja);
        
    }

      return $this->db->count_all_results();
    }

    public function jumlah_filter_user()
    {
        $this->_get_datatables_query_user();

        return $this->db->get()->num_rows();
        
    }

    public function cari_data_user($id_data_user)
    {
        $this->db->select('a.*, p.*, j.nama_jabatan, k.unit_kerja');
        $this->db->from('m_data_user as a');
        $this->db->join('m_data_pegawai as p', 'p.id_data_pegawai = a.id_data_pegawai', 'inner');
        $this->db->join('m_data_jabatan as j', 'j.id_data_jabatan = p.id_data_jabatan', 'inner');
        $this->db->join('m_unit_kerja as k', 'k.id_unit_kerja = p.id_unit_kerja', 'inner');
        
        $this->db->where('a.id_data_user', $id_data_user);
        
        return $this->db->get();
    }

    /*****************************************************************************************************/
    /*
    /*                                              Unit Kerja
    /*
    /*****************************************************************************************************/

    // Master unit_kerja
    public function get_data_unit_kerja()
    {
        $this->_get_datatables_query_unit_kerja();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_unit_kerja = [null, 'k.kode_unit_kerja', 'k.unit_kerja', 'l.nama_level'];
    var $kolom_cari_unit_kerja  = ['LOWER(k.kode_unit_kerja)', 'LOWER(k.unit_kerja)', 'LOWER(l.nama_level)'];
    var $order_unit_kerja       = ['k.kode_unit_kerja' => 'asc'];

    public function _get_datatables_query_unit_kerja()
    {
        $this->db->select('k.*, l.*');
        $this->db->from('m_unit_kerja as k');
        $this->db->join('m_data_level as l', 'l.id_data_level = k.id_data_level', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_unit_kerja;

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

            $kolom_order = $this->kolom_order_unit_kerja;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_unit_kerja)) {
            
            $order = $this->order_unit_kerja;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_unit_kerja()
    {
      $this->db->select('k.*, l.*');
      $this->db->from('m_unit_kerja as k');
      $this->db->join('m_data_level as l', 'l.id_data_level = k.id_data_level', 'inner');

      return $this->db->count_all_results();
    }

    public function jumlah_filter_unit_kerja()
    {
        $this->_get_datatables_query_unit_kerja();

        return $this->db->get()->num_rows();
        
    }

}

?>