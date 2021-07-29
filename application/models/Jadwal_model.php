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
            ->limit($number, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function addJadwal()
    {
        $kode_jadwal = $this->input->post('kode_jadwal');
        $banyak_per_sesi = $this->input->post('banyak_per_sesi'); //harusnya nilainya 3 ya buat testing
        $jadwalterbaik = $this->input->post('jadwalTerbaik'); //string => ubah jadi array int

        $newjadwal = array_map('intval', explode(',', $jadwalterbaik)); //array int
        $id_hari = array_chunk($newjadwal, $banyak_per_sesi); //array dibagi seberapa banyak psikolog perhari yg akan dibagi menjadi 3 sesi

        for ($i = 0; $i < count($id_hari); $i++) {
            $id_sesi = array_chunk($id_hari[$i], 2);
            for ($j = 0; $j < count($id_sesi); $j++) {
                $id_psikolog = array_chunk($id_sesi[$j], 1);
                for ($k = 0; $k < count($id_psikolog); $k++) {
                    $data = array(
                        'kode_jadwal' => $kode_jadwal,
                        'id_hari' => ($i + 1),
                        'id_sesi' => ($j + 1),
                        'id_psikolog' => implode($id_psikolog[$k])
                    );
                    $this->db->insert('jadwal', $data);
                }
            }
        }
    }

    public function deleteJadwal($kode_jadwal)
    {
        $this->db->where('kode_jadwal', $kode_jadwal);
        $this->db->delete('jadwal');
    }
}
