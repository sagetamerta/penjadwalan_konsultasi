<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Psikolog_model extends CI_Model
{
    public function data($number, $offset)
    {
        return $query = $this->db->get('psikolog', $number, $offset)->result();
    }

    public function jumlah_psikolog()
    {
        return $this->db->get('psikolog')->num_rows();
    }
}
