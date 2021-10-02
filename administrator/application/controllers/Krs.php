<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

// Deklarasi pembuatan class Krs
class Krs extends CI_Controller
{
	// Konstruktor	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Krs_model'); // Memanggil Krs_model yang terdapat pada models
		$this->load->model('Siswa_model'); // Memanggil Mahasiswa_model yang terdapat pada models
		$this->load->model('Kelas_model'); // Memanggil Prodi_model yang terdapat pada models
		$this->load->model('Angkatan_model'); // Memanggil Angkatan_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
		$this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library   
		$this->load->library('Pdf');
	}

	// Fungsi untuk menampilkan halaman utama KRS
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

		// Menampung data yang diinputkan
		$data = array(
			'button' => 'Proses',
			'back'   => site_url('krs'),
			'action' => site_url('krs/krs_action'),
			'nim' => set_value('nim'),
			// 'kode_angkatan' => set_value('kode_angkatan'),
		);

		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 	
		$this->load->view('krs/siswa_form', $data); // Menampilkan halaman utama KRS
		$this->load->view('footer'); // Menampilkan bagian footer
	}

	// Fungsi untuk melakukan aksi KRS
	public function krs_action()
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->_rulesKrs(); // Rules atau aturan bahwa setiap form harus diisi

		// Jika form KRS belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		}
		// Jika form KRS telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {

			$nim = $this->input->post('nim', TRUE);
			$kode_angkatan = $this->Siswa_model->get_by_id($nim)->kode_angkatan;

			if ($this->Siswa_model->get_by_id($nim) == null) {
				exit('Nomor mahasiswa ini belum terdaftar');
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
				'action' => site_url('krs/daftar_krs_action'),
				'nim' => $nim,
				'kode_angkatan' => $kode_angkatan,
				'nama_lengkap' => $this->Siswa_model->get_by_id($nim)->nama_lengkap
			);

			// Menampilkan data mahasiswa yang pernah melakukan KRS
			$dataKrs = array(
				'button' => 'Create',
				'back'   => site_url('krs'),
				'krs_data' => $this->baca_krs($nim, $kode_angkatan),
				'nim' => $nim,
				'kode_angkatan' => $kode_angkatan,
				'tahun_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan,
				'nama_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan,
				'nama_lengkap' => $this->Siswa_model->get_by_id($nim)->nama_lengkap,
				'kelas' => $this->Kelas_model->get_by_id(
					$this->Siswa_model->get_by_id($nim)->id_kelas
				)->nama_kelas,
			);

			$this->load->view('header', $dataAdm);	 // Menampilkan bagian header dan object data users 
			$this->load->view('krs/krs_list', $dataKrs); // Menampilkan data KRS
			$this->load->view('footer'); // Menampilkan bagian footer

		}
	}

	// Fungsi membaca KRS berdasarkan NIM dan Angkatan
	public function baca_krs($nim, $kode_angkatan)
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->db->select('k.id_krs,k.kode_pelajaran,m.nama_pelajaran,m.kkm');
		$this->db->from('krs as k');
		$this->db->where('k.nim', $nim);
		$this->db->where('k.kode_angkatan', $kode_angkatan);
		$this->db->join('pelajaran as m', 'm.kode_pelajaran = k.kode_pelajaran');
		$krs = $this->db->get()->result();
		return $krs;
	}

	function Cetak_krs($nim, $kode_angkatan)
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$kode_angkatan = $this->Angkatan_model->get_by_id($kode_angkatan)->kode_angkatan;
		$tahun_angkatan = $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan;
		$nama_angkatan = $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan;
		$nama_lengkap = $this->Siswa_model->get_by_id($nim)->nama_lengkap;
		$kelas = $this->Kelas_model->get_by_id($this->Siswa_model->get_by_id($nim)->id_kelas)->nama_kelas;

		$this->db->select('k.id_krs,k.kode_pelajaran,m.nama_pelajaran,m.kkm');
		$this->db->from('krs as k');
		$this->db->where('k.nim', $nim);
		$this->db->where('k.kode_angkatan', $kode_angkatan);
		$this->db->join(
			'pelajaran as m',
			'm.kode_pelajaran = k.kode_pelajaran'
		);
		$krs = $this->db->get()->result();

		$pdf = new FPDF('p', 'mm', 'A4');

		$pdf->AliasNbPages();
		// membuat halaman baru
		$pdf->AddPage();
		$pdf->SetMargins(25, 0, 10);

		// Page Header
		// Logo
		$pdf->Image('../images/SPN-POLDA-LAMPUNG.png', 17, 10, 22);
		// Arial bold 15
		$pdf->SetFont('Arial', 'B', 15);
		// Move to the right
		$pdf->Cell(80);
		// Title
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell(65, 8, 'Sekolah Polisi Negara Polda Lampung', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 14);
		$pdf->Cell(190, 7, 'Mahir, Terpuji, Patuh Hukum, Unggul', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(190, 5, 'Jl. Agrowisata III, Beringin Raya, Kec. Kemiling, Kota Bandar Lampung, Lampung', 0, 1, 'C');
		$pdf->SetLineWidth(0.5);
		$pdf->Line(15, 33, 195, 33);
		$pdf->SetLineWidth(0);
		$pdf->Line(15, 34, 195, 34);
		// Line break
		$pdf->Ln(10);

		//Judul
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell(165, 8, 'Kartu Rencana Studi Siswa', 0, 1, 'C');
		$pdf->SetFont('Arial', 'I', 12);
		$pdf->Cell(165, 5, 'Angkatan ' . $nama_angkatan . ' ' . ($tahun_angkatan), 0, 1, 'C');

		// Indentitas
		$pdf->Cell(15, 7, '', 0, 1);
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(90, 5, 'Nis         : ' . $nim, 0, 0, 'L');
		$pdf->Cell(15, 5, 'Kelas                   : ' . $kelas, 0, 1, 'L');
		$pdf->Cell(90, 5, 'Nama     : ' . $nama_lengkap, 0, 0, 'L');
		$pdf->Cell(15, 5, 'Angkatan : ' . $nama_angkatan . ' ' . ($tahun_angkatan), 0, 1, 'L');

		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(15, 7, '', 0, 1);
		// header table
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->SetFillColor(200);
		$pdf->Cell(10, 10, 'NO', 1, 0, 'L', true);
		$pdf->Cell(27, 10, 'KODE', 1, 0, 'L', true);
		$pdf->Cell(100, 10, 'PELAJARAN', 1, 0, 'L', true);
		$pdf->Cell(25, 10, 'KKM', 1, 1, 'L', true);
		$pdf->SetFont('Arial', '', 10);





		$nilai = $krs;
		$no = 1;
		foreach ($nilai as $row) {
			$pdf->Cell(10, 6, $no++, 1, 0);
			$pdf->Cell(27, 6, $row->kode_pelajaran, 1, 0);
			$pdf->Cell(100, 6, $row->nama_pelajaran, 1, 0);
			$pdf->Cell(25, 6, $row->kkm, 1, 1);
		}
		// Page footer

		// Position at 1.5 cm from bottom
		$pdf->SetY(-15);
		//garus horizontal
		$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
		// Arial italic 8
		$pdf->SetFont('Arial', 'I', 8);
		// Page number
		$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . ' / {nb}', 0, 0, 'C');

		$pdf->Output();
	}

	// Fungsi rules atau aturan untuk pengisian pada form KRS
	public function _rulesKrs()
	{
		$this->form_validation->set_rules('nim', 'nim', 'trim|required|min_length[8]|max_length[10]');
	}

	// Fungsi menampilkan form Create KRS
	public function create($nim, $kode_angkatan)
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
			'judul' => 'Tambah',
			'back'   => site_url('krs'),
			'action' => site_url('krs/create_action'),
			'id_krs' => set_value('id_krs'),
			'kode_angkatan' => $kode_angkatan, // set_value('id_thn_akad'),
			'tahun_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan,
			'nama_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan,
			'nim' => $nim, //set_value('nim'),
			'kode_pelajaran' => set_value('kode_pelajaran'),

		);
		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
		$this->load->view('krs/krs_form', $data); // Menampilkan form KRS
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

		// Jika form KRS belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->create(
				$this->input->post('nim', TRUE),
				$this->input->post('kode_angkatan', TRUE)
			);
		}
		// Jika form KRS telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
			$nim = $this->input->post('nim', TRUE);
			$kode_angkatan = $this->input->post('kode_angkatan', TRUE);
			$kode_pelajaran = $this->input->post('kode_pelajaran', TRUE);

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
				'kode_angkatan' => $kode_angkatan,
				'nim' => $nim,
				'kode_pelajaran' => $kode_pelajaran,
			);
			// Melakukan penyimpanan data 
			$this->Krs_model->insert($data);

			// Menampilkan data KRS 
			$dataKrs = array(
				'button' => 'Create',
				'judul' => 'Tambah',
				'back'   => site_url('krs'),
				'krs_data' => $this->baca_krs($nim, $kode_angkatan),
				'nim' => $nim,
				'kode_angkatan' => $kode_angkatan,
				'tahun_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan,
				'nama_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan,
				'nama_lengkap' => $this->Siswa_model->get_by_id($nim)->nama_lengkap,
				'kelas' => $this->Kelas_model->get_by_id(
					$this->Siswa_model->get_by_id($nim)->id_kelas
				)->nama_kelas,
			);
			$this->session->set_flashdata('message', 'Create Record Success');


			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
			$this->load->view('krs/krs_list', $dataKrs); // Menampilkan data KRS
			$this->load->view('footer'); // Menampilkan bagian footer
		}
	}



	// Fungsi menampilkan form Update KRS
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

		// Menampilkan data berdasarkan id-nya yaitu krs
		$row = $this->Krs_model->get_by_id($id);
		$kode_angkatan = $row->kode_angkatan;

		// Jika id-nya dipilih maka data krs ditampilkan ke form edit krs	
		if ($row) {
			$data = array(
				'judul' => 'Ubah',
				'back'   => site_url('krs'),
				'button' => 'Update',
				'action' => site_url('krs/update_action'),
				'id_krs' => set_value('id_krs', $row->id_krs),
				'kode_angkatan' => set_value('kode_angkatan', $row->kode_angkatan),
				'nim' => set_value('nim', $row->nim),
				'kode_pelajaran' => set_value('kode_pelajaran', $row->kode_pelajaran),
				'tahun_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan,
				'nama_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan,
			);

			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
			$this->load->view('krs/krs_form', $data); // Menampilkan form krs 
			$this->load->view('footer'); // Menampilkan bagian footer

		}
		// Jika id-nya yang dipilih tidak ada maka akan muncul pesan 'Record Not Found'
		else {

			$this->session->set_flashdata('message', 'Record Not Found');
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

		// Jika form KRS belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_krs', TRUE));
		}
		// Jika form KRS telah diisi dengan benar 
		// maka sistem akan melakukan update data KRS kedalam database
		else {
			// Menampilkan data berdasarkan id-nya yaitu username
			$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
			$dataAdm = array(
				'wa'       => 'Web administrator',
				'univ'     => 'Sekolah Polisi Negara Polda Lampung',
				'username' => $rowAdm->username,
				'email'    => $rowAdm->email,
				'level'    => $rowAdm->level,
			);


			$id_krs = $this->input->post('id_krs', TRUE);
			$nim = $this->input->post('nim', TRUE);
			$kode_angkatan = $this->input->post('kode_angkatan', TRUE);
			$kode_mk = $this->input->post('kode_pelajaran', TRUE);

			// Menampung data yang diinputkan
			$data = array(
				'id_krs' => $id_krs,
				'kode_angkatan' => $kode_angkatan,
				'nim' => $nim,
				'kode_pelajaran' => $this->input->post('kode_pelajaran', TRUE),

			);

			// Melakukan update data KRS
			$this->Krs_model->update($id_krs, $data);
			$this->session->set_flashdata('message', 'Update Record Success');

			// Menampilkan data KRS 	
			$dataKrs = array(
				'krs_data' => $this->baca_krs($nim, $kode_angkatan),
				'nim' => $nim,
				'kode_angkatan' => $kode_angkatan,
				'tahun_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan,
				'nama_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan,
				'nama_lengkap' => $this->Siswa_model->get_by_id($nim)->nama_lengkap,
				'kelas' => $this->Kelas_model->get_by_id(
					$this->Siswa_model->get_by_id($nim)->id_kelas
				)->nama_kelas,
			);

			$this->load->view('header', $dataAdm); // Menampilkan bagian header
			$this->load->view('krs/krs_list', $dataKrs); // Menampilkan data KRS
			$this->load->view('footer'); // Menampilkan bagian footer
		}
	}

	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
	public function delete($id)
	{
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$row = $this->Krs_model->get_by_id($id);
		$nim = $this->Krs_model->get_by_id($id)->nim;
		$kode_angkatan = $this->Krs_model->get_by_id($id)->kode_angkatan;

		//jika id krs (nim dan kode_angkatan) yang dipilih tersedia maka akan dihapus
		if ($row) {
			$this->Krs_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			//redirect(site_url('krs'));
		}
		//jika id  krs (nim dan kode_angkatan) yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
			$this->session->set_flashdata('message', 'Record Not Found');
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

		// Menampilkan data KRS
		$dataKrs = array(
			'button' => 'Tambah',
			'back' => site_url('krs'),
			'krs_data' => $this->baca_krs($nim, $kode_angkatan),
			'nim' => $nim,
			'kode_angkatan' => $kode_angkatan,
			'tahun_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan,
			'nama_angkatan' => $this->Angkatan_model->get_by_id($kode_angkatan)->nama_angkatan,
			'nama_lengkap' => $this->Siswa_model->get_by_id($nim)->nama_lengkap,
			'kelas' => $this->Kelas_model->get_by_id(
				$this->Siswa_model->get_by_id($nim)->id_kelas
			)->nama_kelas,
		);

		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
		$this->load->view('krs/krs_list', $dataKrs); // Menampilkan data KRS
		$this->load->view('footer'); // Menampilkan bagian footer
	}

	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
	public function _rules()
	{
		$this->form_validation->set_rules('nim', 'nim', 'trim|required');
		$this->form_validation->set_rules('kode_pelajaran', 'kode pelajaran', 'trim|required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
}
