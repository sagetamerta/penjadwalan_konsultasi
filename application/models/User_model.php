<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_model extends CI_Model
{
    public function user()
    {
        return $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    }
}
