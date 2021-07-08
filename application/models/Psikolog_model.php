<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Psikolog_model extends CI_Model
{
    public function data($number, $offset)
    {
        return $this->db->get('psikolog', $number, $offset)->result();
    }

    public function jumlah_psikolog()
    {
        return $this->db->get('psikolog')->num_rows();
    }
    public function delete($id_psikolog)
    {
        $this->db->where('id_psikolog', $id_psikolog);
        $this->db->delete('psikolog');
    }
}
