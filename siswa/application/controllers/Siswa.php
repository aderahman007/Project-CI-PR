<?php



if (!defined('BASEPATH'))
	exit('No direct script access allowed');

// Deklarasi pembuatan class Siswa
class Siswa extends CI_Controller
{
	// Konstruktor			
	function __construct()
	{
		parent::__construct();
		$this->load->model('Siswa_model'); // Memanggil Siswa_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
		$this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
	}

	// Fungsi untuk menampilkan halaman mahasiswa
	public function index()
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(
			'wa'       => 'Web siswa',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);

		$this->load->view('header_list', $dataAdm); // Menampilkan bagian header dan object data users 
		$this->load->view('siswa/siswa_list'); // Menampilkan halaman utama siswa
		$this->load->view('footer_list'); // Menampilkan bagian footer
	}

	// Fungsi JSON
	public function json()
	{
		header('Content-Type: application/json');
		echo $this->Siswa_model->json();
	}

	// Fungsi untuk menampilkan halaman siswa secara detail
	public function read($id)
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(
			'wa'       => 'Web siswa',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);

		// Menampilkan data Siswa yang ada di database berdasarkan id-nya yaitu nim
		$row = $this->Siswa_model->get_by_id($id);

		// Jika data Siswa tersedia maka akan ditampilkan
		if ($row) {
			$data = array(
				'button' => 'Read',
				'back'   => site_url('mahasiswa'),
				'nim' => $row->nim,
				'nama_lengkap' => $row->nama_lengkap,
				'nama_panggilan' => $row->nama_panggilan,
				'alamat' => $row->alamat,
				'email' => $row->email,
				'telp' => $row->telp,
				'tempat_lahir' => $row->tempat_lahir,
				'tgl_lahir' => $row->tgl_lahir,
				'jenis_kelamin' => $row->jenis_kelamin,
				'agama' => $row->agama,
				'photo' => $row->photo,
				'id_kelas' => $row->id_kelas,
			);
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
			$this->load->view('siswa/siswa_read', $data); // Menampilkan halaman detail siswa
			$this->load->view('footer'); // Menampilkan bagian footer
		}
		// Jika data siswa tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
			$this->session->set_flashdata('message', 'Record Not Found');
			$this->load->view('footer'); // Menampilkan bagian footer
			redirect(site_url('siswa'));
		}
	}

	// Fungsi menampilkan form Update siswa
	public function update($id)
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(
			'wa'       => 'Web siswa',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);

		// Menampilkan data berdasarkan id-nya yaitu nim
		$row = $this->Siswa_model->get_by_id($id);

		// Jika id-nya dipilih maka data siswa ditampilkan ke form edit siswa
		if ($row) {
			$data = array(
				'button' => 'Update',
				'back'   => site_url('siswa'),
				'action' => site_url('siswa/update_action'),
				'nim' => set_value('nim', $row->nim),
				'nama_lengkap' => set_value('nama_lengkap', $row->nama_lengkap),
				'nama_panggilan' => set_value('nama_panggilan', $row->nama_panggilan),
				'alamat' => set_value('alamat', $row->alamat),
				'email' => set_value('email', $row->email),
				'telp' => set_value('telp', $row->telp),
				'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
				'tgl_lahir' => set_value('tgl_lahir', $row->tgl_lahir),
				'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
				'agama' => set_value('agama', $row->agama),
				'photo' => set_value('photo', $row->photo),
				'id_kelas' => set_value('id_kelas', $row->id_kelas),
			);
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
			$this->load->view('siswa/siswa_form', $data); // Menampilkan form siswa
			$this->load->view('footer'); // Menampilkan bagian footer
		}
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('siswa'));
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

		// Jika form siswa belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('nim', TRUE));
		}
		// Jika form siswa telah diisi dengan benar 
		// maka sistem akan melakukan update data siswa kedalam database
		else {
			// Konfigurasi untuk melakukan upload photo
			$config['upload_path']   = './images/';    //path folder
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('nim')); //nama file photo dirubah menjadi nama berdasarkan nim	
			$this->upload->initialize($config);

			// Jika file photo ada 
			if (!empty($_FILES['photo']['name'])) {

				// Menghapus file image lama
				unlink("./images/" . $this->input->post('photo'));

				// Upload file image baru
				if ($this->upload->do_upload('photo')) {
					$photo = $this->upload->data();
					$dataphoto = $photo['file_name'];
					$this->load->library('upload', $config);

					// Menampung data yang diinputkan
					$data = array(
						'nim' => $this->input->post('nim', TRUE),
						'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
						'nama_panggilan' => $this->input->post('nama_panggilan', TRUE),
						'alamat' => $this->input->post('alamat', TRUE),
						'email' => $this->input->post('email', TRUE),
						'telp' => $this->input->post('telp', TRUE),
						'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
						'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
						'agama' => $this->input->post('agama', TRUE),
						'photo' => $dataphoto,
						'id_kelas' => $this->input->post('id_kelas', TRUE),
					);

					
					$this->Siswa_model->update($this->input->post('nim', TRUE), $data);
				}

				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('siswa'));
			}
			// Jika file photo kosong 
			else {
				// Menampung data yang diinputkan
				$data = array(
					'nim' => $this->input->post('nim', TRUE),
					'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
					'nama_panggilan' => $this->input->post('nama_panggilan', TRUE),
					'alamat' => $this->input->post('alamat', TRUE),
					'email' => $this->input->post('email', TRUE),
					'telp' => $this->input->post('telp', TRUE),
					'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
					'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
					'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
					'agama' => $this->input->post('agama', TRUE),
					'id_kelas' => $this->input->post('id_kelas', TRUE),
				);

				$this->Siswa_model->update($this->input->post('nim', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('siswa'));
			}
		}
	}

	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
	public function _rules()
	{
		$this->form_validation->set_rules('nim', 'nim', 'trim|required');
		$this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'trim|required');
		$this->form_validation->set_rules('nama_panggilan', 'nama panggilan', 'trim|required');
		$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('telp', 'telp', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
		$this->form_validation->set_rules('tgl_lahir', 'tgl lahir', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
		$this->form_validation->set_rules('agama', 'agama', 'trim|required');
		$this->form_validation->set_rules('id_kelas', 'id kelas', 'trim|required');
		$this->form_validation->set_rules('nim', 'nim', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
}
