<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('access_helper');
		// Access_helper::check_admin_access();
	}

	public function index()
	{
		if($this->session->userdata('username')){
			redirect('blocked/');
		}

		$this->form_validation->set_rules('username', 'Username', 'trim|required',[
			'required' => 'Username harus diisi'
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|required',[
			'required' => 'Password harus diisi'
		]);
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'User Login';
			$this->load->view('templates/auth/header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth/footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->input->post('username'); // Mengambil input username dari form
		$password = $this->input->post('password');

		$user = $this->db->get_where('tb_user', ['username' => $username])->row_array();
		
		if ($user) {
			// Hapus pengecekan is_active karena kolom tersebut tidak ada
			if (password_verify($password, $user['password'])) {    
				$data = [
					'username' => $user['username'],
					'role' => $user['role']
				];
				$this->session->set_userdata($data);
				// Sesuaikan kondisi redirect berdasarkan peran (role) pengguna
				if ($user['role'] == 'admin') {
					redirect('admin');
				} else if($user['role'] == 'owner'){
					redirect('owner');
				} else if($user['role'] == 'kasir'){
					redirect('kasir');
				} 
			} else {
				$this->session->set_flashdata('register', '<div class="alert alert-danger" role="alert">Password Salah!</div>');
				redirect('auth');
			}
		} else { 
			$this->session->set_flashdata('register', '<div class="alert alert-danger" role="alert">Username ini tidak terdaftar!</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role');
		$this->session->set_flashdata('register', '<div class="alert alert-success" role="alert">Kamu berhasil Logout</div>');

		redirect('auth'); // Redirect kembali ke halaman login atau halaman lain yang sesuai
	}




}
