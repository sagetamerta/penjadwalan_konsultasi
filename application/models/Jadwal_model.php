<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Jadwal_model extends CI_Model
{
    public function data($table, $number, $offset)
    {
        return $this->db->get($table, $number, $offset)->result();
    }
    public function dataJoin($table, $number, $offset)
    {
        $this->db
            ->select('*')
            ->from($table)
            ->join('hari', 'hari.id_hari = jadwal.id_hari')
            ->join('sesi', 'sesi.id_sesi = jadwal.id_sesi')
            ->join('psikolog', 'psikolog.id_psikolog = jadwal.id_psikolog')
            ->order_by('id_jadwal', 'ASC')
            ->limit($number, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function addJadwal()
    {
        $jadwalterbaik = $this->input->post('jadwalTerbaik'); //string => ubah jadi array int

        $newjadwal = array_map('intval', explode(',', $jadwalterbaik)); //array int
        $banyak_per_hari = ceil(count($newjadwal) / $this->db->get('hari')->num_rows());
        $banyak_per_sesi = ceil($banyak_per_hari / $this->db->get('sesi')->num_rows());
        $id_hari = array_chunk($newjadwal, $banyak_per_hari); //array dibagi seberapa banyak psikolog perhari yg akan dibagi menjadi 3 sesi

        $data_jadwal = array(
            'id_jadwal' => '',
            'verifikasi' => 0,
        );
        $this->db->insert('jadwal', $data_jadwal);

        $this->db->from('jadwal');
        $this->db->order_by('id_jadwal', 'desc');
        $id_jadwal = $this->db->get()->row_array();

        for ($i = 0; $i < count($id_hari); $i++) {
            $id_sesi = array_chunk($id_hari[$i], $banyak_per_sesi);
            for ($j = 0; $j < count($id_sesi); $j++) {
                $id_psikolog = array_chunk($id_sesi[$j], 1);
                for ($k = 0; $k < count($id_psikolog); $k++) {
                    $data = array(
                        'id_jadwal' => $id_jadwal['id_jadwal'],
                        'id_hari' => ($i + 1),
                        'id_sesi' => ($j + 1),
                        'id_psikolog' => implode($id_psikolog[$k]),
                    );
                    $this->db->insert('jadwal_detail', $data);
                }
            }
        }
    }

    public function editJadwal()
    {
        $id_jadwal = htmlspecialchars($this->input->post('id_jadwal'));
        $verifikasi = htmlspecialchars($this->input->post('verifikasi'));

        $data = array(
            'verifikasi' => $verifikasi
        );

        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->update('jadwal', $data);
    }

    public function deleteJadwal($id_jadwal)
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->delete('jadwal');
    }

    public function addHari()
    {
        $nama_hari = htmlspecialchars($this->input->post('nama_hari'));

        $data = array(
            'nama_hari' => $nama_hari
        );
        $this->db->insert('hari', $data);
    }

    public function editHari()
    {
        $id_hari = htmlspecialchars($this->input->post('id_hari'));
        $nama_hari = htmlspecialchars($this->input->post('nama_hari'));

        $data = array(
            'nama_hari' => $nama_hari
        );

        $this->db->where('id_hari', $id_hari);
        $this->db->update('hari', $data);
    }

    public function deleteHari($id_hari)
    {
        $this->db->where('id_hari', $id_hari);
        $this->db->delete('hari');
    }

    public function addSesi()
    {
        $nama_sesi = htmlspecialchars($this->input->post('nama_sesi'));

        $data = array(
            'nama_sesi' => $nama_sesi
        );
        $this->db->insert('sesi', $data);
    }

    public function editSesi()
    {
        $id_sesi = htmlspecialchars($this->input->post('id_sesi'));
        $nama_sesi = htmlspecialchars($this->input->post('nama_sesi'));

        $data = array(
            'nama_sesi' => $nama_sesi
        );

        $this->db->where('id_sesi', $id_sesi);
        $this->db->update('sesi', $data);
    }

    public function deleteSesi($id_sesi)
    {
        $this->db->where('id_sesi', $id_sesi);
        $this->db->delete('sesi');
    }
}
