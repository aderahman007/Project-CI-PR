<?php


if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Guru extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Guru_model'); // Memanggil Guru_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
		$this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
	}

	// Fungsi untuk menampilkan halaman utama Guru
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
		$this->load->view('guru/guru_list');
		$this->load->view('footer_list'); // Menampilkan bagian footer
	}

	// Fungsi JSON
	public function json()
	{
		header('Content-Type: application/json');
		echo $this->Guru_model->json();
	}

	// Fungsi untuk menampilkan halaman Guru secara detail
	public function read($id)
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

		// Menampilkan data guru yang ada di database berdasarkan id-nya yaitu id_guru
		$row = $this->Guru_model->get_by_id($id);
		if ($row) {
			$data = array(
				'button' => 'Read',
				'back'   => site_url('guru'),
				'id_guru' => $row->id_guru,
				'nidn' => $row->nidn,
				'nama_guru' => $row->nama_guru,
				'alamat' => $row->alamat,
				'jenis_kelamin' => $row->jenis_kelamin,
				'email' => $row->email,
				'telp' => $row->telp,
				'photo' => $row->photo,
			);

			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
			$this->load->view('guru/guru_read', $data); // Menampilkan halaman detail guru
			$this->load->view('footer'); // Menampilkan bagian footer
		} else {
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
			$this->session->set_flashdata('message', 'Record Not Found');
			$this->load->view('footer'); // Menampilkan bagian footer
			redirect(site_url('guru'));
		}
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

		$data = array(
			'button' => 'Create',
			'action' => site_url('guru/create_action'),
			'back'   => site_url('guru'),
			'id_guru' => set_value('id_guru'),
			'nidn' => set_value('nidn'),
			'nama_guru' => set_value('nama_guru'),
			'alamat' => set_value('alamat'),
			'jenis_kelamin' => set_value('jenis_kelamin'),
			'email' => set_value('email'),
			'telp' => set_value('telp'),
			'photo' => set_value('photo'),
		);

		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
		$this->load->view('guru/guru_form', $data); // Menampilkan halaman form guru
		$this->load->view('footer'); // Menampilkan bagian footer
	}

	public function create_action()
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

		$this->_rules();

		// Menampung data yang diinputkan
		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {

			// konfigurasi untuk melakukan upload photo
			$config['upload_path']   = '../images/guru/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('nidn')); //nama file photo dirubah menjadi nama berdasarkan nidn	
			$this->upload->initialize($config);

			// Jika file photo ada 
			if (!empty($_FILES['photo']['name'])) {

				if ($this->upload->do_upload('photo')) {
					$photo = $this->upload->data();
					$dataphoto = $photo['file_name'];
					$this->load->library('upload', $config);

					$data = array(
						'nidn' => $this->input->post('nidn', TRUE),
						'nama_guru' => $this->input->post('nama_guru', TRUE),
						'alamat' => $this->input->post('alamat', TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
						'email' => $this->input->post('email', TRUE),
						'telp' => $this->input->post('telp', TRUE),
						'photo' => $dataphoto,
					);

					$this->Guru_model->insert($data);
				}

				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('guru'));
			}
			// Jika file photo kosong 
			else {

				$data = array(
					'nidn' => $this->input->post('nidn', TRUE),
					'nama_guru' => $this->input->post('nama_guru', TRUE),
					'alamat' => $this->input->post('alamat', TRUE),
					'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
					'email' => $this->input->post('email', TRUE),
					'telp' => $this->input->post('telp', TRUE),
				);

				$this->Guru_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('guru'));
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

		// Menampilkan data berdasarkan id-nya yaitu id_guru
		$row = $this->Guru_model->get_by_id($id);

		// Jika id-nya dipilih maka data guru ditampilkan ke form edit guru
		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('guru/update_action'),
				'back'   => site_url('guru'),
				'id_guru' => set_value('id_guru', $row->id_guru),
				'nidn' => set_value('nidn', $row->nidn),
				'nama_guru' => set_value('nama_guru', $row->nama_guru),
				'alamat' => set_value('alamat', $row->alamat),
				'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
				'email' => set_value('email', $row->email),
				'telp' => set_value('telp', $row->telp),
				'photo' => set_value('photo', $row->photo),
			);

			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
			$this->load->view('guru/guru_form', $data); // Menampilkan form guru
			$this->load->view('footer'); // Menampilkan bagian footer
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('guru'));
		}
	}

	public function update_action()
	{

		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	 	

		// Jika form guru belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_guru', TRUE));
		}
		// Jika form guru telah diisi dengan benar 
		// maka sistem akan melakukan update data guru kedalam database
		else {

			// Konfigurasi untuk melakukan upload photo
			$config['upload_path']   = '../images/guru/';    //path folder
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('nidn')); //nama file photo dirubah menjadi nama berdasarkan nidn	
			$this->upload->initialize($config);

			// Jika file photo ada 
			if (!empty($_FILES['photo']['name'])) {

				// Menghapus file image lama
				unlink("../images/guru/" . $this->input->post('photo'));


				// Upload file image baru
				if ($this->upload->do_upload('photo')) {
					$photo = $this->upload->data();
					$dataphoto = $photo['file_name'];
					$this->load->library('upload', $config);

					$data = array(
						'id_guru' => $this->input->post('id_guru', TRUE),
						'nidn' => $this->input->post('nidn', TRUE),
						'nama_guru' => $this->input->post('nama_guru', TRUE),
						'alamat' => $this->input->post('alamat', TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
						'email' => $this->input->post('email', TRUE),
						'telp' => $this->input->post('telp', TRUE),
						'photo' => $dataphoto,
					);

					$this->Guru_model->update($this->input->post('id_guru', TRUE), $data);
				}

				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('guru'));
			}
			// Jika file photo kosong 
			else {
				$data = array(
					'id_guru' => $this->input->post('id_guru', TRUE),
					'nidn' => $this->input->post('nidn', TRUE),
					'nama_guru' => $this->input->post('nama_guru', TRUE),
					'alamat' => $this->input->post('alamat', TRUE),
					'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
					'email' => $this->input->post('email', TRUE),
					'telp' => $this->input->post('telp', TRUE),
				);

				$this->Guru_model->update($this->input->post('id_guru', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('guru'));
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

		$row = $this->Guru_model->get_by_id($id);

		//jika id id_guru yang dipilih tersedia maka akan dihapus
		if ($row) {

			// menghapus file photo
			unlink("../images/guru/" . $row->photo);

			$this->Guru_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('guru'));
		}
		//jika id nim yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('guru'));
		}
	}

	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
	public function _rules()
	{
		$this->form_validation->set_rules('nidn', 'nidn', 'trim|required');
		$this->form_validation->set_rules('nama_guru', 'nama guru', 'trim|required');
		$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('telp', 'telp', 'trim|required');

		$this->form_validation->set_rules('id_guru', 'id_guru', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
}
