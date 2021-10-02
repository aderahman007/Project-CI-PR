<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class visi_misi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Visi_misi_model'); // Memanggil Dosen_model yang terdapat pada models
        $this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
        $this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
        $this->load->library('upload'); // Memanggil upload yang terdapat pada helper
        $this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }

    // Fungsi untuk menampilkan halaman utama visi misi
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
        $this->load->view('visi_misi/visi_misi_list');
        $this->load->view('footer_list'); // Menampilkan bagian footer
    }

    // Fungsi JSON
    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Visi_misi_model->json();
    }

    // Fungsi untuk menampilkan halaman dosen secara detail
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

        // Menampilkan data dosen yang ada di database berdasarkan id-nya yaitu id_dosen
        $row = $this->Visi_misi_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Read',
                'back'   => site_url('visi_misi'),
                'id' => $row->id,
                'visi' => $row->visi,
                'misi' => $row->misi,

            );

            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
            $this->load->view('visi_misi/visi_misi_read', $data); // Menampilkan halaman detail dosen
            $this->load->view('footer'); // Menampilkan bagian footer
        } else {
            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->load->view('footer'); // Menampilkan bagian footer
            redirect(site_url('visi_misi'));
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
            'action' => site_url('visi_misi/create_action'),
            'back'   => site_url('visi_misi'),
            'id' => set_value('id'),
            'visi' => set_value('visi'),
            'misi' => set_value('misi'),

        );

        $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('visi_misi/visi_misi_form', $data); // Menampilkan halaman form dosen
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

            $data = array(
                'visi' => $this->input->post('visi', TRUE),
                'misi' => $this->input->post('misi', TRUE),

            );

            $this->Visi_misi_model->insert($data);
        }
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('visi_misi'));
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

        // Menampilkan data berdasarkan id-nya yaitu id_dosen
        $row = $this->Visi_misi_model->get_by_id($id);

        // Jika id-nya dipilih maka data dosen ditampilkan ke form edit dosen
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('visi_misi/update_action'),
                'back'   => site_url('visi_misi'),
                'id' => set_value('id', $row->id),
                'visi' => set_value('visi', $row->visi),
                'misi' => set_value('misi', $row->misi),

            );

            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('visi_misi/visi_misi_form', $data); // Menampilkan form dosen
            $this->load->view('footer'); // Menampilkan bagian footer
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('visi_misi'));
        }
    }

    public function update_action()
    {

        // Jika session data username tidak ada maka akan dialihkan kehalaman login			
        if (!isset($this->session->userdata['username'])) {
            redirect(base_url("login"));
        }

        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	 	

        // Jika form mahasiswa belum diisi dengan benar 
        // maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        }
        // Jika form mahasiswa telah diisi dengan benar 
        // maka sistem akan melakukan update data mahasiswa kedalam database
        else {

            $data = array(
                'id' => $this->input->post('id', TRUE),
                'visi' => $this->input->post('visi', TRUE),
                'misi' => $this->input->post('misi', TRUE),

            );

            $this->Visi_misi_model->update($this->input->post('id', TRUE), $data);

            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('visi_misi'));
        }
    }

    // Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id)
    {

        // Jika session data username tidak ada maka akan dialihkan kehalaman login			
        if (!isset($this->session->userdata['username'])) {
            redirect(base_url("login"));
        }

        $row = $this->Visi_misi_model->get_by_id($id);

        //jika id id yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Visi_misi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('visi_misi'));
        }
        //jika id nim yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('visi_misi'));
        }
    }

    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules()
    {
        $this->form_validation->set_rules('visi', 'visi', 'required');
        $this->form_validation->set_rules('misi', 'misi', 'required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
