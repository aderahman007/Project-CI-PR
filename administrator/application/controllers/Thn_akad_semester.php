<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Thn_akad_semester
class Thn_akad_semester extends CI_Controller
{
	// Konstruktor	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Thn_akad_semester_model'); // Memanggil Thn_akad_semester_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models 
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library        
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman tahun akademik semester
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
        $this->load->view('thn_akad_semester/thn_akad_semester_list'); // Menampilkan halaman tahun akademik
		$this->load->view('footer_list'); // Menampilkan bagian footer
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Thn_akad_semester_model->json();
    }
	
	// Fungsi menampilkan form Create Tahun akademik semester
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
			'back'   => site_url('thn_akad_semester'),
            'action' => site_url('thn_akad_semester/create_action'),
			'id_thn_akad' => set_value('id_thn_akad'),
			'thn_akad' => set_value('thn_akad'),
			'semester' => set_value('semester'),
	);
	
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users
        $this->load->view('thn_akad_semester/thn_akad_semester_form', $data); // Menampilkan halaman utama yaitu form tahun akademik semester
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form tahun akademik semester belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form tahun akademik semester telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
				'thn_akad' => $this->input->post('thn_akad',TRUE),
				'semester' => $this->input->post('semester',TRUE),
			);

            $this->Thn_akad_semester_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('thn_akad_semester'));
        }
    }
    
	// Fungsi menampilkan form Update tahun akademik semester
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
        $row = $this->Thn_akad_semester_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data tahun akademik semester ditampilkan ke form edit tahun akademik semester
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('thn_akad_semester'),
                'action' => site_url('thn_akad_semester/update_action'),
				'id_thn_akad' => set_value('id_thn_akad', $row->id_thn_akad),
				'thn_akad' => set_value('thn_akad', $row->thn_akad),
				'semester' => set_value('semester', $row->semester),
			);
			$this->load->view('header',$dataAdm ); // Menampilkan bagian header dan object data users
            $this->load->view('thn_akad_semester/thn_akad_semester_form', $data);  // Menampilkan form tahun akademik semester
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thn_akad_semester'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form tahun akademik semester belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_thn_akad', TRUE));
        } 
		// Jika form tahun akademik semester telah diisi dengan benar 
		// maka sistem akan melakukan update data tahun akademik semester kedalam database
		else {
            $data = array(
		'thn_akad' => $this->input->post('thn_akad',TRUE),
		'semester' => $this->input->post('semester',TRUE),
	    );

            $this->Thn_akad_semester_model->update($this->input->post('id_thn_akad', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('thn_akad_semester'));
        }
    }
	
	// Fungsi untuk melakukan aksi update data
    public function aktif_action($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		$rows = $this->Thn_akad_semester_model->get_by_id($id);
			
		//jika id tahun akademik semester yang dipilih tersedia maka akan diaktifkan
		if ($rows) {	
				
			$this->Thn_akad_semester_model->update_tidakAktif($id);		
			
			$this->Thn_akad_semester_model->update_aktif($id);	
			
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('thn_akad_semester'));
		}
		//jika id tahun akademik semester yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
			
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thn_akad_semester'));
        }
        
	}
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Thn_akad_semester_model->get_by_id($id);
		
		//jika id tahun akademik semester yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Thn_akad_semester_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('thn_akad_semester'));
        } 
		//jika id tahun akademik semester yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thn_akad_semester'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('thn_akad', 'thn akad', 'trim|required');
	$this->form_validation->set_rules('semester', 'semester', 'trim|required');

	$this->form_validation->set_rules('id_thn_akad', 'id_thn_akad', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}


?>