<?php
/******************************************/
/* File    :Identitas_model.php                       */
/* Location: ./application/models/Identitas_model.php */
/******************************************/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//*************************************
// deklarasi awal membuat kelas
//*************************************
class Identitas_model extends CI_Model
{
   
   // bagian properti
   
    public $table = 'identitas';
    public $id = 'id_identitas';
    public $order = 'DESC';
    
	// konstrutor
    //****************************   
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama identitas	
    function json() {
        $this->datatables->select('id_identitas,nama_pemilik,judul_website,url,alamat,email,telp');
        $this->datatables->from('identitas');        
        $this->datatables->add_column('action', anchor(site_url('identitas/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>'), 'id_identitas');
		return $this->datatables->generate();
    }
   
   // Menampilkan semua data 
   function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // Menampilkan semua data berdasarkan id-nya
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // menampilkan jumlah data
    function total_rows($q = NULL) {
    $this->db->like('id_identitas', $q);
	$this->db->or_like('id_identitas', $q);
	$this->db->or_like('nama_pemilik', $q);
	$this->db->or_like('judul_website', $q);
	$this->db->or_like('url', $q);
	$this->db->or_like('meta_deskripsi', $q);
	$this->db->or_like('meta_keyword', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('facebook', $q);
	$this->db->or_like('twitter', $q);
	$this->db->or_like('twitter_widget', $q);
	$this->db->or_like('google_map', $q);	
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

     // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
    $this->db->order_by($this->id, $this->order);
    $this->db->like('id_identitas', $q);
	$this->db->or_like('id_identitas', $q);
	$this->db->or_like('nama_pemilik', $q);
	$this->db->or_like('judul_website', $q);
	$this->db->or_like('url', $q);
	$this->db->or_like('meta_deskripsi', $q);
	$this->db->or_like('meta_keyword', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('facebook', $q);
	$this->db->or_like('twitter', $q);
	$this->db->or_like('twitter_widget', $q);
	$this->db->or_like('google_map', $q);	
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Merubah data kedalam database
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }    

}

/* End of file Identitas_model.php */
/* Location: ./application/models/Identitas_model.php */