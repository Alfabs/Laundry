<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller 
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
	
	// controller pelanggan

	public function index()
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Pelanggan";
		

		// Jumlah data per halaman
		$per_page = 5;

		// Ambil nomor halaman dari URL, defaultnya halaman 1
		$current_page = $this->input->get('page') ? $this->input->get('page') : 1;

		// Hitung offset
		$offset = ($current_page - 1) * $per_page;

		// Hitung total baris data
		$total_rows = $this->db->count_all_results('tb_member');

		// Hitung jumlah halaman
		$total_pages = ceil($total_rows / $per_page);

		// Menyimpan informasi pagination ke dalam array
		$data['pagination'] = [
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'total_pages' => $total_pages,
			'current_page' => $current_page
		];

		// Query untuk join tb_member dengan tb_outlet
		$this->db->select('tb_member.*, tb_outlet.nama AS nama_outlet');
		$this->db->from('tb_member');
		$this->db->join('tb_outlet', 'tb_member.id_outlet = tb_outlet.id');

		// Mengambil data pelanggan dengan limit dan offset
		$this->db->limit($per_page, $offset);
		$data['pelanggan'] = $this->db->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pelanggan/index', $data);
		$this->load->view('templates/footer');
	}

		
	public function tambahPelanggan()
	{
			
		// Mendapatkan data outlet
    	$data['outlets'] = $this->db->get('tb_outlet')->result_array();

		$data['jk'] = [
			"L",
			"P"
		];

		$this->form_validation->set_rules('nama', 'Nama Outlet', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat Outlet', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('tlp', 'No Telepon', 'required|numeric');
		$this->form_validation->set_rules('id_outlet', 'Id Outlet');

		if ($this->form_validation->run() === FALSE) {
			// Validasi gagal, tampilkan kembali form dengan error
			$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['title'] = "Pelanggan";	

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pelanggan/tambah', $data);
			$this->load->view('templates/footer');
		} else {
			// Validasi berhasil, lanjutkan proses penambahan outlet
			$input_data = array(
				'nama' => htmlspecialchars($this->input->post('nama')),
				'id_outlet' => htmlspecialchars($this->input->post('id_outlet')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
				'tlp' => htmlspecialchars($this->input->post('tlp'))
			);

			// Lakukan proses penyimpanan ke database atau operasi lainnya
			$this->db->insert('tb_member', $input_data);
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Penambahan pelanggan Berhasil</div>');

			// Redirect ke halaman pelanggan setelah berhasil menambahkan pelanggan
			redirect('pelanggan');
		}
	}

	public function deletePelanggan($id)
	{
		$this->db->delete('tb_member', ['id' => $id]);
		$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data pelanggan berhasil dihapus</div>');
		redirect('pelanggan');
	}

	public function editPelanggan($id)
	{
		// Mendapatkan data outlet
    	$data['outlets'] = $this->db->get('tb_outlet')->result_array();
		// Mengambil data user yang sedang login
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['title'] = 'Edit Outlet';

        // Mengambil semua data menu
		$data['gender'] = [
			'L',
			'P'
		];
		
        $data['pelanggan'] = $this->db->get('tb_member')->result_array();
        $data['idPelanggan'] = $this->db->get_where('tb_member', ['id' => $id])->row_array();

		$data['input_jk'] = $this->input->post('jenis_kelamin');

        // Validasi data yang akan diedit
        $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat Pelanggan', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[L,P]');
		$this->form_validation->set_rules('tlp', 'No Telepon', 'required|numeric');
		$this->form_validation->set_rules('id_outlet', 'ID Outlet');

        // Jika validasi berhasil
        if($this->form_validation->run() == FALSE) {
            // Load view untuk tampilan edit menu
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pelanggan/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // Melakukan update data menu
            $input_data = array(
				'nama' => htmlspecialchars($this->input->post('nama')),
				'id_outlet' => htmlspecialchars($this->input->post('id_outlet')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
				'tlp' => htmlspecialchars($this->input->post('tlp'))
			);

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('tb_member', $input_data);
            $this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data pelanggan berhasil diubah!</div>');
            redirect('pelanggan');
        }
	}
}
