<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('access_helper');
		Access_helper::check_admin_access();
		// is_logged_in();
	}

	// Controller Outlet
	public function index()
	{

		
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Outlet";	
		$data['outlet'] = $this->db->get('tb_outlet')->result_array();
		
		// Konfigurasi paginasi
        $per_page = 5;
        $current_page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
        
        // Hitung total baris data
        $total_rows = $this->db->count_all_results('tb_outlet');

        $data['outlet'] = $this->db->limit($per_page, ($current_page - 1) * $per_page)->get('tb_outlet')->result_array();

        $data['pagination'] = [
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'total_pages' => ceil($total_rows / $per_page),
            'current_page' => $current_page
        ];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/outlet/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambahOutlet()
	{
		$this->form_validation->set_rules('nama', 'Nama Outlet', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat Outlet', 'required');
		$this->form_validation->set_rules('tlp', 'No Telepon', 'required|numeric');

		if ($this->form_validation->run() === FALSE) {
			// Validasi gagal, tampilkan kembali form dengan error
			$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['title'] = "Outlet";	

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/outlet/tambah_outlet', $data);
			$this->load->view('templates/footer');
		} else {
			// Validasi berhasil, lanjutkan proses penambahan outlet
			$input_data = array(
				'nama' => htmlspecialchars($this->input->post('nama')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'tlp' => htmlspecialchars($this->input->post('tlp'))
			);

			// Lakukan proses penyimpanan ke database atau operasi lainnya
			$this->db->insert('tb_outlet', $input_data);
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Penambahan Outlet Berhasil</div>');

			// Redirect ke halaman outlet setelah berhasil menambahkan outlet
			redirect('outlet/');
		}
	}

	public function deleteOutlet($id)
	{
		$this->db->delete('tb_outlet', ['id' => $id]);
		$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data Outlet berhasil dihapus</div>');
		redirect('outlet/');
	}

	public function editOutlet($id)
	{
 		// Mengambil data user yang sedang login
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Edit Outlet';

        // Mengambil semua data menu
        $data['outlet'] = $this->db->get('tb_outlet')->result_array();
        $data['idOutlet'] = $this->db->get_where('tb_outlet', ['id' => $id])->row_array();

        // Validasi data yang akan diedit
        $this->form_validation->set_rules('nama', 'Nama Outlet', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat Outlet', 'required');
		$this->form_validation->set_rules('tlp', 'No Telepon', 'required|numeric');

        // Jika validasi berhasil
        if($this->form_validation->run() == FALSE) {
            // Load view untuk tampilan edit menu
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/outlet/edit_outlet', $data);
            $this->load->view('templates/footer');
        } else {
            // Melakukan update data menu
            $input_data = array(
				'nama' => htmlspecialchars($this->input->post('nama')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'tlp' => htmlspecialchars($this->input->post('tlp'))
			);

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('tb_outlet', $input_data);
            $this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data Outlet berhasil diubah!</div>');
            redirect('outlet/');
        }
	}
	//end controller outlet

}
