<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model');
    }
    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->User_model->user();
        $data['menu'] = $this->Menu_model->getMenu();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->addMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    New menu added!</div>');
            redirect('menu');
        }
    }

    public function menuDelete($menu_id)
    {
        $this->Menu_model->deleteMenu($menu_id);
        redirect('menu');
    }

    public function subMenudelete($sub_menu_id)
    {
        $this->Menu_model->deleteSubmenu($sub_menu_id);
        redirect('menu/submenu');
    }

    public function subMenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->User_model->user();
        $data['subMenu'] = $this->Menu_model->getSubMenu();
        $data['menu'] = $this->Menu_model->getMenu();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->addSubmenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    New sub menu added!</div>');
            redirect('menu/submenu');
        }
    }

    public function subMenuedit()
    {
        $this->Menu_model->subMenuedit();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Sub menu Edited!</div>');
        redirect('menu/submenu');
    }
}
