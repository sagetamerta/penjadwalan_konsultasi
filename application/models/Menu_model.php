<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Menu_model extends CI_Model
{
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    public function getSubMenu($id = null)
    {
        $this->db->select('user_sub_menu.*,user_menu.*');
        $this->db->from('user_sub_menu');
        $this->db->join('user_menu', 'user_sub_menu.menu_id = user_menu.id');
        if ($id != null) {
            $this->db->where('menu_id', $id);
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
    }

    public function addMenu()
    {
        return $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
    }

    public function deleteMenu($menu_id)
    {
        $this->db->where('id', $menu_id);
        $this->db->delete('user_menu');
    }

    public function deleteSubmenu($sub_menu_id)
    {
        $this->db->where('id', $sub_menu_id);
        $this->db->delete('user_sub_menu');
    }

    public function addSubmenu()
    {
        $data = [
            'title' => $this->input->post('title'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active_sub')
        ];
        $this->db->insert('user_sub_menu', $data);
    }

    public function subMenuedit()
    {
        $id = htmlspecialchars($this->input->post('id'));
        $data = [
            'menu_id' => htmlspecialchars($this->input->post('menu_id')),
            'title' => htmlspecialchars($this->input->post('title')),
            'url' => htmlspecialchars($this->input->post('url')),
            'icon' => htmlspecialchars($this->input->post('icon')),
            'is_active' => htmlspecialchars($this->input->post('is_active_sub'))
        ];

        $this->db->set($data)
            ->where('id', $id)
            ->update('user_sub_menu');
    }
}
