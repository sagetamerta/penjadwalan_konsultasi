<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Menu_model extends CI_Model
{
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }
    public function getSubMenu()
    {
        $this->db->select('user_sub_menu.*,user_menu.menu');
        $this->db->from('user_sub_menu');
        $this->db->join('user_menu', 'user_sub_menu.menu_id = user_menu.id');
        return  $this->db->get()->result_array();
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
}
