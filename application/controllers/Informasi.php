<?php
/*********************************************************/
/* File        : Informasi.php                           */
/* Lokasi File : ./application/controllers/Informasi.php */
/* Copyright   : Yosef Murya & Badiyanto                 */
/* Publish     : Penerbit Langit Inspirasi               */
/*-------------------------------------------------------*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Informasi
class Informasi extends CI_Controller
{
     // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Informasi_model'); // Memanggil Informasi_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library 
		$this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->helper('my_function'); // Memanggil fungsi my_function yang terdapat pada helper	
    }
	
	// Fungsi untuk menampilkan halaman informasi
    public function index(){
		
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
        $this->load->view('informasi/informasi_list'); // Menampilkan halaman utama informasi
		$this->load->view('footer_list'); // Menampilkan bagian footer	
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Informasi_model->json();
    }
	
	/*
    public function read($id) 
    {
        $row = $this->Informasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_informasi' => $row->id_informasi,
		'id_kategori' => $row->id_kategori,
		'username' => $row->username,
		'judul_informasi' => $row->judul_informasi,
		'judul_seo' => $row->judul_seo,
		'isi_informasi' => $row->isi_informasi,
		'tanggal' => $row->tanggal,
		'hari' => $row->hari,
		'gambar' => $row->gambar,
		'dibaca' => $row->dibaca,
		'aktif' => $row->aktif,
	    );
            $this->load->view('informasi/informasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('informasi'));
        }
    }
	*/
	
	// Fungsi menampilkan form Create Informasi
    public function create(){
		
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
				'wa'       => 'Web administrator',
				'univ'     => 'Universitas Langit Inspirasi',
				'back'   => site_url('informasi'),
				'username' => $rowAdm->username,
				'email'    => $rowAdm->email,
				'level'    => $rowAdm->level,
		);	
		
		// Menampung data yang diinputkan
        $data = array(
            'button' => 'Create',
            'action' => site_url('informasi/create_action'),
			'id_informasi' => set_value('id_informasi'),
			'id_kategori' => set_value('id_kategori'),			
			'judul_informasi' => set_value('judul_informasi'),			
			'isi_informasi' => set_value('isi_informasi'),			
			'gambar' => set_value('gambar'),			
			'aktif' => set_value('aktif'),
			);
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('informasi/informasi_form', $data); // Menampilkan form  informasi
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
		
		// Jika form informasi belum diisi dengan benar 
		// maka sistem akan meminta admin untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form informasi telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
			
			// konfigurasi untuk melakukan upload gambar
			$config['upload_path']   = '../images/info_kampus/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('judul_informasi')); //nama file gambar dirubah menjadi nama berdasarkan id_informasi	
			$this->upload->initialize($config);
			
			// Jika file gambar ada 
			if(!empty($_FILES['gambar']['name'])){
				
				if ($this->upload->do_upload('gambar')){
					$gambar = $this->upload->data();	
					$datagambar = $gambar['file_name'];					
					$this->load->library('upload', $config);	
			
					$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
			
					$data = array(
								'id_informasi'    => $this->input->post('id_informasi',TRUE),
								'id_kategori'     => $this->input->post('id_kategori',TRUE),						
								'username'        => $rowAdm->username,
								'judul_informasi' => $this->input->post('judul_informasi',TRUE),
								'judul_seo'       => seo_title($this->input->post('judul_informasi',TRUE)),						
								'isi_informasi'   => $this->input->post('isi_informasi',TRUE),
								'tanggal'         => date("Y-m-d"),
								'hari'            => array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")[date("w")],
								'gambar'          => $datagambar, 								
								'aktif'           => $this->input->post('aktif',TRUE),
								);
					
					$this->Informasi_model->insert($data);
					
				}
				
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('informasi'));
				
			}
			// Jika file gambar kosong 
			else{	
					$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
					
					$data = array(
								'id_informasi'    => $this->input->post('id_informasi',TRUE),
								'id_kategori'     => $this->input->post('id_kategori',TRUE),						
								'username'        => $rowAdm->username,
								'judul_informasi' => $this->input->post('judul_informasi',TRUE),
								'judul_seo'       => seo_title($this->input->post('judul_informasi',TRUE)),						
								'isi_informasi'   => $this->input->post('isi_informasi',TRUE),
								'tanggal'         => date("Y-m-d"),
								'hari'            => array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")[date("w")],								
								'aktif'           => $this->input->post('aktif',TRUE),
								);
				   
				$this->Informasi_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('informasi'));
			}
			
		}			
        
    }
    
	// Fungsi menampilkan form Update Informasi
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
				'back'   => site_url('informasi'),
				'username' => $rowAdm->username,
				'email'    => $rowAdm->email,
				'level'    => $rowAdm->level,
		);	
		
		// Menampilkan data berdasarkan id-nya yaitu id_informasi
        $row = $this->Informasi_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data informasi ditampilkan ke form edit informasi
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('informasi/update_action'),
				'back'   => site_url('informasi'),
				'id_informasi' => set_value('id_informasi', $row->id_informasi),
				'id_kategori' => set_value('id_kategori', $row->id_kategori),				
				'judul_informasi' => set_value('judul_informasi', $row->judul_informasi),				
				'isi_informasi' => set_value('isi_informasi', $row->isi_informasi),				
				'gambar' => set_value('gambar', $row->gambar),				
				'aktif' => set_value('aktif', $row->aktif),
				);
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('informasi/informasi_form', $data); // Menampilkan form  informasi
			$this->load->view('footer'); // Menampilkan bagian footer
			
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('informasi'));
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
		
		// Jika form informasi belum diisi dengan benar 
		// maka sistem akan meminta admin untuk menginput ulang		
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_informasi', TRUE));
        } 
		// Jika form informasi telah diisi dengan benar 
		// maka sistem akan melakukan update data informasi kedalam database
		else {
			
			// Konfigurasi untuk melakukan upload gambar
			$config['upload_path']   = '../images/info_kampus/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('judul_informasi')); //nama file gambar dirubah menjadi nama berdasarkan judul_informasi	
			$this->upload->initialize($config);
			
			// Jika file gambar ada 
			if(!empty($_FILES['gambar']['name'])){	
				
				// Menghapus file image lama
				unlink("../images/info_kampus/".$this->input->post('gambar'));	
				
				// Upload file image baru
				if ($this->upload->do_upload('gambar')){
					$gambar = $this->upload->data();	
					$datagambar = $gambar['file_name'];					
					$this->load->library('upload', $config);
					
					$data = array(
								'id_informasi' => $this->input->post('id_informasi',TRUE),
								'id_kategori' => $this->input->post('id_kategori',TRUE),					
								'judul_informasi' => $this->input->post('judul_informasi',TRUE),
								'judul_seo'       => seo_title($this->input->post('judul_informasi',TRUE)),		
								'isi_informasi' => $this->input->post('isi_informasi',TRUE),					
								'gambar' => $datagambar,					
								'aktif' => $this->input->post('aktif',TRUE),
								);

					$this->Informasi_model->update($this->input->post('id_informasi', TRUE), $data);
				
				}
				
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('informasi'));
			}
			// Jika file photo kosong 
			else{		
				// Menampung data yang diinputkan
				$data = array(
						'id_informasi' => $this->input->post('id_informasi',TRUE),
						'id_kategori' => $this->input->post('id_kategori',TRUE),					
						'judul_informasi' => $this->input->post('judul_informasi',TRUE),
						'judul_seo'       => seo_title($this->input->post('judul_informasi',TRUE)),	
						'isi_informasi' => $this->input->post('isi_informasi',TRUE),										
						'aktif' => $this->input->post('aktif',TRUE),
						);

				$this->Informasi_model->update($this->input->post('id_informasi', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('informasi'));
			
			}
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
				
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->Informasi_model->get_by_id($id);
		
		//jika id_informasi yang dipilih tersedia maka akan dihapus
        if ($row) {
			// menghapus data berdasarkan id-nya yaitu id_informasi
            $this->Informasi_model->delete($id);
			
			// menampilkan informasi 'Delete Record Success' setelah data informasi dihapus 
            $this->session->set_flashdata('message', 'Delete Record Success');
			
			// menghapus file photo
			unlink("../images/info_kampus/".$row->gambar);
			
            redirect(site_url('informasi'));
        } 
		// jika data tidak ada yang dihapus maka akan menampilkan 'Can not Delete This Record !'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('informasi'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('id_informasi', 'id informasi', 'trim|required');	
	$this->form_validation->set_rules('judul_informasi', 'judul informasi', 'trim|required');	
	$this->form_validation->set_rules('isi_informasi', 'isi informasi', 'trim|required');	
	$this->form_validation->set_rules('aktif', 'aktif', 'trim|required');

	$this->form_validation->set_rules('id_informasi', 'id_informasi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Informasi.php */
/* Location: ./application/controllers/Informasi.php */
/* Please DO NOT modify this information : */