<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_model extends CI_Model
{
    public function user()
    {
        return $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    }

    public function editUser()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');

        $data['user'] = $this->user();

        //cek jika ada gambar yang akan diupload
        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['upload_path'] = './assets/img/profile/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']     = '2048';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $old_image = $data['user']['image'];
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/profile/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                redirect('user');
            }
        }
        $this->db->set('name', $name);
        $this->db->where('email', $email);
        $this->db->update('user');
    }

    public function changePasswordUser()
    {
        $data['user'] = $this->user();
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');

        if (!password_verify($current_password, $data['user']['password'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong current Password!</div>');
            redirect('user/changepassword');
        } else {
            if ($current_password == $new_password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                New password cannot be the same as current password!</div>');
                redirect('user/changepassword');
            } else {
                // password sudah ok
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $this->db->set('password', $password_hash);
                $this->db->where('email', $this->session->userdata('email'));
                $this->db->update('user');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Password changed!</div>');
                redirect('user/changepassword');
            }
        }
    }
}
