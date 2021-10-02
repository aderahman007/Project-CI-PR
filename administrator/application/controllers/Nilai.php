<?php




if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Nilai

class Nilai extends CI_Controller
{
  
  // Konstruktor	
  function __construct()
    {
        parent::__construct();
        $this->load->model('Transkrip_model'); // Memanggil Transkrip_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
		$this->load->model('Siswa_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->helper('my_function'); // Memanggil fungsi my_function yang terdapat pada helper	
		$this->load->library('Pdf');
    }
  
  // Fungsi untuk menampilkan halaman nilai 
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
	  
	  // Menampung data yang diberi nilai
      $data = array(
        'button' => 'Proses',		
        'action' => site_url('nilai/nilaiKhs_action'),
	    'nim' => set_value('nim'),
	  );
				
        $this->load->view('header',$dataAdm ); // Menampilkan bagian header dan object data users 
        $this->load->view('nilai/nilaiKhs_form', $data); // Menampilkan halaman utama yaitu form nilai 
		$this->load->view('footer'); // Menampilkan bagian footer
    }
	
	// Fungsi untuk melakukan aksi menampilkan data nilai
    public function nilaiKhs_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rulesKhs(); // Rules atau aturan bahwa setiap form harus diisi
	
		// Jika form nilai belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
				$this->index();
		} 
		// Jika form nilai telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
			$nim=$this->input->post('nim',TRUE);
			$kode_angkatan=$this->Siswa_model->get_by_id($nim)->kode_angkatan;

			
			// Query menampilkan KRS berdasarkan nim dan angkatan
			$sql = "SELECT krs.kode_angkatan
						 , krs.kode_pelajaran
						 , pelajaran.nama_pelajaran
						 , pelajaran.kkm
						 , krs.nilai_keaktifan
						 , krs.nilai_penugasan
						 , krs.nilai_ujian
					FROM
					   krs
					INNER JOIN pelajaran 
					ON (krs.kode_pelajaran = pelajaran.kode_pelajaran)
					WHERE krs.nim=$nim AND krs.kode_angkatan='$kode_angkatan'";		     
			  $query = $this->db->query($sql)->result();

			//   var_dump($query);die;
			  
			  $angkatan = $this->db->select('tahun_angkatan, nama_angkatan')
							  ->from('angkatan')
							  ->where(array('kode_angkatan'=>$kode_angkatan))->get()->row();	 
			  
			  // Query menampilkan siswa dan program studi berdasarkan id_kelas	  
			  $query_str="SELECT siswa.nim
							 , siswa.nama_lengkap
							 , kelas.nama_kelas
						  FROM
							 siswa
							INNER JOIN kelas 
							ON (siswa.id_kelas = kelas.id_kelas)
							WHERE siswa.nim = $nim;";
			  $mhs=$this->db->query($query_str)->row();
			
			  
			  // Menampilkan data berdasarkan id-nya yaitu username
			  $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
			  $dataAdm = array(	
					'wa'       => 'Web administrator',
					'univ'     => 'Sekolah Polisi Negara Polda Lampung',
					'username' => $rowAdm->username,
					'email'    => $rowAdm->email,
					'level'    => $rowAdm->level,
				);
			  
			  // Menampung data dari tabel siswa dan program studi
			  $data = array('button' => 'Detail',
							'back'   => site_url('nilai'),
							'mhs_data'=>$query,
							'mhs_nim'=>$nim,
							'kode_angkatan'=>$kode_angkatan,
							'mhs_nama'=>$mhs->nama_lengkap,
							'mhs_kelas'=>$mhs->nama_kelas,
							'nama_angkatan'=>$angkatan->nama_angkatan." (". $angkatan->tahun_angkatan.")"
							);

			if ($mhs == null) {
				$this->session->set_flashdata('message', 'Nis tidak ditemukan');
				redirect(site_url('nilai'));
			}
						  
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
			$this->load->view('nilai/khs',$data); // Menampilkan halaman khs
			$this->load->view('footer'); // Menampilkan bagian footer
		}
   }

   	public function cetak_nilai($nim, $kode_angkatan){

		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		

		// Query menampilkan KRS berdasarkan nim dan tahun akademik
		$sql = "SELECT krs.kode_angkatan
						 , krs.kode_pelajaran
						 , pelajaran.nama_pelajaran
						 , pelajaran.kkm
						 , krs.nilai_keaktifan
						 , krs.nilai_penugasan
						 , krs.nilai_ujian
					FROM
					   krs
					INNER JOIN pelajaran 
					ON (krs.kode_pelajaran = pelajaran.kode_pelajaran)
					WHERE krs.nim=$nim AND krs.kode_angkatan='$kode_angkatan'";
		$query = $this->db->query($sql)->result();

		$angkatan = $this->db->select('tahun_angkatan, nama_angkatan')
			->from('angkatan')
			->where(array('kode_angkatan' => $kode_angkatan))->get()->row();

		// Query menampilkan siswa dan program studi berdasarkan id_kelas	  
		$query_str = "SELECT siswa.nim
							 , siswa.nama_lengkap
							 , kelas.nama_kelas
						  FROM
							 siswa
							INNER JOIN kelas 
							ON (siswa.id_kelas = kelas.id_kelas)
							WHERE siswa.nim = $nim;";
		$mhs = $this->db->query($query_str)->row();

		
		
		// FPDF
		$pdf = new FPDF('p', 'mm', 'A4');
		$pdf->AliasNbPages();
		// membuat halaman baru
		$pdf->AddPage();
		$pdf->SetMargins(10, 0, 10);

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
		$pdf->Cell(190, 7, 'Mahir, Terpuji, Patuh Hukum, Unggul', 0, 1,
			'C'
		);
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
		$pdf->Cell(180, 8, 'Nilai Akademik Siswa', 0, 1, 'C');
		$pdf->SetFont('Arial', 'I', 12);
		$pdf->Cell(180, 5, 'Angkatan ' . $angkatan->nama_angkatan . " (" . $angkatan->tahun_angkatan . ")", 0, 1, 'C');

		// Indentitas
		$pdf->Cell(15, 7, '', 0, 1);
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(100, 5, 'Nis         : ' . $nim, 0, 0, 'L');
		$pdf->Cell(20, 5, 'Kelas                   : ' . $mhs->nama_kelas, 0, 1, 'L');
		$pdf->Cell(100, 5, 'Nama     : ' . $mhs->nama_lengkap, 0, 0, 'L');
		$pdf->Cell(20, 5, 'Angkatan              : ' . $angkatan->nama_angkatan . " (" . $angkatan->tahun_angkatan . ")", 0, 1, 'L');

		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(15, 7, '', 0, 1);
		// header table
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->SetFillColor(200);
		$pdf->Cell(10, 10, 'NO', 1, 0, 'L', true);
		$pdf->Cell(25, 10, 'KODE', 1, 0, 'L', true);
		$pdf->Cell(50, 10, 'PELAJARAN', 1, 0, 'L', true);
		$pdf->Cell(10, 10, 'KKM', 1, 0, 'L', true);
		$pdf->Cell(15, 10, 'KEAKTIFAN', 1, 0, 'L', true);
		$pdf->Cell(15, 10, 'PENUGASAN', 1, 0, 'L', true);
		$pdf->Cell(15, 10, 'UJIAN', 1, 0, 'L', true);
		$pdf->Cell(25, 10, 'NILAI AKHIR', 1, 0, 'L', true);
		$pdf->Cell(25, 10, 'KELULUSAN', 1, 1, 'L', true);
		$pdf->SetFont('Arial', '', 8);




		$banyakNilai = 0;
		$jmlNilai = 0;
		$nilai = $query;
		$no = 1;
		foreach ($nilai as $row) {
			$pdf->Cell(10, 6, $no++, 1, 0);
			$pdf->Cell(25, 6, $row->kode_pelajaran, 1, 0);
			$pdf->Cell(50, 6, $row->nama_pelajaran, 1, 0);
			$pdf->Cell(10, 6, $row->kkm, 1, 0);
			$pdf->Cell(15, 6, $row->nilai_keaktifan, 1, 0);
			$pdf->Cell(15, 6, $row->nilai_penugasan, 1, 0);
			$pdf->Cell(15, 6, $row->nilai_ujian, 1, 0);

			$nilai_keaktifan = $row->nilai_keaktifan;
			$nilai_penugasan = $row->nilai_penugasan;
			$nilai_ujian = $row->nilai_ujian;

			$nilai_akhir = ($nilai_keaktifan * 0.2) + ($nilai_penugasan * 0.2) + ($nilai_ujian * 0.6);

			$banyakNilai += 1;
			$jmlNilai += $nilai_akhir;
			$rata_rata = $jmlNilai / $banyakNilai;


			if ($nilai_akhir >= $row->kkm) {
				$kelulusan = "Lulus";
			} else {
				$kelulusan = "Tidak Lulus";
			}

			$pdf->Cell(25, 6, $nilai_akhir, 1, 0);
			$pdf->Cell(25, 6, $kelulusan, 1, 1);
			
		}
		$pdf->SetFillColor(255);
		$pdf->Cell(15, 3, '', 0, 1);
		$pdf->Cell(146, 6, 'Total Nilai Akhir : ' . $jmlNilai, 0, 1, 'R', true);
		$pdf->Cell(146, 6, 'Rata-Rata Nilai Akhir : ' . number_format($rata_rata, 1), 0, 1, 'R', true);
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
   
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan update) KHS
    public function _rulesKhs(){
	 $this->form_validation->set_rules('nim', 'nim', 'trim|required|min_length[8]|max_length[10]');
	}
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update) Transkrip
	public function _rulesTranskrip(){
	 	
	 $this->form_validation->set_rules('nim', 'nim', 'trim|required|min_length[10]|max_length[10]');
	}
	
	// Fungsi untuk membuat Transkrip
// 	public function buatTranskrip(){
// 	  // Jika session data username tidak ada maka akan dialihkan kehalaman login			
// 	  if (!isset($this->session->userdata['username'])) {
// 		  redirect(base_url("login"));
// 	  }	
	 
// 	  // Menampilkan data berdasarkan id-nya yaitu username
// 	  $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
// 	  $dataAdm = array(	
// 			'wa'       => 'Web administrator',
// 			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
// 			'username' => $rowAdm->username,
// 			'email'    => $rowAdm->email,
// 			'level'    => $rowAdm->level,
// 		);
	  
//       // Menampung data berdasarkan nim yang diinputkan  
//       $data = array(
//         'button' => 'Proses',
//         'action' => site_url('nilai/buatTranskrip_action'),
// 	    'nim' => set_value('nim')		
// 	    );
				
//         $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
//         $this->load->view('nilai/buatTranskrip_form', $data); // Menampilkan halaman form buat transkrip
// 		$this->load->view('footer'); // Menampilkan bagian footer
//     }
	
// 	// Fungsi untuk melakukan aksi buat transkrip
// 	public function buatTranskrip_action(){
// 		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
// 		if (!isset($this->session->userdata['username'])) {
// 			redirect(base_url("login"));
// 		}
	
// 		$this->_rulesTranskrip(); // Rules atau aturan bahwa setiap form harus diisi
		
// 		// Jika form buat transkrip belum diisi dengan benar 
// 		// maka sistem akan meminta user untuk menginput ulang
// 		if ($this->form_validation->run() == FALSE) {
// 				$this->buatTranskrip();
// 		} 
// 		// Jika form buat transkrip telah diisi dengan benar 
// 		// maka sistem akan menyimpan kedalam database
// 		else {
// 			$nim=$this->input->post('nim',TRUE);
			
// 			// Query menampilkan semua data pada tabel krs
// 			$this->db->select('*');
// 			$this->db->from('krs');
// 			$this->db->where('nim', $nim);
// 			$query=$this->db->get();
// 			foreach ($query->result() as $value)
// 			{				
//                 // Melakukan pengecekan pada tabel krs, 
// 				// jika terdapat belum ada nilai maka tambahkan nilai tersebut/	
//                 // Jika sudah ada nilai pada tabel krs maka yang diinput adalah nilai yang terbesar				
// 				cekNilai($value->nim,$value->kode_pelajaran,$value->nilai);
				  
// 			}
			
// 			// Query menampilkan data traskrip nilai berdasarkan pelajaran 
// 			$this->db->select('t.kode_pelajaran,m.nama_pelajaran,m.kkm,t.nilai_tugas,t.nilai_uts,t.nilai_uas');
// 			$this->db->from('transkrip as t');
// 			$this->db->join('pelajaran as m','m.kode_pelajaran = t.kode_pelajaran');
// 			$trans = $this->db->get()->result();
			
// 			// Query menampilkan data siswa
// 			$mhs=$this->db->select('nama_lengkap,id_kelas')
// 							->from('siswa')
// 							->where(array('nim'=>$nim))
// 							->get()->row();
			
// 			// Query menampilkan data kelas
// 			$kelas=$this->db->select('nama_kelas')
// 							->from('kelas')
// 							->where(array('id_kelas'=>$mhs->id_kelas))
// 							->get()->row()->nama_kelas;		
			
// 			// Menampung data berdasarkan nim, nama dan kelas 
// 			$data=array('trans'=>$trans,
// 						'nim'=>$nim,
// 						'nama'=>$mhs->nama_lengkap,
// 						'kelas'=>$kelas);
			
// 			// Menampilkan data berdasarkan id-nya yaitu username
// 			$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
// 			$dataAdm = array(	
// 					'wa'       => 'Web administrator',
// 					'univ'     => 'Sekolah Polisi Negara Polda Lampung',
// 					'username' => $rowAdm->username,
// 					'email'    => $rowAdm->email,
// 					'level'    => $rowAdm->level,
// 				);  
					
// 			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
// 			$this->load->view('nilai/buatTranskrip',$data); // Menampilkan form membuat transkrip
// 			$this->load->view('footer'); // Menampilkan bagian footer
// 		}
//    }
   
   // Fungsi menampilkan form Input Nilai
    public function inputNilai(){
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
		'back'   => site_url('nilai/inputNilai'),
        'action' => site_url('nilai/inputNilai_action'),
	    'kode_pelajaran' => set_value('kode_pelajaran'),
		'kode_angkatan' => set_value('kode_angkatan'),
	    );		
		
        $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users	 
        $this->load->view('nilai/inputNilai_form', $data); // Menampilkan halaman form input nilai
		$this->load->view('footer'); // Menampilkan bagian footer
    }
	
	// Fungsi untuk melakukan aksi menampilkan nilai 
	public function inputNilai_action(){  
	 // Jika session data username tidak ada maka akan dialihkan kehalaman login			
	 if (!isset($this->session->userdata['username'])) {
		redirect(base_url("login"));
	 }
	
	 $this->_rulesInputNilai(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form nilai belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
				$this->inputNilai();
		} 
		// Jika form nilai telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
		  $kode_pl =$this->input->post('kode_pelajaran',TRUE);
		  $kode_angkatan=$this->input->post('kode_angkatan',TRUE);
	
		  $this->db->select('k.id_krs, k.nim, m.nama_lengkap, k.nilai_keaktifan, k.nilai_penugasan, k.nilai_ujian, d.nama_pelajaran' );
		  $this->db->from('krs as k');
		  $this->db->join('siswa as m','m.nim = k.nim');
		  $this->db->join('pelajaran as d','k.kode_pelajaran = d.kode_pelajaran');		   
		  $this->db->where('k.kode_angkatan', $kode_angkatan);
		  $this->db->where('k.kode_pelajaran', $kode_pl);
		  $qry = $this->db->get()->result();
		  
		  // Menampung data yang diinputkan berdasarkan kode pelajaran dan id tahun akademik
		  $data=array('button' => 'Input',
					  'back'   => site_url('nilai/inputNilai'),
		              'list_nilai'=>$qry,
					  'action' => site_url('nilai/simpan_action'),
					  'kode_pelajaran'=>$kode_pl,
					  'kode_angkatan'=>$kode_angkatan);
		  
		  // Menampilkan data berdasarkan id-nya yaitu username
		  $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		  $dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
			);
		
		  $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users
		  $this->load->view('nilai/listNilai',$data); // Menampilkan halaman list nilai
		  $this->load->view('footer'); // Menampilkan bagian footer
		 }
	 
	}
	
	// Fungsi untuk melakukan aksi simpan data
	public function simpan_action(){
     // Jika session data username tidak ada maka akan dialihkan kehalaman login			
	 if (!isset($this->session->userdata['username'])) {
		redirect(base_url("login"));
	 }	
	 
	 $nilaiLis=array();	 
	 $id_krs = $_POST['id_krs']; // input data berdasarkan id_krs	  
	 $nilai_keaktifan  = $_POST['nilai_keaktifan'];  // input data berdasarkan nilai
	 $nilai_penugasan  = $_POST['nilai_penugasan'];  // input data berdasarkan nilai
	 $nilai_ujian  = $_POST['nilai_ujian']; // input data berdasarkan nilai

	 
     for ($i=0; $i<sizeof($id_krs); $i++)
     {
		$dataNilai = array(
			'nilai_keaktifan' => $nilai_keaktifan[$i],
			'nilai_penugasan' => $nilai_penugasan[$i],
			'nilai_ujian' => $nilai_ujian[$i]
		);
 	   
	   $this->db->set($dataNilai)->where('id_krs',$id_krs[$i])->update('krs');	 
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
	 $data=array(
				 'id_krs'=>$id_krs,
				 'button' => 'Input',
			     'back'   => site_url('nilai/inputNilai'),
				 );
	 
	 $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
	 $this->load->view('nilai/nilai',$data); // Menampilkan halaman form nilai
	 $this->load->view('footer'); // Menampilkan bagian footer
	}
	
	public function _rulesInputNilai()
    {
	 $this->form_validation->set_rules('kode_pelajaran', 'kode_pelajaran', 'trim|required');
	 $this->form_validation->set_rules('kode_angkatan','kode_angkatan', 'trim|required');
	}
}


?>
