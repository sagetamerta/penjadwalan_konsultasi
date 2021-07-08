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

    public function roleDelete($role_id)
    {
        $this->db->where('id', $role_id);
        $this->db->delete('user_role');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
    }
}
