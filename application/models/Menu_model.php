<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Menu_model extends CI_Model
{
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    public function getMenuById($id = null)
    {
        return $this->db->get_where('menu', ['id' => $id])->row_array();
    }

    public function addMenu()
    {
        return $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
    }

    public function editMenu()
    {
        $id = htmlspecialchars($this->input->post('id'));
        $menu = htmlspecialchars($this->input->post('menu'));

        $this->db->set('menu', $menu)->where('id', $id)->update('user_menu');
    }

    public function deleteMenu($menu_id)
    {
        $this->db->where('id', $menu_id);
        $this->db->delete('user_menu');
    }

    public function getSubMenu($id = null)
    {
        // $this->db->select('user_sub_menu.*,user_menu.*')
        //     ->from('user_sub_menu')
        //     ->join('user_menu', 'user_sub_menu.menu_id = user_menu.id');

        // SELECT 
        // user_sub_menu.*,
        // user_sub_menu.`id` AS sub_menu_id,
        // user_menu.id AS menu_id,
        // user_menu.`menu`
        // FROM user_sub_menu
        // INNER JOIN user_menu
        // ON user_sub_menu.`menu_id` = user_menu.`id`

        $this->db->select('user_sub_menu.*, user_sub_menu.id as sub_menu_id, user_menu.id as menu_id, user_menu.menu');
        $this->db->from('user_sub_menu');
        $this->db->join('user_menu', 'user_sub_menu.menu_id = user_menu.id');
        if ($id != null) {
            $this->db->where('menu_id', $id);
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
    }

    public function getSubMenuById($id = null)
    {
        return $this->db->get_where('submenu', ['id' => $id])->row_array();
    }

    public function addSubmenu()
    {
        $data = [
            'title' => $this->input->post('title'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active')
        ];
        $this->db->insert('user_sub_menu', $data);
    }

    public function editSubMenu()
    {
        $id = htmlspecialchars($this->input->post('id'));
        $title = htmlspecialchars($this->input->post('title'));
        $menu_id = htmlspecialchars($this->input->post('menu_id'));
        $url = htmlspecialchars($this->input->post('url'));
        $icon = htmlspecialchars($this->input->post('icon'));
        $is_active = htmlspecialchars($this->input->post('is_active'));
        $this->db
            ->set('title', $title)
            ->set('menu_id', $menu_id)
            ->set('url', $url)
            ->set('icon', $icon)
            ->set('is_active', $is_active)
            ->where('id', $id)->update('user_sub_menu');
    }

    public function deleteSubmenu($sub_menu_id)
    {
        $this->db->where('id', $sub_menu_id);
        $this->db->delete('user_sub_menu');
    }
}
