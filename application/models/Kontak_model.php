<?php
/********************************************************/
/* File        : Kontak_model.php                       */
/* Lokasi File : ./application/models/Kontak_model.php  */
/* Copyright   : Yosef Murya & Badiyanto                */
/* Publish     : Penerbit Langit Inspirasi              */
/*------------------------------------------------------*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Kontak_model
class Kontak_model extends CI_Model{
   
   // bagian properti   
   public $table = 'kontak';   
    
   // konstrutor    
   function __construct()
    {
        parent::__construct();
    }
   
    // Menambahkan data kedalam database
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }  

}

/* End of file Kontak_model.php */
/* Location: ./application/models/Kontak_model.php */
/* Please DO NOT modify this information : */