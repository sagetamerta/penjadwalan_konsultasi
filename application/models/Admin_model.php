<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Admin_model extends CI_Model
{
    public function roleAdd()
    {
        $role = htmlspecialchars($this->input->post('role'));

        $data = array(
            'role' => $role
        );

        $this->db->insert('user_role', $data);
    }

    public function roleEdit()
    {

        $id = htmlspecialchars($this->input->post('id'));
        $role = htmlspecialchars($this->input->post('role'));

        $this->db->set('role', $role)->where('id', $id)->update('user_role');
    }
}
