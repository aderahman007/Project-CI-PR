<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Kelas
class Kelas extends CI_Controller
{
	// Konstrutor 
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_model'); // Memanggil Kelas_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library        
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman utama Kelas
    public function index()
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu username
		$row = $this->Users_model->get_by_id($this->session->userdata['username']);
		$data = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);		
		$this->load->view('header_list',$data); // Menampilkan bagian header dan object data users 
        $this->load->view('kelas/kelas_list'); // Menampilkan halaman utama kelas
		$this->load->view('footer_list'); // Menampilkan bagian footer		 
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Kelas_model->json(); // Menampilkan data json yang terdapat pada Kelas_model
    }
	
	// Fungsi menampilkan form Create Kelas
    public function create() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		// Menampilkan data berdasarkan id-nya yaitu username
		$row = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);	
		
		// Menampung data yang diinputkan 
        $data = array(
            'button' => 'Create',
			'back'   => site_url('kelas'),
            'action' => site_url('kelas/create_action'),
			'id_kelas' => set_value('id_kelas'),
			'kode_kelas' => set_value('kode_kelas'),
			'nama_kelas' => set_value('nama_kelas'),
	);
		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('kelas/kelas_form', $data); // Menampilkan form kelas
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form kelas belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form kelas telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
				'kode_kelas' => $this->input->post('kode_kelas',TRUE),
				'nama_kelas' => $this->input->post('nama_kelas',TRUE),
	    );

            $this->Kelas_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kelas'));
        }
    }
    
	// Fungsi menampilkan form Update Jurusan
    public function update($id) 
    {	
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
		
		// Menampilkan data berdasarkan id-nya yaitu kelas
        $row = $this->Kelas_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data Kelas ditampilkan ke form edit Kelas
        if ($row) {
			
            $data = array(
                'button' => 'Update',
				'back'   => site_url('kelas'),
                'action' => site_url('kelas/update_action'),
				'id_kelas' => set_value('id_kelas', $row->id_kelas), 
				'kode_kelas' => set_value('kode_kelas', $row->kode_kelas),
				'nama_kelas' => set_value('nama_kelas', $row->nama_kelas),
	    );
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('kelas/kelas_form', $data); // Menampilkan form kelas 
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form kelas belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kelas', TRUE));
        } 
		// Jika form kelas telah diisi dengan benar 
		// maka sistem akan melakukan update data kelas kedalam database
		else {			
		    $data = array(
				'kode_kelas' => $this->input->post('kode_kelas',TRUE),
				'nama_kelas' => $this->input->post('nama_kelas',TRUE),
			);

            $this->Kelas_model->update($this->input->post('id_kelas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kelas'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id) 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->Kelas_model->get_by_id($id);
		
		//jika id Kelas yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Kelas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kelas'));
        } 
		//jika id kelas yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('kode_kelas', 'kode kelas', 'trim|required');
	$this->form_validation->set_rules('nama_kelas', 'nama kelas', 'trim|required');

	$this->form_validation->set_rules('id_kelas', 'id_kelas', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}


?>