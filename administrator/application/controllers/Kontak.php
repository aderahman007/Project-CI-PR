<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Kontak
class Kontak extends CI_Controller
{
     // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Kontak_model'); // Memanggil Users_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library           
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman kontak
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
		
		$this->load->view('header_list', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('kontak/kontak_list'); // Menampilkan halaman utama kontak
		$this->load->view('footer_list'); // Menampilkan bagian footer
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Kontak_model->json();
    }     
    
    public function update($id) 
    {
        $row = $this->Kontak_model->get_by_id($id);

        if ($row) {
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
                'button' => 'Update',
                'action' => site_url('kontak/update_action'),
				'back'   => site_url('kontak'),
				'id_kontak' => set_value('id_kontak', $row->id_kontak),
				'nama' => set_value('nama', $row->nama),
				'email' => set_value('email', $row->email),
				'telp' => set_value('telp', $row->telp),
				'pesan' => set_value('pesan', $row->pesan),
			);
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('kontak/kontak_form', $data);
			$this->load->view('footer', $dataAdm); // Menampilkan bagian footer  
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kontak'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kontak', TRUE));
        } else {
            $data = array(
		'id_kontak' => $this->input->post('id_kontak',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'email' => $this->input->post('email',TRUE),
		'telp' => $this->input->post('telp',TRUE),
		'pesan' => $this->input->post('pesan',TRUE),
	    );

            $this->Kontak_model->update($this->input->post('id_kontak', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kontak'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kontak_model->get_by_id($id);

        if ($row) {
            $this->Kontak_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kontak'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kontak'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_kontak', 'id kontak', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('pesan', 'pesan', 'trim|required');

	$this->form_validation->set_rules('id_kontak', 'id_kontak', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

