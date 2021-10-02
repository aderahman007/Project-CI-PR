<?php



if (!defined('BASEPATH'))
	exit('No direct script access allowed');

// Deklarasi pembuatan class Gallery
class Gallery extends CI_Controller
{
	// Konstruktor	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_model'); // Memanggil Gallery_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
		$this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library     
		$this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
	}

	// Fungsi untuk menampilkan halaman gallery
	public function index()
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

		$this->load->view('header_list', $dataAdm); // Menampilkan bagian header dan object data users 
		$this->load->view('gallery/gallery_list'); // Menampilkan halaman utama gallery
		$this->load->view('footer_list'); // Menampilkan bagian footer
	}

	// Fungsi JSON
	public function json()
	{
		header('Content-Type: application/json');
		echo $this->Gallery_model->json();
	}



	public function create()
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

		// Menampung data yang diinputkan	  
		$data = array(
			'button' => 'Create',
			'action' => site_url('gallery/create_action'),
			'back'   => site_url('gallery'),
			'id_gallery' => set_value('id_gallery'),
			'judul_gallery' => set_value('judul_gallery'),
			'gambar' => set_value('gambar'),
			'aktif' => set_value('aktif'),
		);
		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 	
		$this->load->view('gallery/gallery_form', $data); // Menampilkan halaman form gallery
		$this->load->view('footer'); // Menampilkan bagian footer
	}

	public function create_action()
	{

		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->_rules(); // Rules atau aturan bahwa setiap form harus diisi

		// Jika form gallery belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->create();
		}
		// Jika form gallery telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {

			// konfigurasi untuk melakukan upload gambar
			$config['upload_path']   = '../images/gallery/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('judul_gallery')); //nama file gambar dirubah menjadi nama berdasarkan judul_gallery	
			$this->upload->initialize($config);

			// Jika file gambar ada 
			if (!empty($_FILES['gambar']['name'])) {

				if ($this->upload->do_upload('gambar')) {
					$gambar = $this->upload->data();
					$datagambar = $gambar['file_name'];
					$this->load->library('upload', $config);

					$data = array(
						'id_gallery' => $this->input->post('id_gallery', TRUE),
						'judul_gallery' => $this->input->post('judul_gallery', TRUE),
						'gambar' => $datagambar,
						'aktif' => $this->input->post('aktif', TRUE),
					);

					$this->Gallery_model->insert($data);
				}

				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('gallery'));
			}
			// Jika file gambar kosong 
			else {

				$data = array(
					'id_gallery' => $this->input->post('id_gallery', TRUE),
					'judul_gallery' => $this->input->post('judul_gallery', TRUE),
					'aktif' => $this->input->post('aktif', TRUE),
				);

				$this->Gallery_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('gallery'));
			}
		}
	}

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

		// Menampilkan data berdasarkan id-nya yaitu id_gallery
		$row = $this->Gallery_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('gallery/update_action'),
				'back'   => site_url('gallery'),
				'id_gallery' => set_value('id_gallery', $row->id_gallery),
				'judul_gallery' => set_value('judul_gallery', $row->judul_gallery),
				'gambar' => set_value('gambar', $row->gambar),
				'aktif' => set_value('aktif', $row->aktif),
			);
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 	
			$this->load->view('gallery/gallery_form', $data); // Menampilkan form mahasiswa
			$this->load->view('footer'); // Menampilkan bagian footer
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('gallery'));
		}
	}

	public function update_action()
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	 			

		// Jika form gallery belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_gallery', TRUE));
		}
		// Jika form gallery telah diisi dengan benar 
		// maka sistem akan melakukan update data gallery kedalam database
		else {

			// Konfigurasi untuk melakukan upload gambar
			$config['upload_path']   = '../images/gallery/';    //path folder
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('judul_gallery')); //nama file gambar dirubah menjadi nama berdasarkan judul_gallery	
			$this->upload->initialize($config);

			// Jika file gambar ada 
			if (!empty($_FILES['gambar']['name'])) {

				// Menghapus file image lama
				unlink("../images/gallery/" . $this->input->post('gambar'));

				// Upload file image baru
				if ($this->upload->do_upload('gambar')) {
					$gambar = $this->upload->data();
					$datagambar = $gambar['file_name'];
					$this->load->library('upload', $config);

					$data = array(
						'id_gallery' => $this->input->post('id_gallery', TRUE),
						'judul_gallery' => $this->input->post('judul_gallery', TRUE),
						'gambar' => $datagambar,
						'aktif' => $this->input->post('aktif', TRUE),
					);
					$this->Gallery_model->update($this->input->post('id_gallery', TRUE), $data);
				}

				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('gallery'));
			}
			// Jika file gambar kosong 
			else {

				$data = array(
					'id_gallery' => $this->input->post('id_gallery', TRUE),
					'judul_gallery' => $this->input->post('judul_gallery', TRUE),
					'aktif' => $this->input->post('aktif', TRUE),
				);

				$this->Gallery_model->update($this->input->post('id_gallery', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('gallery'));
			}
		}
	}

	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
	public function delete($id)
	{

		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$row = $this->Gallery_model->get_by_id($id);

		//jika id nim yang dipilih tersedia maka akan dihapus
		if ($row) {
			$this->Gallery_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');

			// menghapus file gambar
			unlink("../images/gallery/" . $row->gambar);
			redirect(site_url('gallery'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('gallery'));
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('id_gallery', 'id gallery', 'trim|required');
		$this->form_validation->set_rules('judul_gallery', 'judul gallery', 'trim|required');
		//$this->form_validation->set_rules('gambar', 'gambar', 'trim|required');
		$this->form_validation->set_rules('aktif', 'aktif', 'trim|required');

		$this->form_validation->set_rules('id_gallery', 'id_gallery', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
}
