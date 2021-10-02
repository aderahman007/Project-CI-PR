<?php 
/*********************************************************/
/* File        : Kontak.php                           */
/* Lokasi File : ./application/controllers/Kontak.php */
/* Copyright   : Yosef Murya & Badiyanto                 */
/* Publish     : Penerbit Langit Inspirasi               */
/*-------------------------------------------------------*/

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
		
    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url('kontak/create_action'),
			'id_kontak' => set_value('id_kontak'),
			'nama' => set_value('nama'),
			'email' => set_value('email'),
			'telp' => set_value('telp'),
			'pesan' => set_value('pesan'),
		);
        $this->load->view('kontak/kontak_form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		else {
            $data = array(
					'id_kontak' => $this->input->post('id_kontak',TRUE),
					'nama' => $this->input->post('nama',TRUE),
					'email' => $this->input->post('email',TRUE),
					'telp' => $this->input->post('telp',TRUE),
					'pesan' => $this->input->post('pesan',TRUE),
					);
           
            $this->Kontak_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kontak'));
        }
    }
    
    public function _rules(){
	$this->form_validation->set_rules('id_kontak', 'id kontak', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('pesan', 'pesan', 'trim|required');

	$this->form_validation->set_rules('id_kontak', 'id_kontak', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kontak.php */