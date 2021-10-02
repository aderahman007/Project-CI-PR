<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Laporan

class Laporan extends CI_Controller
{

    // Konstruktor	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transkrip_model'); // Memanggil Transkrip_model yang terdapat pada models
        $this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->model('Siswa_model'); // Memanggil Siswa_model yang terdapat pada models
        $this->load->model('Jadwal_model'); // Memanggil Jadwal_model yang terdapat pada models
        $this->load->model('Angkatan_model'); // Memanggil Jadwal_model yang terdapat pada models
        $this->load->model('Kegiatan_model'); // Memanggil Kegiatan_model yang terdapat pada models
        $this->load->model('Informasi_model'); // Memanggil Informasi_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
        $this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
        $this->load->library('Pdf');
        $this->load->helper('my_function'); // Memanggil fungsi my_function yang terdapat pada helper	
    }

    // Fungsi untuk menampilkan halaman nilai 
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

        // Menampung data yang diberi laporan
        $data = array(
            'button' => 'Proses',
            'action' => site_url('laporan/cek_laporan'),
            'laporan' => set_value('laporan'),
        );

        $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('laporan/laporan_form', $data); // Menampilkan halaman utama yaitu form nilai 
        $this->load->view('footer'); // Menampilkan bagian footer
    }

    public function cek_laporan()
    {
        $jenis_laporan = $_POST['laporan'];

        if ($jenis_laporan == 'laporan_nilai') {
            // Menampilkan data berdasarkan id-nya yaitu username
            $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
            $dataAdm = array(
                'wa'       => 'Web administrator',
                'univ'     => 'Sekolah Polisi Negara Polda Lampung',
                'username' => $rowAdm->username,
                'email'    => $rowAdm->email,
                'level'    => $rowAdm->level,
            );


            $this->laporan_nilai();
        } elseif ($jenis_laporan == 'laporan_jadwal') {
            // Menampilkan data berdasarkan id-nya yaitu username
            $row = $this->Users_model->get_by_id($this->session->userdata['username']);
            $data = array(
                'wa'       => 'Web administrator',
                'univ'     => 'Sekolah Polisi Negara Polda Lampung',
                'username' => $row->username,
                'email'    => $row->email,
                'level'    => $row->level,
            );
            $this->load->view('header_list', $data); // Menampilkan bagian header dan object data users 
            $this->load->view('laporan/laporan_jadwal'); // Menampilkan halaman utama pelajran
            $this->load->view('footer_list');
        } elseif ($jenis_laporan == 'laporan_pengumuman') {
            // Menampilkan data berdasarkan id-nya yaitu username
            $row = $this->Users_model->get_by_id($this->session->userdata['username']);
            $data = array(
                'wa'       => 'Web administrator',
                'univ'     => 'Sekolah Polisi Negara Polda Lampung',
                'username' => $row->username,
                'email'    => $row->email,
                'level'    => $row->level,
            );
            $this->load->view('header_list', $data); // Menampilkan bagian header dan object data users 		
            $this->load->view('laporan/laporan_pengumuman'); // Menampilkan halaman utama informasi
            $this->load->view('footer_list'); // Menampilkan bagian footer	
        } elseif ($jenis_laporan == 'laporan_kegiatan') {
            // Menampilkan data berdasarkan id-nya yaitu username
            $row = $this->Users_model->get_by_id($this->session->userdata['username']);
            $data = array(
                'wa'       => 'Web administrator',
                'univ'     => 'Sekolah Polisi Negara Polda Lampung',
                'username' => $row->username,
                'email'    => $row->email,
                'level'    => $row->level,
            );
            $this->load->view('header_list', $data); // Menampilkan bagian header dan object data users 
            $this->load->view('laporan/laporan_kegiatan'); // Menampilkan halaman utama pelajran
            $this->load->view('footer_list');
        } else {
            $this->session->set_flashdata('message', 'Jenis laporan tidak ditemukan');
            redirect(site_url("laporan"));
        }
    }

    // Fungsi untuk melakukan aksi menampilkan data nilai
    public function laporan_nilai()
    {
        // Jika session data username tidak ada maka akan dialihkan kehalaman login			
        if (!isset($this->session->userdata['username'])) {
            redirect(base_url("login"));
        }


        $kode_angkatan = $this->db->get_where('angkatan', array('aktif' => 'Y'))->row()->kode_angkatan;
        $tahun_angkatan = $this->Angkatan_model->get_by_id($kode_angkatan)->tahun_angkatan;

        // Query menampilkan KRS berdasarkan nim dan tahun akademik
        $sql = "SELECT siswa.nim
                        , siswa.nama_lengkap
                        , kelas.nama_kelas
                        , count(krs.kode_pelajaran) as jml_pel
                        , SUM((krs.nilai_keaktifan*0.2)+(krs.nilai_penugasan*0.2)+(krs.nilai_ujian*0.6)) AS nilai_akhir
                        FROM siswa
                        INNER JOIN kelas 
                        ON (siswa.id_kelas = kelas.id_kelas)
                        INNER JOIN krs 
                        ON (siswa.nim = krs.nim)
                        INNER JOIN pelajaran 
                        ON (krs.kode_pelajaran = pelajaran.kode_pelajaran)
                        WHERE krs.kode_angkatan='$kode_angkatan'
                        GROUP BY krs.nim;";
        $query = $this->db->query($sql)->result();
        // var_dump($query);die;
        

        // var_dump($query);
        // die;
        // Menampilkan data berdasarkan id-nya yaitu username
        $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = array(
            'wa'       => 'Web administrator',
            'univ'     => 'Sekolah Polisi Negara Polda Lampung',
            'username' => $rowAdm->username,
            'email'    => $rowAdm->email,
            'level'    => $rowAdm->level,
        );

        // Menampung data dari tabel siswa 
        $data = array(
            'button' => 'Detail',
            'back'   => site_url('nilai'),
            'siswa_data' => $query,
            'kode_angkatan' => $kode_angkatan,
            'tahun_angkatan' => $tahun_angkatan,
        );

        $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('laporan/laporan_nilai', $data); // Menampilkan halaman khs
        $this->load->view('footer'); // Menampilkan bagian footer

    }

    public function laporan_jadwal()
    {
        header('Content-Type: application/json');
        echo $this->Jadwal_model->json();
    }

    public function laporan_pengumuman()
    {
        header('Content-Type: application/json');
        echo $this->Informasi_model->json();
    }

    public function laporan_kegiatan()
    {
        header('Content-Type: application/json');
        echo $this->Kegiatan_model->json();
    }

    public function cetak_nilai($nim, $kode_angkatan)
    {

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
					WHERE krs.nim=$nim AND krs.kode_angkatan=$kode_angkatan";
        $query = $this->db->query($sql)->result();

        $angkatan = $this->db->select('kode_angkatan, tahun_angkatan, nama_angkatan')
            ->from('angkatan')
            ->where(array('kode_angkatan' => $kode_angkatan))->get()->row();

        // Query menampilkan siswa dan program studi berdasarkan id_kelas	  
        $query_str = "SELECT siswa.nim
							 , siswa.nama_lengkap
							 , kelas.nama_kelas
						  FROM
							 siswa
							INNER JOIN kelas 
							ON (siswa.id_kelas = kelas.id_kelas);";
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
        $pdf->Cell(
            190,
            7,
            'Mahir, Terpuji, Patuh Hukum, Unggul',
            0,
            1,
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
        $pdf->Cell(180, 5, 'Tahun Akademik ' . $angkatan->nama_angkatan . " (" . $angkatan->tahun_angkatan . ")", 0, 1, 'C');

        // Indentitas
        $pdf->Cell(15, 7, '', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(100, 5, 'Nis         : ' . $nim, 0, 0, 'L');
        $pdf->Cell(20, 5, 'Kelas                   : ' . $mhs->nama_kelas, 0, 1, 'L');
        $pdf->Cell(100, 5, 'Nama     : ' . $mhs->nama_lengkap, 0, 0, 'L');
        $pdf->Cell(20, 5, 'Tahun Akademik : ' . $angkatan->nama_angkatan . " (" . $angkatan->tahun_angkatan . ")", 0, 1, 'L');

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(15, 7, '', 0, 1);
        // header table
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200);
        $pdf->Cell(10, 10, 'NO', 1, 0, 'L', true);
        $pdf->Cell(25, 10, 'KODE', 1, 0, 'L', true);
        $pdf->Cell(50, 10, 'PELAJARAN', 1, 0, 'L', true);
        $pdf->Cell(10, 10, 'KKM', 1, 0, 'L', true);
        $pdf->Cell(15, 10, 'keaktifan', 1, 0, 'L', true);
        $pdf->Cell(15, 10, 'penugasan', 1, 0, 'L', true);
        $pdf->Cell(15, 10, 'ujian', 1, 0, 'L', true);
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

            $nilai_akhir = ($nilai_keaktifan * 0.3) + ($nilai_penugasan * 0.3) + ($nilai_ujian * 0.4);

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


    public function _rulesLaporan()
    {
        $this->form_validation->set_rules('laporan', 'laporan', 'trim|required');
    }
}
