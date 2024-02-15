<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
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

	//controller user
	// Mengambil data user dengan nama outlet
	public function index()
	{
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Pengguna";    

		// Jumlah data per halaman
		$per_page = 5;

		// Hitung total baris data
		$this->db->where_in('role', ['kasir', 'owner']);
		$total_rows = $this->db->count_all_results('tb_user');

		// Hitung jumlah halaman
		$total_pages = ceil($total_rows / $per_page);

		// Ambil nomor halaman dari URL, defaultnya halaman 1
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

		// Hitung offset
		$offset = ($current_page - 1) * $per_page;

		
		// Menyimpan informasi pagination ke dalam array
		$data['pagination'] = [
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'total_pages' => $total_pages,
			'current_page' => $current_page
		];

		// Query untuk mengambil data pengguna dengan limit dan offset
		$this->db->select('tb_user.id, tb_user.nama, tb_user.username, tb_user.role, tb_outlet.nama AS nama_outlet');
		$this->db->from('tb_user');
		$this->db->join('tb_outlet', 'tb_user.id_outlet = tb_outlet.id', 'left');
		$this->db->where_in('tb_user.role', ['kasir', 'owner']);
		$this->db->limit($per_page, $offset);
		$data['users'] = $this->db->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/user/index', $data);
		$this->load->view('templates/footer');
	}


	public function deleteUser($id)
	{
		$this->db->delete('tb_user', ['id' => $id]);
		$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data user berhasil dihapus</div>');
		redirect('user/');
	}

	public function tambahUser()
	{

		$optionsRole = [
			"kasir",
			"owner",
			"admin"
		];
		
		// Ambil data outlet dari tb_outlet
    	$data['outlets'] = $this->db->get('tb_outlet')->result_array();
		$data['optionsRole'] = $optionsRole;
		$data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
		$data['title'] = "Tambah User";	

		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('username', 'Email', 'required|trim|is_unique[tb_user.username]',[
			'is_unique' => 'Username ini sudah terpakai'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]',[
			'matches' => 'Password Tidak sesuai! ',
			'min_length' => 'Password minimal 4 karakter'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[4]|matches[password1]');
		$this->form_validation->set_rules('idoutlet', 'ID Outlet', 'numeric');
    	$this->form_validation->set_rules('role', 'Role', 'required');


		if($this->form_validation->run() == FALSE) 
		{
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/user/tambah_user', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'nama' => htmlspecialchars($this->input->post('nama', true)),
				'username' => htmlspecialchars($this->input->post('username', true)),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'id_outlet' => htmlspecialchars($this->input->post('idoutlet', true)),
				'role' => htmlspecialchars($this->input->post('role', true))
			];

			$this->db->insert('tb_user', $data);  
			$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Your account has been registered successfully, please login</div>');
			redirect('user/');
		}
	}


	public function editUser($id)
{
    $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
    $data['title'] = 'Edit User';
    $data['idUser'] = $this->db->get_where('tb_user', ['id' => $id])->row_array();
    $data['outlets'] = $this->db->get('tb_outlet')->result_array();

    // Array untuk role pada options
    $optionsRole = [
        'admin',
        'owner',
        'kasir'
        // Tambahkan role lainnya jika diperlukan
    ];

    $data['optionsRole'] = $optionsRole;

    $data['input_role'] = $this->input->post('role');

    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, tampilkan kembali form dengan error
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/user/edit_user', $data); // Ganti dengan nama file view yang sesuai
        $this->load->view('templates/footer');
    } else {
        // Jika validasi berhasil, lakukan update data user
        $input_data = array(
            'nama' => htmlspecialchars($this->input->post('nama')),
            'username' => htmlspecialchars($this->input->post('username')),
            'role' => htmlspecialchars($this->input->post('role'))
        );

        // Periksa jika peran berubah menjadi 'admin', kosongkan atau hapus data outlet
        if ($input_data['role'] === 'admin') {
            $input_data['id_outlet'] = null;
        } else {
            // Jika peran bukan 'admin', simpan id_outlet sesuai yang dipilih
            $input_data['id_outlet'] = htmlspecialchars($this->input->post('idoutlet'));
        }

        // Lanjutkan proses update data
        $this->db->where('id', $id);
        $this->db->update('tb_user', $input_data);
        $this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Data user berhasil diubah!</div>');
        redirect('user/');
    }
}


}
