<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Angkatan
class Angkatan extends CI_Controller
{
	// Konstruktor	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Angkatan_model'); // Memanggil Angkatan Model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models 
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library        
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman tahun akademik angkatan
    public function index(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);	
		
		$this->load->view('header_list',$dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('angkatan/angkatan_list'); // Menampilkan halaman tahun akademik
		$this->load->view('footer_list'); // Menampilkan bagian footer
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Angkatan_model->json();
    }
	
	// Fungsi menampilkan form Create Tahun akademik angkatan
    public function create(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);	
		
		// Menampung data yang diinputkan	
        $data = array(
            'button' => 'Create',
			'back'   => site_url('angkatan'),
            'action' => site_url('angkatan/create_action'),
			'kode_angkatan' => set_value('kode_angkatan'),
			'tahun_angkatan' => set_value('tahun_angkatan'),
			'nama_angkatan' => set_value('nama_angkatan'),
	);
	
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users
        $this->load->view('angkatan/angkatan_form', $data); // Menampilkan halaman utama yaitu form tahun akademik angkatan
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form angkatan belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form angkatan telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
				'kode_angkatan' => $this->input->post('kode_angkatan',TRUE),
				'tahun_angkatan' => $this->input->post('tahun_angkatan',TRUE),
				'nama_angkatan' => $this->input->post('nama_angkatan',TRUE),
			);

            $this->Angkatan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('angkatan'));
        }
    }
    
	// Fungsi menampilkan form Update angakatan
    public function update($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);	
		
		// Menampilkan data berdasarkan id-nya yaitu kode_matakuliah
        $row = $this->Angkatan_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data angkatan ditampilkan ke form edit angkatan
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('angkatan'),
                'action' => site_url('angkatan/update_action'),
				'kode_angkatan' => set_value('kode_angkatan', $row->kode_angkatan),
				'tahun_angkatan' => set_value('tahun_angkatan', $row->tahun_angkatan),
				'nama_angkatan' => set_value('nama_angkatan', $row->nama_angkatan),
			);
			$this->load->view('header',$dataAdm ); // Menampilkan bagian header dan object data users
            $this->load->view('angkatan/angkatan_form', $data);  // Menampilkan form tahun akademik semester
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('angkatan'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form angkatan belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_angkatan', TRUE));
        } 
		// Jika form angkatan telah diisi dengan benar 
		// maka sistem akan melakukan update data angkatan kedalam database
		else {
            $data = array(
                'kode_angkatan' => $this->input->post('kode_angkatan', TRUE),
                'tahun_angkatan' => $this->input->post('tahun_angkatan', TRUE),
                'nama_angkatan' => $this->input->post('nama_angkatan', TRUE),
            );

			// var_dump($data);die;

            $this->Angkatan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('angkatan'));
        }
    }
	
	// Fungsi untuk melakukan aksi update data
    public function aktif_action($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		$rows = $this->Angkatan_model->get_by_id($id);
			
		//jika id angkatan yang dipilih tersedia maka akan diaktifkan
		if ($rows) {	
				
			$this->Angkatan_model->update_tidakAktif($id);		
			
			$this->Angkatan_model->update_aktif($id);	
			
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('angkatan'));
		}
		//jika id angkatan yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
			
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('angkatan'));
        }
        
	}
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Angkatan_model->get_by_id($id);
		
		//jika id tahun akademik semester yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Angkatan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('angkatan'));
        } 
		//jika id tahun akademik semester yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('angkatan'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('kode_angkatan', 'kode angkatan', 'trim|required');
	$this->form_validation->set_rules('tahun_angkatan', 'tahun angkatan', 'trim|required');
	$this->form_validation->set_rules('nama_angkatan', 'nama angkatan', 'trim|required');
	
	$this->form_validation->set_rules('kode_angkatan', 'kode angkatan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

