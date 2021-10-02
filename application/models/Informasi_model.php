<?php
/**********************************************************/
/* File        : Informasi_model.php                      */
/* Lokasi File : ./application/models/Informasi_model.php  */
/* Copyright   : Yosef Murya & Badiyanto                  */
/* Publish     : Penerbit Langit Inspirasi                */
/*--------------------------------------------------------*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Mahasiswa_model
class Informasi_model extends CI_Model
{
   
    // Property yang bersifat public
    public $table = 'informasi';
    public $id = 'id_informasi';
    public $order = 'DESC';
    
	// Konstrutor 
   function __construct()
    {
        parent::__construct();		
    }

    // Tabel data dengan nama informasi
    function json() {
        $this->datatables->select("i.id_informasi,i.judul_informasi, DATE_FORMAT(i.tanggal,'%d %M %Y') as tanggal,i.dibaca,IF(i.aktif = 'Y', 'Ya', 'Tidak') as aktif, k.nama_kategori");
        $this->datatables->from('informasi as i');   
		 //add this line for join
        $this->datatables->join('kategori as k','k.id_kategori= i.id_kategori');
        //$this->datatables->add_column('action', anchor(site_url('informasi/read/$1'),'Read')." | ".anchor(site_url('informasi/update/$1'),'Update')." | ".anchor(site_url('informasi/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_informasi');
        $this->datatables->add_column('action', anchor(site_url('informasi/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('informasi/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_informasi');
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
        $this->db->like('id_informasi', $q);
	$this->db->or_like('id_informasi', $q);
	$this->db->or_like('id_kategori', $q);
	$this->db->or_like('username', $q);
	$this->db->or_like('judul_informasi', $q);
	$this->db->or_like('judul_seo', $q);
	$this->db->or_like('isi_informasi', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('hari', $q);
	$this->db->or_like('gambar', $q);
	$this->db->or_like('dibaca', $q);
	$this->db->or_like('aktif', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
		$this->db->like('id_informasi', $q);
		$this->db->or_like('id_informasi', $q);
		$this->db->or_like('id_kategori', $q);
		$this->db->or_like('username', $q);
		$this->db->or_like('judul_informasi', $q);
		$this->db->or_like('judul_seo', $q);
		$this->db->or_like('isi_informasi', $q);
		$this->db->or_like('tanggal', $q);
		$this->db->or_like('hari', $q);
		$this->db->or_like('gambar', $q);
		$this->db->or_like('dibaca', $q);
		$this->db->or_like('aktif', $q);
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

/* End of file Informasi_model.php */
/* Location: ./application/models/Informasi_model.php */
/* Please DO NOT modify this information : */