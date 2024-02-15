<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// require_once APPPATH.'third_party/tc-lib-pdf-main/src/tcpdf.php';
// use \Com\Tecnick\Pdf\Tcpdf;

class Blocked extends CI_Controller 
{

	public function index()
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
