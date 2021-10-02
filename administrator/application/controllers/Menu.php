<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Menu
class Menu extends CI_Controller
{
	// Konstrutor 
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model'); // Memanggil Menu_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library       
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman utama menu
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
        $this->load->view('menu/menu_list'); // Menampilkan halaman utama menu
		$this->load->view('footer_list'); // Menampilkan bagian footer
		
    } 	
	
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Menu_model->json(); // Menampilkan data json yang terdapat pada Menu_model
    }
	
	// Fungsi menampilkan form Create Menu
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
			'back'   => site_url('menu'),
            'action' => site_url('menu/create_action'),
			'id_menu' => set_value('id_menu'),
			'nama_menu' => set_value('nama_menu'),
			'link' => set_value('link'),
			'icon' => set_value('icon'),
			'main_menu' => set_value('main_menu'),
	);
		$this->load->view('header',$dataAdm ); // Menampilkan bagian header dan object data users 
        $this->load->view('menu/menu_form', $data); // Menampilkan form menu
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules();  // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form menu belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
			
            $this->create();
        } 
		else {
		// Jika form menu telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
            $data = array(
						'nama_menu' => $this->input->post('nama_menu',TRUE),
						'link' => $this->input->post('link',TRUE),
						'icon' => $this->input->post('icon',TRUE),
						'main_menu' => $this->input->post('main_menu',TRUE),
			);

            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('menu'));
        }
    }
    
	// Fungsi menampilkan form Update Menu
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
		
		// Menampilkan data berdasarkan id-nya yaitu menu
        $row = $this->Menu_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data menu ditampilkan ke form edit menu
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('menu'),
                'action' => site_url('menu/update_action'),
				'id_menu' => set_value('id_menu', $row->id_menu),
				'nama_menu' => set_value('nama_menu', $row->nama_menu),
				'link' => set_value('link', $row->link),
				'icon' => set_value('icon', $row->icon),
				'main_menu' => set_value('main_menu', $row->main_menu),
	    );
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('menu/menu_form', $data); // Menampilkan form menu 
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		else {
			// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form menu belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_menu', TRUE));
        } 
		// Jika form menu telah diisi dengan benar 
		// maka sistem akan melakukan update data menu kedalam database
		else {
            $data = array(
				'nama_menu' => $this->input->post('nama_menu',TRUE),
				'link' => $this->input->post('link',TRUE),
				'icon' => $this->input->post('icon',TRUE),
				'main_menu' => $this->input->post('main_menu',TRUE),
	    );

            $this->Menu_model->update($this->input->post('id_menu', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('menu'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Menu_model->get_by_id($id);
		
		//jika id menu yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('menu'));
        } 
		//jika id menu yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('nama_menu', 'nama menu', 'trim|required');
	$this->form_validation->set_rules('link', 'link', 'trim|required');
	$this->form_validation->set_rules('icon', 'icon', 'trim|required');
	$this->form_validation->set_rules('main_menu', 'main menu', 'trim|required');

	$this->form_validation->set_rules('id_menu', 'id_menu', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }   

}

?>