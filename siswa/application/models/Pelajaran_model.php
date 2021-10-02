<?php



if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Pelajaran_model
class Pelajaran_model extends CI_Model
{
    // Property yang bersifat public   
    public $table = 'Pelajaran';
    public $id = 'kode_Pelajaran';
    public $order = 'DESC';
    public $hasil = '';

    // Konstrutor    
    function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama pelajaran dan kelas 
    function json()
    {
        $username    = $this->session->userdata['username'];
        $this->datatables->select("pelajaran.kkm, pelajaran.kode_pelajaran, pelajaran.nama_pelajaran, kelas.nama_kelas");
        $this->datatables->from('pelajaran, kelas, siswa');
        //add this line for join        
        $this->datatables->where('siswa.nim = ' . $username);
        $this->datatables->where('siswa.id_kelas = kelas.id_kelas');
        $this->datatables->where('pelajaran.id_kelas = siswa.id_kelas');
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
    function total_rows($q = NULL)
    {
        $this->db->like('kode_pelajaran', $q);
        $this->db->or_like('kode_pelajaran', $q);
        $this->db->or_like('nama_pelajaran', $q);
        $this->db->or_like('kkm', $q);
        $this->db->or_like('semester', $q);
        $this->db->or_like('id_kelas', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_pelajaran', $q);
        $this->db->or_like('kode_pelajaran', $q);
        $this->db->or_like('nama_pelajaran', $q);
        $this->db->or_like('kkm', $q);
        $this->db->or_like('semester', $q);
        $this->db->or_like('id_kelas', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
}
