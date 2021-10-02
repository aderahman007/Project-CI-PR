<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Jadwal_model
class Jadwal_model extends CI_Model
{
    // Property yang bersifat public   
    public $table = 'jadwal';
    public $id = 'id_jadwal';
    public $order = 'DESC';
    public $hasil = '';

    // Konstrutor    
    function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama jadwal dan kelas 
    function json()
    {
        $nim = $this->session->userdata['username'];
        $query_siswa = "SELECT siswa.nim
							 , kelas.id_kelas
							 , kelas.nama_kelas
						  FROM
							 siswa
							INNER JOIN kelas 
							ON (siswa.id_kelas = kelas.id_kelas)
							WHERE siswa.nim = $nim;";
        $angkatan = $this->db->where('aktif', 'Y')->get('angkatan')->row();
        $kelas = $this->db->query($query_siswa)->row();

        $this->datatables->select("j.id_jadwal,j.kode_angkatan,j.hari, j.jam_mulai, j.jam_selesai, p.nama_pelajaran, g.nama_guru, k.nama_kelas");
        $this->datatables->from('jadwal as j');
        //add this line for join
        $this->datatables->join('pelajaran as p', 'j.kode_pelajaran = p.kode_pelajaran');
        $this->datatables->join('guru as g', 'j.id_guru = g.id_guru');
        $this->datatables->join('kelas as k', 'j.id_kelas = k.id_kelas');
        $this->datatables->where('j.id_kelas', $kelas->id_kelas);
        $this->datatables->where('j.kode_angkatan', $angkatan->kode_angkatan);
        
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
        $this->db->like('id_jadwal', $q);
        $this->db->or_like('id_jadwal', $q);
        $this->db->or_like('nama_pelajaran', $q);
        $this->db->or_like('nama_guru', $q);
        $this->db->or_like('nama_kelas', $q);
        $this->db->or_like('haari', $q);
        $this->db->or_like('jam_mulai', $q);
        $this->db->or_like('jam_selesai', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_jadwal', $q);
        $this->db->or_like('id_jadwal', $q);
        $this->db->or_like('nama_pelajaran', $q);
        $this->db->or_like('nama_guru', $q);
        $this->db->or_like('nama_kelas', $q);
        $this->db->or_like('haari', $q);
        $this->db->or_like('jam_mulai', $q);
        $this->db->or_like('jam_selesai', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

}

