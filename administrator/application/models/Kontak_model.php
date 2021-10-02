<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//*************************************
// deklarasi awal membuat kelas
//*************************************
class Kontak_model extends CI_Model
{
   
   // bagian properti
   
    public $table = 'kontak';
    public $id = 'id_kontak';
    public $order = 'DESC';
    
	// konstrutor
    //****************************   
   function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_kontak,nama,email,telp,pesan');
        $this->datatables->from('kontak');
        //add this line for join
        //$this->datatables->join('table2', 'kontak.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('kontak/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('kontak/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_kontak');
		return $this->datatables->generate();
    }

   
   // membaca isi semua rekaman : $this->table
   //*******************************************   
   function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // membaca 1 rekaman menggunakan kunci primary
    //*******************************************  
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // membaca dan menghitung jumlah rekaman
	//*******************************************
    function total_rows($q = NULL) {
        $this->db->like('id_kontak', $q);
	$this->db->or_like('id_kontak', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('pesan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // memabaca sejemlah rekaman dengan limit 
	//****************************************
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_kontak', $q);
	$this->db->or_like('id_kontak', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('pesan', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // menambahkan isi rekaman 
	//*************************************
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // mengubah rekaman
	//************************************
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // menghapus rekaman
	//**********************************
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
