<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('access_helper');
		Access_helper::check_owner_access();
		// is_logged_in();
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Owner Page";	
		$data['paket'] = $this->db->get('tb_paket')->result_array();

		// Jumlah data per halaman
		$per_page = 5;

		// Hitung total baris data
		$total_rows_transaksi = $this->db->count_all_results('tb_transaksi');

		// Hitung jumlah halaman
		$total_pages_transaksi = ceil($total_rows_transaksi / $per_page);

		// Menyimpan informasi pagination ke dalam array
		
		
		// Ambil nomor halaman dari URL, defaultnya halaman 1
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
		
		// Hitung offset
		$offset = ($current_page - 1) * $per_page;
		
		$data['pagination_transaksi'] = [
			'total_rows' => $total_rows_transaksi,
			'per_page' => $per_page,
			'total_pages' => $total_pages_transaksi,
			'current_page' => $current_page
		];

		// Mengambil data transaksi dengan JOIN untuk menggabungkan tabel-tabel yang bersangkutan
		$this->db->select('tb_transaksi.*, tb_outlet.nama AS nama_outlet, tb_member.nama AS nama_member, tb_user.nama AS nama_user');
		$this->db->from('tb_transaksi');
		$this->db->join('tb_outlet', 'tb_outlet.id = tb_transaksi.id_outlet');
		$this->db->join('tb_member', 'tb_member.id = tb_transaksi.id_member');
		$this->db->join('tb_user', 'tb_user.id = tb_transaksi.id_user');
		$this->db->limit($per_page, $offset);
		$data['transaksi'] = $this->db->get()->result_array();

		// Query untuk menghitung jumlah transaksi berdasarkan status
		$data['jumlah_status_baru'] = $this->db->where('status', 'baru')->from('tb_transaksi')->count_all_results();
		$data['jumlah_status_selesai'] = $this->db->where('status', 'selesai')->from('tb_transaksi')->count_all_results();
		$data['jumlah_status_proses'] = $this->db->where('status', 'proses')->from('tb_transaksi')->count_all_results();
		$data['jumlah_status_diambil'] = $this->db->where('status', 'diambil')->from('tb_transaksi')->count_all_results();

		// Query untuk menghitung jumlah yang sudah dibayar dan yang belum dibayar
		$data['jumlah_dibayar'] = $this->db->where('dibayar', 'sudah')->from('tb_transaksi')->count_all_results();
		$data['jumlah_belum_dibayar'] = $this->db->where('dibayar', 'belum')->from('tb_transaksi')->count_all_results();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('owner/index', $data);
		$this->load->view('templates/footer');
	}

	public function detailTransaksi($id)
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Detail Transaksi";

		// Mengambil data transaksi berdasarkan ID
		$this->db->select('tb_transaksi.*, tb_outlet.nama AS nama_outlet, tb_member.nama AS nama_member, tb_user.nama AS nama_user');
		$this->db->from('tb_transaksi');
		$this->db->join('tb_outlet', 'tb_outlet.id = tb_transaksi.id_outlet');
		$this->db->join('tb_member', 'tb_member.id = tb_transaksi.id_member');
		$this->db->join('tb_user', 'tb_user.id = tb_transaksi.id_user');
		$this->db->where('tb_transaksi.id', $id);
		$data['detail_transaksi'] = $this->db->get()->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('owner/detail_transaksi', $data);
		$this->load->view('templates/footer');
	}

	public function generatePDF($id)
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Detail Transaksi";

		// Mengambil data transaksi berdasarkan ID
		$this->db->select('tb_transaksi.*, tb_outlet.nama AS nama_outlet, tb_member.nama AS nama_member, tb_user.nama AS nama_user');
		$this->db->from('tb_transaksi');
		$this->db->join('tb_outlet', 'tb_outlet.id = tb_transaksi.id_outlet');
		$this->db->join('tb_member', 'tb_member.id = tb_transaksi.id_member');
		$this->db->join('tb_user', 'tb_user.id = tb_transaksi.id_user');
		$this->db->where('tb_transaksi.id', $id);
		$data['detail_transaksi'] = $this->db->get()->row_array();

		// Load library PDF
		$this->load->library('pdf');

		// Render view detail_transaksi ke dalam variabel $html
		$html = $this->load->view('kasir/laporan', $data, true);

		// Create PDF
		$pdf = new Pdf();
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Detail Transaksi');


		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('detail_transaksi.pdf', 'I'); // Tampilkan PDF secara langsung (Inline) atau sesuaikan dengan kebutuhanmu
	}
}


