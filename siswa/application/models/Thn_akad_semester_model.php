<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Thn_akad_semester_model
class Thn_akad_semester_model extends CI_Model
{
	// Property yang bersifat public   
    public $table = 'thn_akad_semester';
    public $id = 'id_thn_akad';
    public $order = 'DESC';
	
	// Konstrutor   
    function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama thn_akad_semester
    function json() {        
		$this->datatables->select("id_thn_akad, thn_akad, semester, IF(aktif = 'Y', 'Aktif', 'Tidak') as status, IF(semester = 1, 'Ganjil', 'Genap') as namaSemester");
        $this->datatables->from('thn_akad_semester');        
        $this->datatables->add_column('action', anchor(site_url('thn_akad_semester/aktif_action/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>')." ".anchor(site_url('thn_akad_semester/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('thn_akad_semester/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_thn_akad');
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
        $this->db->like('id_thn_akad', $q);
		$this->db->or_like('thn_akad', $q);
		$this->db->or_like('semester', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_thn_akad', $q);
		$this->db->or_like('thn_akad', $q);
		$this->db->or_like('semester', $q);
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
	
	// Merubah aktif kedalam database
	public function update_aktif($id) {		
		$query = $this->db->where('id_thn_akad  ='.$id);		
		$this->db->update($this->table, array('aktif' => 'Y'),$query);		
		return true;
	}
	
	// Merubah tidak aktif kedalam database
	public function update_tidakAktif($id) {		
		$query = $this->db->where('id_thn_akad  !='.$id);		
		$this->db->update($this->table, array('aktif' => 'N'),$query);		
		return true;
	}
	
	
    // Menghapus data kedalam database
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
