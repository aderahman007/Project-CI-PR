<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Fasilitas_model
class Fasilitas_model extends CI_Model
{
   
   // bagian properti   
    public $table = 'fasilitas';
    public $id = 'id_fasilitas';
    public $order = 'DESC';
    
	// konstrutor
   function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_fasilitas,nama_fasilitas,icon_fasilitas');
        $this->datatables->from('fasilitas');        
		$this->datatables->add_column('action', anchor(site_url('fasilitas/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('fasilitas/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_fasilitas');
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
    function total_rows($q = NULL) {
        $this->db->like('id_fasilitas', $q);
	$this->db->or_like('id_fasilitas', $q);
	$this->db->or_like('nama_fasilitas', $q);
	$this->db->or_like('icon_fasilitas', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_fasilitas', $q);
	$this->db->or_like('id_fasilitas', $q);
	$this->db->or_like('nama_fasilitas', $q);
	$this->db->or_like('icon_fasilitas', $q);
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

