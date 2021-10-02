<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Dosen_model
class Guru_model extends CI_Model
{

    public $table = 'guru';
    public $id = 'id_guru';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_guru,nidn,nama_guru,alamat,jenis_kelamin,email,telp,photo');
        $this->datatables->from('guru');
        $this->datatables->add_column('action', anchor(site_url('guru/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  ".anchor(site_url('guru/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('guru/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_guru');
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
        $this->db->like('id_guru', $q);
	$this->db->or_like('nidn', $q);
	$this->db->or_like('nama_guru', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('photo', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_guru', $q);
	$this->db->or_like('nidn', $q);
	$this->db->or_like('nama_guru', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('telp', $q);
	$this->db->or_like('photo', $q);
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

