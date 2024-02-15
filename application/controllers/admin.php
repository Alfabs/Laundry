<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// require_once APPPATH.'third_party/tc-lib-pdf-main/src/tcpdf.php';
// use \Com\Tecnick\Pdf\Tcpdf;

class Admin extends CI_Controller 
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
		$data['title'] = "Admin Page";	
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
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
	}	

	// transaksi
	public function transaksi()
{
    Access_helper::check_admin_access();

    $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
    $data['title'] = "Transaksi";
    $data['outlets'] = $this->db->get('tb_outlet')->result_array();

    // Jumlah data per halaman
    $per_page = 5;

    // Ambil nomor halaman dari URL, defaultnya halaman 1
    $current_page = $this->input->get('page') ? $this->input->get('page') : 1;

    // Hitung offset
    $offset = ($current_page - 1) * $per_page;

	
    // Hitung total baris data
    $total_rows = $this->db->count_all_results('tb_transaksi');
	
    // Hitung jumlah halaman
    $total_pages = ceil($total_rows / $per_page);
	
    // Menyimpan informasi pagination ke dalam array
    $data['pagination'] = [
        'total_rows' => $total_rows,
        'per_page' => $per_page,
        'total_pages' => $total_pages,
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

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('transaksi/index', $data);
    $this->load->view('templates/footer');
}



	public function tambahTransaksi()
	{
		Access_helper::check_admin_access();

		$data['outlets'] = $this->db->get('tb_outlet')->result_array();
		$data['members'] = $this->db->get('tb_member')->result_array();
		$data['users'] = $this->db->get('tb_user')->result_array();
		$data['statuses'] = ['baru', 'selesai', 'proses', 'diambil'];
		$data['dibayar_options'] = ['dibayar', 'belum_dibayar'];

		$this->form_validation->set_rules('id_outlet', 'Nama Outlet', 'required');
		$this->form_validation->set_rules('id_member', 'Nama Member', 'required');
		$this->form_validation->set_rules('id_user', 'Nama User', 'required');
		$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
		$this->form_validation->set_rules('batas_waktu', 'Batas Waktu', 'required');
		$this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('dibayar', 'Dibayar', 'required');

		// Tangkap nilai tgl_bayar dari input form
		$input_tgl_bayar = $this->input->post('tgl_bayar');

		// Jika input_tgl_bayar tidak kosong, atur nilai tgl_bayar sesuai inputan yang diterima
		// Jika kosong, atur nilai tgl_bayar menjadi '0000-00-00 00:00:00'
		if (!empty($input_tgl_bayar)) {
			$tgl_bayar = date('Y-m-d H:i:s', strtotime($input_tgl_bayar));
		} else {
			$tgl_bayar = '0000-00-00 00:00:00'; // Nilai default
		}

		if ($this->form_validation->run() === FALSE) {
			// Validasi gagal, tampilkan kembali form dengan error
			$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
			$data['title'] = "Tambah Transaksi";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('transaksi/tambah', $data);
			$this->load->view('templates/footer');
		} else {
			// Validasi berhasil, lanjutkan proses penambahan transaksi
			$input_data = [
				'id_outlet' => htmlspecialchars($this->input->post('id_outlet')),
				'id_member' => htmlspecialchars($this->input->post('id_member')),
				'id_user' => htmlspecialchars($this->input->post('id_user')),
				'tgl' => date('Y-m-d H:i:s', strtotime($this->input->post('tgl'))),
				'batas_waktu' => date('Y-m-d H:i:s', strtotime($this->input->post('batas_waktu'))),
				'tgl_bayar' => $tgl_bayar, // Menggunakan nilai $tgl_bayar yang telah ditentukan
				'status' => htmlspecialchars($this->input->post('status')),
				'dibayar' => htmlspecialchars($this->input->post('dibayar'))
			];

			// Lakukan proses penyimpanan ke database atau operasi lainnya
			$this->db->insert('tb_transaksi', $input_data);
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Penambahan transaksi berhasil</div>');

			// Redirect ke halaman transaksi setelah berhasil menambahkan transaksi
			redirect('admin/transaksi');
		}
	}


	public function editTransaksi($id)
	{

		Access_helper::check_admin_access();

		// Mendapatkan data transaksi berdasarkan ID
		$data['transaksi'] = $this->db->get_where('tb_transaksi', ['id' => $id])->row_array();

		// Mendapatkan data outlet, member, dan user
		$data['optionsOutlet'] = $this->db->get('tb_outlet')->result_array();
		$data['optionsMember'] = $this->db->get('tb_member')->result_array();
		$data['optionsUser'] = $this->db->get('tb_user')->result_array();

		// Mendapatkan opsi status dan dibayar
		$data['optionsStatus'] = ['baru', 'selesai', 'proses', 'diambil'];
		$data['optionsDibayar'] = ['dibayar', 'belum_dibayar'];

		// Inisialisasi variabel yang digunakan untuk opsi terpilih
		$data['input_outlet'] = $data['transaksi']['id_outlet'];
		$data['input_member'] = $data['transaksi']['id_member'];
		$data['input_user'] = $data['transaksi']['id_user'];
		$data['input_status'] = $data['transaksi']['status'];
		$data['input_dibayar'] = $data['transaksi']['dibayar'];
		

		// Validasi form
		$this->form_validation->set_rules('id_outlet', 'Outlet', 'required');
		$this->form_validation->set_rules('id_member', 'Pelanggan', 'required');
		$this->form_validation->set_rules('id_user', 'User', 'required');
		$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
		$this->form_validation->set_rules('batas_waktu', 'Batas Waktu');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('dibayar', 'Dibayar', 'required');
		$this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar'); // Tambah aturan validasi untuk Tanggal Bayar

		if ($this->form_validation->run() === FALSE) {
			// Validasi gagal, tampilkan kembali form dengan error
				$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
				$data['title'] = "Edit Transaksi";

				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('transaksi/edit', $data);
				$this->load->view('templates/footer');

		} else {
			// Jika validasi berhasil, dapatkan data dari form
			$input_data = [
				'id_outlet' => $this->input->post('id_outlet'),
				'id_member' => $this->input->post('id_member'),
				'id_user' => $this->input->post('id_user'),
				'tgl' => date('Y-m-d H:i:s', strtotime($this->input->post('tgl'))),
				'batas_waktu' => date('Y-m-d H:i:s', strtotime($this->input->post('batas_waktu'))),
				'tgl_bayar' => date('Y-m-d H:i:s', strtotime($this->input->post('tgl_bayar'))), // Ambil nilai Tanggal Bayar dari form
				'status' => $this->input->post('status'),
				'dibayar' => $this->input->post('dibayar')
			];

			// Lakukan proses penyimpanan ke database atau operasi lainnya
			$this->db->where('id', $id);
			$this->db->update('tb_transaksi', $input_data);
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Perubahan transaksi berhasil</div>');

			// Redirect ke halaman transaksi setelah berhasil mengubah transaksi
			redirect('admin/transaksi');
		}
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
		$this->load->view('transaksi/detail', $data);
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

	public function updateTanggalBayar()
	{
		// Tangkap data yang dikirim dari form
		$transaksiId = $this->input->post('transaksi_id');
		$tglBayarBaru = $this->input->post('tgl_bayar');

		// Lakukan proses update tanggal bayar di database menggunakan model atau langsung di sini
		// ...
		$this->db->where('id', $id);
		$this->db->update('tb_transaksi', $tglBayarBaru);
		
	}



	public function blocked()
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = 'ACCESS DENIED !!!';
		
 		$this->load->view('templates/header', $data);
 		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
 		$this->load->view('blocked', $data);
 	 	//$this->load->view('templates/user/footer');
	}
}
