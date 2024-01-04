<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }


    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->dispay_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function data_barang()
    {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['barang'] = $this->db->get('barang')->result_array();

        $data['rak'] = [1,2,3,4,5];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/data_barang', $data);
        $this->load->view('templates/footer');
    }

    public function getBarang()
    {
        $kode_barang = $this->input->post('kode_barang');
        $dataExp = $this->db->get_where('kode', ['kode_barang' => $kode_barang])->result();

        echo json_encode($dataExp);
    }

    public function addProduct()
    {

        $this->form_validation->set_rules('nama_barang', 'Nama_Barang', 'required|trim');
        $this->form_validation->set_rules('kode_barang', 'Kode_Barang', 'required|trim');
        $this->form_validation->set_rules('no_rak', 'No_Rak', 'required|trim');
        $this->form_validation->set_rules('qty', 'Qty', 'required|trim');
        $this->form_validation->set_rules('tgl_produksi', 'Tgl_Produksi', 'required|trim');
        $this->form_validation->set_rules('tgl_expired', 'Tgl_Expired', 'required|trim');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Data Barang';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/data_barang', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama_barang' => htmlspecialchars($this->input->post('nama_barang', true)),
                'kode_barang' => htmlspecialchars($this->input->post('kode_barang', true)),
                'no_rak' => htmlspecialchars($this->input->post('no_rak', true)),
                'qty' => htmlspecialchars($this->input->post('qty', true)),
                'tgl_produksi' => date('Y-m-d', strtotime($this->input->post('tgl_produksi'))),
                'tgl_expired' => date('Y-m-d', strtotime($this->input->post('tgl_expired')))
            ];

            $this->db->insert('barang', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Ditambah!</div>');
            redirect('user/data_barang');
        }
    }

    public function deleteProduct($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('barang');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Dihapus!</div>');
            redirect('user/data_barang');
    }

    public function editProduct($id)
    {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required|trim');
        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required|trim');
        $this->form_validation->set_rules('no_rak', 'no_rak', 'required|trim');
        $this->form_validation->set_rules('tgl_produksi', 'tgl_produksi', 'required|trim');
        $this->form_validation->set_rules('tgl_expired', 'tgl_expired', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $kode_barang = $this->input->post('kode_barang');
            $nama_barang = $this->input->post('nama_barang');
            $no_rak = $this->input->post('no_rak');
            $tgl_produksi = $this->input->post('tgl_produksi');
            $tgl_expired = $this->input->post('tgl_expired');


            // var_dump($id,$kode_barang,$nama_barang,$no_rak,$tgl_expired,$tgl_produksi);
            $this->db->set(['kode_barang' => $kode_barang, 'nama_barang' => $nama_barang, 'no_rak' => $no_rak, 'tgl_produksi' => $tgl_produksi, 'tgl_expired' => $tgl_expired]);
            $this->db->where('id', $id);
            $this->db->update('barang');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang Berhasil Di Update!</div>');
            redirect('user/data_barang');
        }
    }

    public function notifikasi()
    {
        $data['title'] = 'Barang Expired';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['barang'] = $this->db->get_where('barang', ['status' => ''])->result_array();

        $data['rak'] = [1,2,3,4,5];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/notifikasi', $data);
        $this->load->view('templates/footer');
    }

    public function getDataExp()
    {
        $no_rak = $this->input->post('no_rak');
        $dataExp = $this->db->get_where('barang', ['no_rak' => $no_rak, 'status' => ''])->result_array();

        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        echo json_encode($dataExp);
    }

    public function retur()
    {
        $data['title'] = 'Retur';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['retur'] = $this->db->get_where('retur')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/retur', $data);
        $this->load->view('templates/footer');
    }

    public function return()
    {
        $data = [

            'nama_peretur' => $this->input->post('nama_peretur'),
           'nama_barang' => $this->input->post('nama_barang'),
           'kode_barang' => $this->input->post('kode_barang'),
           'qty' => $this->input->post('qty'),
           'tgl_retur' => date('Y-m-d')

        ];

        $this->db->insert('retur', $data);


        $this->db->set('status', 'retur');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('barang');

        echo json_encode('berhasil');
    }
}
