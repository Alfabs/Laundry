<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller 
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

	public function index()
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Paket Cucian";

		// Jumlah data per halaman
		$per_page = 5;

		// Ambil nomor halaman dari URL, defaultnya halaman 1
		$current_page = $this->input->get('page') ? $this->input->get('page') : 1;

		// Hitung offset
		$offset = ($current_page - 1) * $per_page;

			// Hitung total baris data dari tabel tb_paket
		$total_rows = $this->db->count_all_results('tb_paket'); // Menghitung total baris data dari tabel tb_paket

		// Hitung jumlah halaman
		$total_pages = ceil($total_rows / $per_page);

		// Menyimpan informasi pagination ke dalam array
		$data['pagination'] = [
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'total_pages' => $total_pages,
			'current_page' => $current_page
		];

		// Menggunakan SQL query untuk melakukan join antara tb_paket dan tb_outlet
		$this->db->select('tb_paket.*, tb_outlet.nama AS nama_outlet');
		$this->db->from('tb_paket');
		$this->db->join('tb_outlet', 'tb_paket.id_outlet = tb_outlet.id');
		$this->db->limit($per_page, $offset);
		$data['paket'] = $this->db->get()->result_array();  	

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/paket/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambahPaket()
	{
		$data['outlets'] = $this->db->get('tb_outlet')->result_array();
		$data['jenis'] = [
			"kiloan",
			"selimut",
			"bed_cover",
			"kaos",
			"lain"
		];	

		$this->form_validation->set_rules('id_outlet', 'Nama Outlet');
		$this->form_validation->set_rules('jenis', 'Jenis', 'required');
		$this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if ($this->form_validation->run() === FALSE) {
			// Validasi gagal, tampilkan kembali form dengan error
			$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['title'] = "Tambah Paket";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/paket/tambah', $data);
			$this->load->view('templates/footer');
		} else {
			// Validasi berhasil, lanjutkan proses penambahan paket
			$input_data = [
				'id_outlet' => htmlspecialchars($this->input->post('id_outlet')),
				'jenis' => htmlspecialchars($this->input->post('jenis')),
				'nama_paket' => htmlspecialchars($this->input->post('nama_paket')),
				'harga' => htmlspecialchars($this->input->post('harga'))
			];

			// Lakukan proses penyimpanan ke database atau operasi lainnya
			$this->db->insert('tb_paket', $input_data);
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Penambahan paket berhasil</div>');

			// Redirect ke halaman paket setelah berhasil menambahkan paket
			redirect('paket/');
		}
	}
	

	public function editPaket($id)
	{
		// Fetch data for the selected package by ID
		$data['paket'] = $this->db->get_where('tb_paket', ['id' => $id])->row_array();

		// Fetch data for dropdown options
		$data['outlets'] = $this->db->get('tb_outlet')->result_array();
		$data['jenis'] = [
			"kiloan",
			"selimut",
			"bed_cover",
			"kaos",
			"lain"
		];

		// Set validation rules
		$this->form_validation->set_rules('id_outlet', 'Nama Outlet', 'required');
		$this->form_validation->set_rules('jenis', 'Jenis', 'required');
		$this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if ($this->form_validation->run() === FALSE) {
			// If validation fails, load the edit form with errors
			$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['title'] = "Edit Paket";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/paket/edit', $data);
			$this->load->view('templates/footer');
		} else {
			// If validation succeeds, proceed with updating the package
			$input_data = [
				'id_outlet' => htmlspecialchars($this->input->post('id_outlet')),
				'jenis' => htmlspecialchars($this->input->post('jenis')),
				'nama_paket' => htmlspecialchars($this->input->post('nama_paket')),
				'harga' => htmlspecialchars($this->input->post('harga')),
			];

			// Update the package in the database
			$this->db->where('id', $id);
			$this->db->update('tb_paket', $input_data);

			// Redirect to the package list page after updating
			redirect('paket/');
		}
	}

	public function deletePaket($id)
	{
		$this->db->delete('tb_paket', ['id' => $id]);
		$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data paket berhasil dihapus</div>');
		redirect('paket/');
	}




}
