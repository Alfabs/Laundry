<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');		
		$this->load->helper('access_helper');
		Access_helper::check_kasir_access();
		// is_logged_in();
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Kasir Page";	
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
		$this->load->view('kasir/index', $data);
		$this->load->view('templates/footer');
	}
	

	// controller pelanggan

	public function pelanggan()
	{
		$user = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Pelanggan";

		// Mengambil id outlet yang dimiliki oleh kasir yang login
		
    	$id_outlet_kasir = $user['id_outlet'];
		$data['user'] = $user;
		$data['outlett'] = $id_outlet_kasir;
		

		// Jumlah data per halaman
		$per_page = 5;

		// Ambil nomor halaman dari URL, defaultnya halaman 1
		$current_page = $this->input->get('page') ? $this->input->get('page') : 1;

		// Hitung offset
		$offset = ($current_page - 1) * $per_page;

		// Hitung total baris data
		$this->db->where('id_outlet', $id_outlet_kasir);
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
		$this->db->where_in('tb_member.id_outlet', $id_outlet_kasir);
		$this->db->limit($per_page, $offset);
		$data['pelanggan'] = $this->db->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kasir/pelanggan', $data);
		$this->load->view('templates/footer');
	}

		
	public function tambahPelanggan()
	{

		// Mendapatkan ID Outlet kasir yang login
		$user = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$id_outlet_kasir = $user['id_outlet'];
			
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
			$data['id_outlet'] = $id_outlet_kasir;

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('kasir/tambah_pelanggan', $data);
			$this->load->view('templates/footer');
		} else {
			// Validasi berhasil, lanjutkan proses penambahan outlet
			$input_data = array(
				'nama' => htmlspecialchars($this->input->post('nama')),
				'id_outlet' => $id_outlet_kasir,
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
				'tlp' => htmlspecialchars($this->input->post('tlp'))
			);

			// Lakukan proses penyimpanan ke database atau operasi lainnya
			$this->db->insert('tb_member', $input_data);
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Penambahan pelanggan Berhasil</div>');

			// Redirect ke halaman pelanggan setelah berhasil menambahkan pelanggan
			redirect('kasir/pelanggan/');
		}
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
            $this->load->view('kasir/edit_pelanggan', $data);
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
            redirect('kasir/pelanggan');
        }
	}

	// transaksi
	public function transaksi()
	{


		$user = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Transaksi";
		$data['outlets'] = $this->db->get('tb_outlet')->result_array();

		$data['user'] = $user;
		$id_outlet_kasir = $user['id_outlet'];

		// Jumlah data per halaman
		$per_page = 5;

		// Hitung total baris data
		$this->db->where('id_outlet', $id_outlet_kasir);
		$total_rows = $this->db->count_all_results('tb_transaksi');

		// Hitung jumlah halaman
		$total_pages = ceil($total_rows / $per_page);

		// Ambil nomor halaman dari URL, defaultnya halaman 1
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

		// Hitung offset
		$offset = ($current_page - 1) * $per_page;

		// Mengambil data transaksi dengan JOIN untuk menggabungkan tabel-tabel yang bersangkutan
		$this->db->select('tb_transaksi.*, tb_outlet.nama AS nama_outlet, tb_member.nama AS nama_member, tb_user.nama AS nama_user');
		$this->db->from('tb_transaksi');
		$this->db->join('tb_outlet', 'tb_outlet.id = tb_transaksi.id_outlet');
		$this->db->join('tb_member', 'tb_member.id = tb_transaksi.id_member');
		$this->db->join('tb_user', 'tb_user.id = tb_transaksi.id_user');
		$this->db->where_in('tb_transaksi.id_outlet', $id_outlet_kasir);
		$this->db->limit($per_page, $offset);
		$data['transaksi'] = $this->db->get()->result_array();

		// Menyimpan informasi pagination ke dalam array
		$data['pagination'] = [
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'total_pages' => $total_pages,
			'current_page' => $current_page
		];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kasir/transaksi', $data);
		$this->load->view('templates/footer');
	}


	public function tambahTransaksi()
{
    // Mendapatkan ID Outlet kasir yang login
    $user = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
    $id_outlet_kasir = $user['id_outlet'];

    $data['outlett'] = $id_outlet_kasir;
    
    $data['outlets'] = $this->db->get('tb_outlet')->result_array();
    $members = $this->db->get_where('tb_member', ['id_outlet' => $id_outlet_kasir])->result_array();
    $users = $this->db->get_where('tb_user', ['id_outlet' => $id_outlet_kasir])->result_array();
    $data['statuses'] = ['baru', 'selesai', 'proses', 'diambil'];
    $data['dibayar_options'] = ['dibayar', 'belum_dibayar'];

    $data['members'] = $members;
    $data['users'] = $users;

    $this->form_validation->set_rules('id_outlet', 'Nama Outlet');
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
        $data['id_outlet'] = $id_outlet_kasir;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kasir/tambah_transaksi', $data);
        $this->load->view('templates/footer');
    } else {
        // Validasi berhasil, lanjutkan proses penambahan transaksi
        
        $input_data = [
            'id_outlet' => $id_outlet_kasir,
            'id_member' => htmlspecialchars($this->input->post('id_member')),
            'tgl' => date('Y-m-d H:i:s', strtotime($this->input->post('tgl'))),
            'batas_waktu' => date('Y-m-d H:i:s', strtotime($this->input->post('batas_waktu'))),
            'tgl_bayar' => $tgl_bayar, // Menggunakan nilai $tgl_bayar yang telah ditentukan
            'status' => htmlspecialchars($this->input->post('status')),
            'dibayar' => htmlspecialchars($this->input->post('dibayar')),
            'id_user' => htmlspecialchars($this->input->post('id_user'))
        ];

		

        // Lakukan proses penyimpanan ke database atau operasi lainnya
        $this->db->insert('tb_transaksi', $input_data);
        $this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Penambahan transaksi berhasil</div>');

        // Redirect ke halaman transaksi setelah berhasil menambahkan transaksi
        redirect('kasir/transaksi');
    }
}



	public function editTransaksi($id)
	{


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
		$this->form_validation->set_rules('batas_waktu', 'Batas Waktu', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('dibayar', 'Dibayar', 'required');
		$this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'required'); // Tambah aturan validasi untuk Tanggal Bayar

		if ($this->form_validation->run() === FALSE) {
			// Validasi gagal, tampilkan kembali form dengan error
				$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
				$data['title'] = "Edit Transaksi";

				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('kasir/edit_transaksi', $data);
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
			redirect('kasir/transaksi/');
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
		$this->load->view('kasir/detail_transaksi', $data);
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
