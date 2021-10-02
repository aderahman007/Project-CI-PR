<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Pelajaran_model
class Pelajaran_model extends CI_Model
{
    // Property yang bersifat public   
    public $table = 'pelajaran';
    public $id = 'kode_pelajaran';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama pelajaran dan kelas 
    function json() {       
		$this->datatables->select("m.kode_pelajaran, m.nama_pelajaran, p.nama_kelas");
        $this->datatables->from(' pelajaran as m');
        //add this line for join
        $this->datatables->join('kelas as p','m.id_kelas= p.id_kelas');
        $this->datatables->add_column('action', anchor(site_url('pelajaran/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  ".anchor(site_url('pelajaran/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('pelajaran/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_pelajaran');
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
        $this->db->like('kode_pelajaran', $q);
		$this->db->or_like('kode_pelajaran', $q);
		$this->db->or_like('nama_pelajaran', $q);
		$this->db->or_like('kkm', $q);
		$this->db->or_like('semester', $q);
		$this->db->or_like('jenis', $q);
		$this->db->or_like('id_kelas', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_pelajaran', $q);
		$this->db->or_like('kode_pelajaran', $q);
		$this->db->or_like('nama_pelajaran', $q);
		$this->db->or_like('kkm', $q);
		$this->db->or_like('semester', $q);
		$this->db->or_like('jenis', $q);
		$this->db->or_like('id_kelas', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Menambahkan data kedalam database
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // Merubah data kedalam database
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Menghapus data kedalam database
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
