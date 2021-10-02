<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Jadwal
class Jadwal extends CI_Controller
{
    // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_model'); // Memanggil Jadwal_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman matakuliah
    public function index(){	
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
        $this->load->view('jadwal/jadwal_list'); // Menampilkan halaman utama pelajran
		$this->load->view('footer_list'); // Menampilkan bagian footer
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Jadwal_model->json();
    }
	
	
	// Fungsi menampilkan form Create Pelajaran
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
			'back'   => site_url('jadwal'),
            'action' => site_url('jadwal/create_action'),
			'id_jadwal' => set_value('id_jadwal'),
			'kode_angkatan' => set_value('kode_angkatan'),
			'kode_pelajaran' => set_value('kode_pelajaran'),
			'id_guru' => set_value('id_guru'),
			'id_kelas' => set_value('id_kelas'),
			'hari' => set_value('hari'),
			'jam_mulai' => set_value('jam_mulai'),
			'jam_selesai' => set_value('jam_selesai'),
		);
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
        $this->load->view('jadwal/jadwal_form', $data); // Menampilkan halaman form matakuliah
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form pelajaran belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form pelajaran telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
                'kode_angkatan' => $this->input->post('kode_angkatan',TRUE),
                'kode_pelajaran' => $this->input->post('kode_pelajaran',TRUE),
                'id_guru' => $this->input->post('id_guru',TRUE),
                'id_kelas' => $this->input->post('id_kelas',TRUE),
                'hari' => $this->input->post('hari',TRUE),
                'jam_mulai' => $this->input->post('jam_mulai',TRUE),
                'jam_selesai' => $this->input->post('jam_selesai',TRUE),
			);

            $this->Jadwal_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jadwal'));
        }
    }
    
	// Fungsi menampilkan form Update Pelajaran
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
		
		// Menampilkan data berdasarkan id-nya yaitu id_jadwal
        $row = $this->Jadwal_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data jadwal ditampilkan ke form edit jadwal
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('jadwal'),
                'action' => site_url('jadwal/update_action'),
				'id_jadwal' => set_value('id_jadwal', $row->id_jadwal),
				'kode_angkatan' => set_value('kode_angkatan', $row->kode_angkatan),
				'kode_pelajaran' => set_value('kode_pelajaran', $row->kode_pelajaran),
				'id_guru' => set_value('id_guru', $row->id_guru),
				'id_kelas' => set_value('id_kelas', $row->id_kelas),
				'hari' => set_value('hari', $row->hari),
				'jam_mulai' => set_value('jam_mulai', $row->jam_mulai),
				'jam_selesai' => set_value('jam_selesai', $row->jam_selesai),
				);
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
            $this->load->view('jadwal/jadwal_form', $data); // Menampilkan form jadwal
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jadwal'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	
		
		// Jika form pelajaran belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jadwal', TRUE));
        } 
		// Jika form pelajaran telah diisi dengan benar 
		// maka sistem akan melakukan update data pelajaran kedalam database
		else {
            $data = array(
                'kode_angkatan' => $this->input->post('kode_angkatan', TRUE),
                'kode_pelajaran' => $this->input->post('kode_pelajaran', TRUE),
                'id_guru' => $this->input->post('id_guru', TRUE),
                'id_kelas' => $this->input->post('id_kelas', TRUE),
                'hari' => $this->input->post('hari', TRUE),
                'jam_mulai' => $this->input->post('jam_mulai', TRUE),
                'jam_selesai' => $this->input->post('jam_selesai', TRUE),
			);

            $this->Jadwal_model->update($this->input->post('id_jadwal', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jadwal'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Jadwal_model->get_by_id($id);
		
		//jika id jadwal yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Jadwal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jadwal'));
        } 
		//jika id jadwal yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jadwal'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
		$this->form_validation->set_rules('kode_angkatan', 'kode angkatan', 'trim|required');
		$this->form_validation->set_rules('kode_pelajaran', 'kode pelajaran', 'trim|required');
		$this->form_validation->set_rules('id_guru', 'id guru', 'trim|required');
		$this->form_validation->set_rules('id_kelas', 'id kelas', 'trim|required');
		$this->form_validation->set_rules('hari', 'hari', 'trim|required');
		$this->form_validation->set_rules('jam_mulai', 'jam mulai', 'trim|required');
		$this->form_validation->set_rules('jam_selesai', 'jam selesai', 'trim|required');

		$this->form_validation->set_rules('id_jadwal', 'id_jadwal', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

