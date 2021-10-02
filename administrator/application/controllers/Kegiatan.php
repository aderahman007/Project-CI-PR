<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Kegiatan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Kegiatan_model');
        $this->load->model('Users_model');
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library     
        $this->load->helper(array('form', 'url')); // Memanggil form dan url yang terdapat pada helper
        $this->load->library('upload'); // Memanggil upload yang terdapat pada helper
        $this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
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


        $this->load->view('header_list', $dataAdm); // Menampilkan bagian header dan object data users 	
        $this->load->view('kegiatan/kegiatan_list'); // Menampilkan halaman utama kegiatan
        $this->load->view('footer_list'); // Menampilkan bagian footer
    }

    // Fungsi JSON
    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kegiatan_model->json(); // Menampilkan data json yang terdapat pada Kegiatan_model
    }

    // Fungsi untuk menampilkan halaman mahasiswa secara detail
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

        // Menampilkan data kegiatan yang ada di database berdasarkan id-nya yaitu nim
        $row = $this->Kegiatan_model->get_by_id($id);

        // Jika data kegiatan tersedia maka akan ditampilkan
        if ($row) {
            $data = array(
                'button' => 'Read',
                'back'   => site_url('kegiatan'),
                'id_kegiatan' => $row->id_kegiatan,
                'nama_kegiatan' => $row->nama_kegiatan,
                'galery' => $row->galery,
                'deskripsi' => $row->deskripsi,

            );
            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
            $this->load->view('kegiatan/kegiatan_read', $data); // Menampilkan halaman detail kegiatan
            $this->load->view('footer'); // Menampilkan bagian footer
        }
        // Jika data kegiatan tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
        else {
            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->load->view('footer'); // Menampilkan bagian footer
            redirect(site_url('kegiatan'));
        }
    }

    // Fungsi menampilkan form Create kegiatan
    public function create()
    {
        // Jika session data username tidak ada maka akan dialihkan kehalaman login			
        if (!isset($this->session->userdata['username'])) {
            redirect(base_url("login"));
        }

        // Menampilkan data berdasarkan id-nya yaitu username
        $row = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = array(
            'wa'       => 'Web administrator',
            'univ'     => 'Sekolah Polisi Negara Polda Lampung',
            'username' => $row->username,
            'email'    => $row->email,
            'level'    => $row->level,
        );

        // Menampung data yang diinputkan 
        $data = array(
            'button' => 'Create',
            'back'   => site_url('kegiatan'),
            'action' => site_url('kegiatan/create_action'),
            'id_kegiatan' => set_value('id_kegiatan'),
            'nama_kegiatan' => set_value('nama_kegiatan'),
            'galery' => set_value('galery'),
            'deskripsi' => set_value('deskripsi'),
        );
        $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('kegiatan/kegiatan_form', $data); // Menampilkan form kegiatan
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

        // Jika form kegiatan belum diisi dengan benar 
        // maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        // Jika form kegiatan telah diisi dengan benar 
        // maka sistem akan menyimpan kedalam database
        else {
            // konfigurasi untuk melakukan upload gambar
            $config['upload_path']   = '../images/kegiatan/';    //path folder image
            $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
            $config['file_name']     = url_title($this->input->post('nama_kegiatan')); //nama file galery dirubah menjadi nama berdasarkan nama_kegiatan	
            $this->upload->initialize($config);

            // Jika file galery ada 
            if (!empty($_FILES['galery']['name'])) {

                if ($this->upload->do_upload('galery')) {
                    $galery = $this->upload->data();
                    $dataGalery = $galery['file_name'];
                    $this->load->library('upload', $config);

                    $data = array(
                        'id_kegiatan' => $this->input->post('id_kegiatan', TRUE),
                        'nama_kegiatan' => $this->input->post('nama_kegiatan', TRUE),
                        'galery' => $dataGalery,
                        'deskripsi' => $this->input->post('deskripsi', TRUE),
                    );
                    
                    $this->Kegiatan_model->insert($data);
                }

                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('kegiatan'));
            }
            // Jika file gambar kosong 
            else {

                $data = array(
                    'id_kegiatan' => $this->input->post('id_kegiatan', TRUE),
                    'nama_kegiatan' => $this->input->post('nama_kegiatan', TRUE),
                    'deskripsi' => $this->input->post('deskripsi', TRUE),
                );
                
                $this->Kegiatan_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('kegiatan'));
            }
        }
    }

    // Fungsi menampilkan form Update Jurusan
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

        // Menampilkan data berdasarkan id-nya yaitu Kegiatan
        $row = $this->Kegiatan_model->get_by_id($id);

        // Jika id-nya dipilih maka data Kegiatan ditampilkan ke form edit Kegiatan
        if ($row) {

            $data = array(
                'button' => 'Update',
                'back'   => site_url('kegiatan'),
                'action' => site_url('kegiatan/update_action'),
                'id_kegiatan' => set_value('id_kegiatan', $row->id_kegiatan),
                'nama_kegiatan' => set_value('nama_kegiatan', $row->nama_kegiatan),
                'galery' => set_value('galery', $row->galery),
                'deskripsi' => set_value('deskripsi', $row->deskripsi),
            );
            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('kegiatan/kegiatan_form', $data); // Menampilkan form kegiatan 
            $this->load->view('footer'); // Menampilkan bagian footer
        }
        // Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kegiatan'));
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

        // Jika form kegiatan belum diisi dengan benar 
        // maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kegiatan', TRUE));
        }
        // Jika form kegiatan telah diisi dengan benar 
        // maka sistem akan melakukan update data Kegiatan kedalam database
        else {
            // Konfigurasi untuk melakukan upload gambar
            $config['upload_path']   = '../images/kegiatan/';    //path folder
            $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg		
            $config['overwrite']     = true;	
            $config['file_name']     = url_title($this->input->post('nama_kegiatan')); //nama file galery dirubah menjadi nama berdasarkan nama_kegiatan	
            $this->upload->initialize($config);

            // Jika file galery ada 
            if (!empty($_FILES['galery']['name'])) {

                // Menghapus file image lama
                // unlink("../images/kegiatan/" . $this->input->post('galery'));

                // Upload file image baru
                if ($this->upload->do_upload('galery')) {
                    $galery = $this->upload->data();
                    $dataGalery = $galery['file_name'];
                    $this->load->library('upload', $config);

                    $data = array(
                        'id_kegiatan' => $this->input->post('id_kegiatan', TRUE),
                        'nama_kegiatan' => $this->input->post('nama_kegiatan', TRUE),
                        'galery' => $dataGalery,
                        'deskripsi' => $this->input->post('deskripsi', TRUE),
                    );

                    $this->Kegiatan_model->update($this->input->post('id_kegiatan', TRUE), $data);
                }
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('kegiatan'));
            }
            // Jika file gambar kosong 
            else {

                $data = array(
                    'id_kegiatan' => $this->input->post('id_kegiatan', TRUE),
                    'nama_kegiatan' => $this->input->post('nama_kegiatan', TRUE),
                    'deskripsi' => $this->input->post('deskripsi', TRUE),
                );


                $this->Kegiatan_model->update($this->input->post('id_kegiatan', TRUE), $data);
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('kegiatan'));
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

        $row = $this->Kegiatan_model->get_by_id($id);

        //jika id nim yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Kegiatan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');

            // menghapus file gambar
            unlink("../images/kegiatan/" . $row->galery);
            redirect(site_url('kegiatan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kegiatan'));
        }
    }

    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules()
    {
        $this->form_validation->set_rules('id_kegiatan', 'id_kegiatan', 'trim|required');
        $this->form_validation->set_rules('nama_kegiatan', 'nama kegiatan', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');

        $this->form_validation->set_rules('id_kegiatan', 'id_kegiatan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
