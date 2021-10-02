<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Tentang Kampus
class Tentang_kampus extends CI_Controller
{
     // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Tentang_kampus_model'); // Memanggil Tentang_kampus_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models 
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library  
		$this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper	
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman Tentang Kampus
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
        $this->load->view('tentang_kampus/tentang_kampus_list'); // Menampilkan halaman Tentang Kampus
		$this->load->view('footer_list'); // Menampilkan bagian footer
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tentang_kampus_model->json();
    }

	
	// Fungsi menampilkan form Create Tentang Kampus
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
            'action' => site_url('tentang_kampus/create_action'),
			'back'   => site_url('tentang_kampus'),
			'id_tentangkampus' => set_value('id_tentangkampus'),
			'judul_tentangkampus' => set_value('judul_tentangkampus'),
			'isi_tentangkampus' => set_value('isi_tentangkampus'),
			'keterangan_tambahan' => set_value('keterangan_tambahan'),
			'gambar' => set_value('gambar'),
			//'aktif' => set_value('aktif'),
	);
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users
        $this->load->view('tentang_kampus/tentang_kampus_form', $data); // Menampilkan halaman utama yaitu form tentang kampus
		$this->load->view('footer'); // Menampilkan bagian footer
	}
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form tentang kampus belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form tentang kampus telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
			
			// konfigurasi untuk melakukan upload gambar
			$config['upload_path']   = '../images/tentang_kampus/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('judul_tentangkampus')); //nama file gambar dirubah menjadi nama berdasarkan judul_tentangkampus	
			$this->upload->initialize($config);
			
			// Jika file gambar ada 
			if(!empty($_FILES['gambar']['name'])){
				if ($this->upload->do_upload('gambar')){
					
					$gambar = $this->upload->data();	
					$datapgambar = $gambar['file_name'];					
					$this->load->library('upload', $config);	
					
					$data = array(
						'id_tentangkampus' => $this->input->post('id_tentangkampus',TRUE),
						'judul_tentangkampus' => $this->input->post('judul_tentangkampus',TRUE),
						'isi_tentangkampus' => $this->input->post('isi_tentangkampus',TRUE),
						'keterangan_tambahan' => $this->input->post('keterangan_tambahan',TRUE),
						'gambar' => $datapgambar,
						//'aktif' => $this->input->post('aktif',TRUE),
						);
					$this->Tentang_kampus_model->insert($data);
				}
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('tentang_kampus'));
			}
			// Jika file gambar kosong 
			else{
				$data = array(
						'id_tentangkampus' => $this->input->post('id_tentangkampus',TRUE),
						'judul_tentangkampus' => $this->input->post('judul_tentangkampus',TRUE),
						'isi_tentangkampus' => $this->input->post('isi_tentangkampus',TRUE),
						'keterangan_tambahan' => $this->input->post('keterangan_tambahan',TRUE),						
						//'aktif' => $this->input->post('aktif',TRUE),
						);
			   
				$this->Tentang_kampus_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('tentang_kampus'));
			}			
            
        }
    }
    
	// Fungsi menampilkan form Update Tentang Kampus
    public function update($id) {
		
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
		
		// Menampilkan data berdasarkan id-nya yaitu id_tentangkampus
        $row = $this->Tentang_kampus_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data tentang kampus ditampilkan ke form edit tentang kampus
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tentang_kampus/update_action'),
				'back'   => site_url('tentang_kampus'),
				'id_tentangkampus' => set_value('id_tentangkampus', $row->id_tentangkampus),
				'judul_tentangkampus' => set_value('judul_tentangkampus', $row->judul_tentangkampus),
				'isi_tentangkampus' => set_value('isi_tentangkampus', $row->isi_tentangkampus),
				'keterangan_tambahan' => set_value('keterangan_tambahan', $row->keterangan_tambahan),
				'gambar' => set_value('gambar', $row->gambar),
				//'aktif' => set_value('aktif', $row->aktif),
			);
			$this->load->view('header',$dataAdm ); // Menampilkan bagian header dan object data users
            $this->load->view('tentang_kampus/tentang_kampus_form', $data);  // Menampilkan form tentang kampus
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tentang_kampus'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form tentang kampus belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tentangkampus', TRUE));
        } 
		// Jika form tentang kampus telah diisi dengan benar 
		// maka sistem akan melakukan update data tentang kampus kedalam database
		else {
			
			// Konfigurasi untuk melakukan upload gambar
			$config['upload_path']   = '../images/tentang_kampus/';    //path folder
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('judul_tentangkampus')); //nama file gambar dirubah menjadi nama berdasarkan judul_tentangkampus	
			$this->upload->initialize($config);
			
			// Jika file gambar ada 
			if(!empty($_FILES['gambar']['name'])){	
			
				// Menghapus file image lama
				unlink("../images/tentang_kampus/".$this->input->post('gambar'));
				
				// Upload file image baru
				if ($this->upload->do_upload('gambar')){
					$gambar = $this->upload->data();	
					$datagambar = $gambar['file_name'];					
					$this->load->library('upload', $config);
					
					$data = array(
						'id_tentangkampus' => $this->input->post('id_tentangkampus',TRUE),
						'judul_tentangkampus' => $this->input->post('judul_tentangkampus',TRUE),
						'isi_tentangkampus' => $this->input->post('isi_tentangkampus',TRUE),
						'keterangan_tambahan' => $this->input->post('keterangan_tambahan',TRUE),
						'gambar' => $datagambar,
						//'aktif' => $this->input->post('aktif',TRUE),
						);

					$this->Tentang_kampus_model->update($this->input->post('id_tentangkampus', TRUE), $data);
				}
				
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('tentang_kampus'));
			
			}
			// Jika file photo kosong 
			else{		
				// Menampung data yang diinputkan			
				$data = array(
						'id_tentangkampus' => $this->input->post('id_tentangkampus',TRUE),
						'judul_tentangkampus' => $this->input->post('judul_tentangkampus',TRUE),
						'isi_tentangkampus' => $this->input->post('isi_tentangkampus',TRUE),
						'keterangan_tambahan' => $this->input->post('keterangan_tambahan',TRUE),						
						//'aktif' => $this->input->post('aktif',TRUE),
						);

				$this->Tentang_kampus_model->update($this->input->post('id_tentangkampus', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('tentang_kampus'));
			}
        }
    }
	
	// Fungsi untuk melakukan aksi update data
    public function aktif_action($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		$rows = $this->Tentang_kampus_model->get_by_id($id);
			
		//jika id tentang kampus yang dipilih tersedia maka akan diaktifkan
		if ($rows) {	
				
			$this->Tentang_kampus_model->update_tidakAktif($id);		
			
			$this->Tentang_kampus_model->update_aktif($id);	
			
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('tentang_kampus'));
		}
		//jika id tentang kampus yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
			
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tentang_kampus'));
        }
        
	}
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->Tentang_kampus_model->get_by_id($id); // Rules atau aturan bahwa setiap form harus diisi
		
		//jika id tentang kampus yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Tentang_kampus_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
			
			// menghapus file gambar
			unlink("../images/tentang_kampus/".$row->gambar);
				
            redirect(site_url('tentang_kampus'));
        } 
		//jika id tentang kampus yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tentang_kampus'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('id_tentangkampus', 'id tentangkampus', 'trim|required');
	$this->form_validation->set_rules('judul_tentangkampus', 'judul tentangkampus', 'trim|required');
	$this->form_validation->set_rules('isi_tentangkampus', 'isi tentangkampus', 'trim|required');
	$this->form_validation->set_rules('keterangan_tambahan', 'keterangan tambahan', 'trim|required');	
	//$this->form_validation->set_rules('aktif', 'aktif', 'trim|required');

	$this->form_validation->set_rules('id_tentangkampus', 'id_tentangkampus', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
