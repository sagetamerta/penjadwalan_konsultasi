<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->User_model->user();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->User_model->user();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAdd()
    {
        $this->Admin_model->roleAdd();
        redirect('admin/role');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        New Role has been added!</div>');
    }

    public function roleEdit()
    {
        $this->Admin_model->roleEdit();
        redirect('admin/role');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        New Role has been added!</div>');
    }

    public function roleDelete($role_id)
    {
        $this->Admin_model->roleDelete();
        redirect('admin/role');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Role has been deleted!</div>');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->User_model->user();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $this->Admin_model->changeAccess();

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Access Changed!</div>');
    }
}
