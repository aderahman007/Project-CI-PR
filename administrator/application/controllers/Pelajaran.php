<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Pelajaran
class Pelajaran extends CI_Controller
{
    // Konstruktor	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Pelajaran_model'); // Memanggil Pelajaran_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman matakuliah
    public function index(){	
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu username
		$row = $this->Users_model->get_by_id($this->session->userdata['username']); 
		$data = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Sekolah Polisi Negara Polda Lampung',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);		
		$this->load->view('header_list',$data); // Menampilkan bagian header dan object data users 
        $this->load->view('pelajaran/pelajaran_list'); // Menampilkan halaman utama pelajran
		$this->load->view('footer_list'); // Menampilkan bagian footer
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Pelajaran_model->json();
    }
	
	// Fungsi untuk menampilkan halaman Pelajaran secara detail
    public function read($id){
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
		
		// Query untuk menampilkan pelajaran dan program studinya
		$sql   = "SELECT * FROM kelas, pelajaran 
		          WHERE kelas.id_kelas = pelajaran.id_kelas
				  AND pelajaran.kode_pelajaran = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data pelajaran tersedia maka akan ditampilkan
        if ($row) {
			
            $data = array(
			'button' => 'Read',
			'back'   => site_url('pelajaran'),
			'kode_pelajaran' => $row->kode_pelajaran,
			'nama_pelajaran' => $row->nama_pelajaran,
			'kkm' => $row->kkm,
			'semester' => $row->semester,
			'nama_kelas' => $row->nama_kelas,
			);
			
			$this->load->view('header',$dataAdm);
            $this->load->view('pelajaran/pelajaran_read', $data);
			$this->load->view('footer');
        } 
		// Jika data pelajaran tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelajaran'));
        }
    }
	
	// Fungsi menampilkan form Create Pelajaran
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
			'back'   => site_url('pelajaran'),
            'action' => site_url('pelajaran/create_action'),
			'kode_pelajaran' => set_value('kode_pelajaran'),
			'nama_pelajaran' => set_value('nama_pelajaran'),
			'kkm' => set_value('kkm'),
			'semester' => set_value('semester'),
			'id_kelas' => set_value('id_kelas'),
		);
		$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
        $this->load->view('pelajaran/pelajaran_form', $data); // Menampilkan halaman form matakuliah
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form pelajaran belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form pelajaran telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
			'kode_pelajaran' => $this->input->post('kode_pelajaran',TRUE),
			'nama_pelajaran' => $this->input->post('nama_pelajaran',TRUE),
			'kkm' => $this->input->post('kkm',TRUE),
			'semester' => $this->input->post('semester',TRUE),
			'id_kelas' => $this->input->post('id_kelas',TRUE),
			);
           
            $this->Pelajaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pelajaran'));
        }
    }
    
	// Fungsi menampilkan form Update Pelajaran
    public function update($id){
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
		
		// Menampilkan data berdasarkan id-nya yaitu kode_pelajaran
        $row = $this->Pelajaran_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data pelajaran ditampilkan ke form edit pelajaran
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('pelajaran'),
                'action' => site_url('pelajaran/update_action'),
				'kode_pelajaran' => set_value('kode_pelajaran', $row->kode_pelajaran),
				'nama_pelajaran' => set_value('nama_pelajaran', $row->nama_pelajaran),
				'kkm' => set_value('kkm', $row->kkm),
				'semester' => set_value('semester', $row->semester),
				'id_kelas' => set_value('id_kelas', $row->id_kelas),
				);
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
            $this->load->view('pelajaran/pelajaran_form', $data); // Menampilkan form pelajaran
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelajaran'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	
		
		// Jika form pelajaran belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_pelajaran', TRUE));
        } 
		// Jika form pelajaran telah diisi dengan benar 
		// maka sistem akan melakukan update data pelajaran kedalam database
		else {
            $data = array(
			'kode_pelajaran' => $this->input->post('kode_pelajaran',TRUE),
			'nama_pelajaran' => $this->input->post('nama_pelajaran',TRUE),
			'kkm' => $this->input->post('kkm',TRUE),
			'semester' => $this->input->post('semester',TRUE),
			'id_kelas' => $this->input->post('id_kelas',TRUE),
			);

            $this->Pelajaran_model->update($this->input->post('kode_pelajaran', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pelajaran'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Pelajaran_model->get_by_id($id);
		
		//jika id pelajaran yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Pelajaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelajaran'));
        } 
		//jika id pelajaran yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelajaran'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('kode_pelajaran', 'kode pelajaran', 'trim|required');
	$this->form_validation->set_rules('nama_pelajaran', 'nama pelajaran', 'trim|required');
	$this->form_validation->set_rules('kkm', 'kkm', 'trim|required');
	$this->form_validation->set_rules('semester', 'semester', 'trim|required');
	$this->form_validation->set_rules('id_kelas', 'id kelas', 'trim|required');

	$this->form_validation->set_rules('kode_pelajaran', 'kode_pelajaran', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

?>
