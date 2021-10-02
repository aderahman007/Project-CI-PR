<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  // Deklarasi pembuatan class Login_model
  class Login_model extends CI_Model {
		
	  // Fungsi untuk melakukan cek username dan password pada database
      function cek($username, $password) {
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        return $this->db->get("users");
      }
		
	  // Jika username dan password cocok 
      function getLoginData($user, $pass) {
        $u = $user;
        $p = md5($pass);
        $query_cekLogin = $this->db->get_where('users', array('username' => $u, 'password' => $p));
        if (count($query_cekLogin->result()) > 0) {
          foreach ($query_cekLogin->result() as $qck) {
            foreach ($query_cekLogin->result() as $qad) {
              $sess_data['logged_in'] = TRUE;             
              $sess_data['username'] = $qad->username;
              $sess_data['password'] = $qad->password;             
              $sess_data['level'] = $qad->level;
              $this->session->set_userdata($sess_data);
            }
          redirect('admin');
          }
        } 
		else {
			// Jika username dan password tidak cocok
            $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
            header('location:' . base_url() . 'login');
          }
      }
  }

?>