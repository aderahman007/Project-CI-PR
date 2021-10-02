<?php
/*********************************************************/
/* File        : Identitas.php                           */
/* Lokasi File : ./application/controllers/Identitas.php */
/* Copyright   : Yosef Murya & Badiyanto                 */
/* Publish     : Penerbit Langit Inspirasi               */
/*-------------------------------------------------------*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Identitas
class Identitas extends CI_Controller
{
     // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Identitas_model');  // Memanggil Identitas_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation');  // Memanggil form_validation yang terdapat pada library 		
		$this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->helper('my_function'); // Memanggil fungsi my_function yang terdapat pada helper	
    }
	
	// Fungsi untuk menampilkan halaman identitas
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
			'univ'     => 'Universitas Langit Inspirasi',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);		
		$this->load->view('header_list',$data); // Menampilkan bagian header dan object data users 
        $this->load->view('identitas/identitas_list'); // Menampilkan halaman utama identitas
		$this->load->view('footer_list'); // Menampilkan bagian footer	
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Identitas_model->json();
    }
	/*
    public function read($id) 
    {
        $row = $this->Identitas_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_identitas' => $row->id_identitas,
		'nama_pemilik' => $row->nama_pemilik,
		'judul_website' => $row->judul_website,
		'url' => $row->url,
		'meta_deskripsi' => $row->meta_deskripsi,
		'meta_keyword' => $row->meta_keyword,
		'alamat' => $row->alamat,
		'email' => $row->email,
		'telp' => $row->telp,
		'facebook' => $row->facebook,
		'twitter' => $row->twitter,
		'twitter_widget' => $row->twitter_widget,
		'google_map' => $row->google_map,
		'favicon' => $row->favicon,
	    );
            $this->load->view('identitas/identitas_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('identitas'));
        }
    }
	*/    
    
	// Fungsi menampilkan form Update Identitas
    public function update($id){
		
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
				'wa'       => 'Web administrator',
				'univ'     => 'Universitas Langit Inspirasi',
				'username' => $rowAdm->username,
				'email'    => $rowAdm->email,
				'level'    => $rowAdm->level,
		);	
		
		// Menampilkan data berdasarkan id-nya yaitu identitas
        $row = $this->Identitas_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data identitas ditampilkan ke form edit identitas
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('identitas'),
                'action' => site_url('identitas/update_action'),
				'id_identitas' => set_value('id_identitas', $row->id_identitas),
				'nama_pemilik' => set_value('nama_pemilik', $row->nama_pemilik),
				'judul_website' => set_value('judul_website', $row->judul_website),
				'url' => set_value('url', $row->url),
				'meta_deskripsi' => set_value('meta_deskripsi', $row->meta_deskripsi),
				'meta_keyword' => set_value('meta_keyword', $row->meta_keyword),
				'alamat' => set_value('alamat', $row->alamat),
				'email' => set_value('email', $row->email),
				'telp' => set_value('telp', $row->telp),
				'facebook' => set_value('facebook', $row->facebook),
				'twitter' => set_value('twitter', $row->twitter),
				'twitter_widget' => set_value('twitter_widget', $row->twitter_widget),
				'google_map' => set_value('google_map', $row->google_map),
				'favicon' => set_value('favicon', $row->favicon),
				);
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('identitas/identitas_form', $data); // Menampilkan form  identitas
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('identitas'));
        }
    }
	
    // Fungsi untuk melakukan aksi update data
    public function update_action() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules();  // Rules atau aturan bahwa setiap form harus diisi	
		
		// Jika form identitas belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_identitas', TRUE));
        } 
		// Jika form identitas telah diisi dengan benar 
		// maka sistem akan melakukan update data identitas kedalam database
		else {			
			// Konfigurasi untuk melakukan upload favicon
			$config['upload_path']   = '../images/';    //path folder
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post(seo_title('nama_pemilik'))); //nama file favicon dirubah menjadi nama berdasarkan nama_pemilik	
			$this->upload->initialize($config);
			
			// Jika file favicon ada 
			if(!empty($_FILES['favicon']['name'])){	
			
				// Menghapus file image lama
				unlink("../images/".$this->input->post('favicon'));	
				
				// Upload file image baru
				if ($this->upload->do_upload('favicon')){					
					$favicon = $this->upload->data();	
					$datafavicon = $favicon['file_name'];					
					$this->load->library('upload', $config);
					
					$data = array(
								'id_identitas' => $this->input->post('id_identitas',TRUE),
								'nama_pemilik' => $this->input->post('nama_pemilik',TRUE),
								'judul_website' => $this->input->post('judul_website',TRUE),
								'url' => $this->input->post('url',TRUE),
								'meta_deskripsi' => $this->input->post('meta_deskripsi',TRUE),
								'meta_keyword' => $this->input->post('meta_keyword',TRUE),
								'alamat' => $this->input->post('alamat',TRUE),
								'email' => $this->input->post('email',TRUE),
								'telp' => $this->input->post('telp',TRUE),
								'facebook' => $this->input->post('facebook',TRUE),
								'twitter' => $this->input->post('twitter',TRUE),
								'twitter_widget' => $this->input->post('twitter_widget',TRUE),
								'google_map' => $this->input->post('google_map',TRUE),
								'favicon' => $datafavicon,
								);
					
					$this->Identitas_model->update($this->input->post('id_identitas', TRUE), $data);
					
				}
				
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('identitas'));
			
			}
			// Jika file favicon kosong 
			else{					
				// Menampung data yang diinputkan
				$data = array(
					'id_identitas' => $this->input->post('id_identitas',TRUE),
					'nama_pemilik' => $this->input->post('nama_pemilik',TRUE),
					'judul_website' => $this->input->post('judul_website',TRUE),
					'url' => $this->input->post('url',TRUE),
					'meta_deskripsi' => $this->input->post('meta_deskripsi',TRUE),
					'meta_keyword' => $this->input->post('meta_keyword',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					'email' => $this->input->post('email',TRUE),
					'telp' => $this->input->post('telp',TRUE),
					'facebook' => $this->input->post('facebook',TRUE),
					'twitter' => $this->input->post('twitter',TRUE),
					'twitter_widget' => $this->input->post('twitter_widget',TRUE),
					'google_map' => $this->input->post('google_map',TRUE),					
					);
				print_r($data);
					exit();
				$this->Identitas_model->update($this->input->post('id_identitas', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('identitas'));
			}
        }
    }
    
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('id_identitas', 'id identitas', 'trim|required');
	$this->form_validation->set_rules('nama_pemilik', 'nama pemilik', 'trim|required');
	$this->form_validation->set_rules('judul_website', 'judul website', 'trim|required');
	$this->form_validation->set_rules('url', 'url', 'trim|required');
	$this->form_validation->set_rules('meta_deskripsi', 'meta deskripsi', 'trim|required');
	$this->form_validation->set_rules('meta_keyword', 'meta keyword', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('facebook', 'facebook', 'trim|required');
	$this->form_validation->set_rules('twitter', 'twitter', 'trim|required');
	$this->form_validation->set_rules('twitter_widget', 'twitter widget', 'trim|required');
	$this->form_validation->set_rules('google_map', 'google map', 'trim|required');	
	$this->form_validation->set_rules('id_identitas', 'id_identitas', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}


/* End of file Identitas.php */
/* Location: ./application/controllers/Identitas.php */
/* Please DO NOT modify this information : */