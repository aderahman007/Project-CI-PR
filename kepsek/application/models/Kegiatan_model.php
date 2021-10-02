<?php 

if (!defined('BASEPATH'))
exit('No direct script access allowed');

// Deklarasi pembuatan class Kegiatan_model
class Kegiatan_model extends CI_Model
{
    // bagian properti   
    public $table = 'kegiatan';
    public $id = 'id_kegiatan';
    public $order = 'DESC';

    // konstrutor
    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('id_kegiatan,nama_kegiatan,galery,deskripsi');
        $this->datatables->from('kegiatan');
        $this->datatables->add_column('action', anchor(site_url('kegiatan/read/$1'), '<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>') . "  " .anchor(site_url('kegiatan/update/$1'), '<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>') . "  " . anchor(site_url('kegiatan/delete/$1'), '<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_kegiatan');
        return $this->datatables->generate();
    }


    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id 
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_kegiatan', $q);
        $this->db->or_like('id_kegiatan', $q);
        $this->db->or_like('nama_kegiatan', $q);
        $this->db->or_like('deskripsi', $q);
        $this->db->or_like('galery', $q);
        $this->db->or_like('icon_kegiatan', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_kegiatan', $q);
        $this->db->or_like('id_kegiatan', $q);
        $this->db->or_like('nama_kegiatan', $q);
        $this->db->or_like('deskripsi', $q);
        $this->db->or_like('galery', $q);
        $this->db->or_like('icon_kegiatan', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

?>