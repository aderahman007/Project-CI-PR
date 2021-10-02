<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Materi_perkuliahan
class Materi_perkuliahan extends CI_Controller
{
     // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Materi_perkuliahan_model'); // Memanggil Materi_perkuliahan_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }

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
        $this->load->view('materi_perkuliahan/materi_perkuliahan_list');  // Menampilkan halaman utama materi perkuliahan list
		$this->load->view('footer_list'); // Menampilkan bagian footer
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Materi_perkuliahan_model->json();
    }
	
	// Fungsi menampilkan form Create Materi Perkuliahan
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
		
        $data = array(
            'button' => 'Create',
            'action' => site_url('materi_perkuliahan/create_action'),
			'back'   => site_url('materi_perkuliahan'),
			'id_materiperkuliahan' => set_value('id_materiperkuliahan'),
			'judul_materiperkuliahan' => set_value('judul_materiperkuliahan'),
			'isi_materiperkuliahan' => set_value('isi_materiperkuliahan'),
			'icon' => set_value('icon'),
		);
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('materi_perkuliahan/materi_perkuliahan_form', $data); // Menampilkan halaman form materi perkuliahan
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		
        // Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form materi perkuliahan belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form materi perkuliahan telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
		'id_materiperkuliahan' => $this->input->post('id_materiperkuliahan',TRUE),
		'judul_materiperkuliahan' => $this->input->post('judul_materiperkuliahan',TRUE),
		'isi_materiperkuliahan' => $this->input->post('isi_materiperkuliahan',TRUE),
		'icon' => $this->input->post('icon',TRUE),
	    );
           
            $this->Materi_perkuliahan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('materi_perkuliahan'));
        }
    }
    
	// Fungsi menampilkan form Update Materi Perkuliahan
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
		
		// Menampilkan data berdasarkan id-nya yaitu id_materiperkuliahan
        $row = $this->Materi_perkuliahan_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data materi perkuliahan ditampilkan ke form edit
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('materi_perkuliahan/update_action'),
				'back'   => site_url('materi_perkuliahan'),
				'id_materiperkuliahan' => set_value('id_materiperkuliahan', $row->id_materiperkuliahan),
				'judul_materiperkuliahan' => set_value('judul_materiperkuliahan', $row->judul_materiperkuliahan),
				'isi_materiperkuliahan' => set_value('isi_materiperkuliahan', $row->isi_materiperkuliahan),
				'icon' => set_value('icon', $row->icon),
				);
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('materi_perkuliahan/materi_perkuliahan_form', $data); // Menampilkan form materi perkuliahan
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('materi_perkuliahan'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	
		
		// Jika form mater perkuliahan belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang       
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_materiperkuliahan', TRUE));
        } 
		// Jika form mater perkuliahan telah diisi dengan benar 
		// maka sistem akan melakukan update data mater perkuliahan kedalam database
		else {
            $data = array(
		'id_materiperkuliahan' => $this->input->post('id_materiperkuliahan',TRUE),
		'judul_materiperkuliahan' => $this->input->post('judul_materiperkuliahan',TRUE),
		'isi_materiperkuliahan' => $this->input->post('isi_materiperkuliahan',TRUE),
		'icon' => $this->input->post('icon',TRUE),
	    );

            $this->Materi_perkuliahan_model->update($this->input->post('id_materiperkuliahan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('materi_perkuliahan'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->Materi_perkuliahan_model->get_by_id($id);
		
		//jika id mater perkuliahan yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Materi_perkuliahan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('materi_perkuliahan'));
        } 
		//jika id mater perkuliahan yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('materi_perkuliahan'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules(){
	$this->form_validation->set_rules('id_materiperkuliahan', 'id materiperkuliahan', 'trim|required');
	$this->form_validation->set_rules('judul_materiperkuliahan', 'judul materiperkuliahan', 'trim|required');
	$this->form_validation->set_rules('isi_materiperkuliahan', 'isi materiperkuliahan', 'trim|required');
	$this->form_validation->set_rules('icon', 'icon', 'trim|required');

	$this->form_validation->set_rules('id_materiperkuliahan', 'id_materiperkuliahan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
