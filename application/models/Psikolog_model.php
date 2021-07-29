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

    public function addPsikolog()
    {
        $nama_psikolog = htmlspecialchars($this->input->post('nama_psikolog'));
        $notelp_psikolog = htmlspecialchars($this->input->post('notelp_psikolog'));
        $alamat_psikolog = htmlspecialchars($this->input->post('alamat_psikolog'));

        $data = array(
            'nama_psikolog' => $nama_psikolog,
            'notelp_psikolog' => $notelp_psikolog,
            'alamat_psikolog' => $alamat_psikolog
        );
        $this->db->insert('psikolog', $data);
    }

    public function editPsikolog()
    {
        $id_psikolog = htmlspecialchars($this->input->post('id_psikolog'));
        $nama_psikolog = htmlspecialchars($this->input->post('nama_psikolog'));
        $notelp_psikolog = htmlspecialchars($this->input->post('notelp_psikolog'));
        $alamat_psikolog = htmlspecialchars($this->input->post('alamat_psikolog'));

        $data = array(
            'nama_psikolog' => $nama_psikolog,
            'notelp_psikolog' => $notelp_psikolog,
            'alamat_psikolog' => $alamat_psikolog,
        );

        $this->db->where('id_psikolog', $id_psikolog);
        $this->db->update('psikolog', $data);
    }

    public function deletePsikolog($id_psikolog)
    {
        $this->db->where('id_psikolog', $id_psikolog);
        $this->db->delete('psikolog');
    }
}
